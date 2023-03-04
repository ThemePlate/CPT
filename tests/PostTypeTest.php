<?php

/**
 * @package ThemePlate
 */

namespace Tests;

use ThemePlate\CPT\PostType;
use WP_UnitTestCase;

class PostTypeTest extends WP_UnitTestCase {
	use TestProvider;

	public function test_register(): void {
		$config = array(
			'name'     => 'portfolio',
			'plural'   => 'Portfolios',
			'singular' => 'Portfolio',
			'args'     => array(
				'has_archive'   => true,
				'menu_position' => 5,
				'menu_icon'     => 'dashicons-media-document',
				'supports'      => array( 'title', 'editor', 'thumbnail' ),
			),
		);

		$type = new PostType( $config['name'], $config['args'] );

		$type->labels( $config['singular'], $config['plural'] );
		$type->register();

		$this->assertArrayHasKey( $config['name'], get_post_types() );

		$type = get_post_type_object( $config['name'] );

		$this->assertSame( $config['plural'], $type->label );
		$this->assertSame( $config['args']['has_archive'], $type->has_archive );
		$this->assertSame( $config['args']['menu_position'], $type->menu_position );
		$this->assertSame( $config['args']['menu_icon'], $type->menu_icon );
		$this->assertTrue( $type->public );
		$this->assertTrue( $type->show_in_rest );
		$this->assertFalse( $type->rewrite['with_front'] );

		foreach ( $config['args']['supports'] as $feature ) {
			$this->assertTrue( post_type_supports( $config['name'], $feature ) );
		}
	}

	public function test_defaults_applied(): void {
		$name = 'test';
		$type = new PostType( $name );

		$type->register();

		$object = get_post_type_object( $name );

		foreach ( $type->defaults() as $key => $value ) {
			$this->assertObjectHasAttribute( $key, $object );

			if ( is_array( $value ) ) {
				continue;
			}

			$this->assertSame( $value, $object->$key );
		}
	}

	public function test_late_taxonomy_association(): void {
		( new PostType( 'test' ) )->associate( 'this' )->register();

		$type = get_post_type_object( 'test' );

		$this->assertArrayHasKey( 'this', array_fill_keys( $type->taxonomies, '' ) );
		$this->assertTrue( true );
	}

	/**
	 * @dataProvider for_name_parsing
	 */
	public function test_minimal_register( string $name, string $singular, string $plural, string $slug ): void {
		( new PostType( $name ) )->register();

		$type = get_post_type_object( $name );

		$this->assertSame( $singular, $type->labels->singular_name );
		$this->assertSame( $plural, $type->label );
		$this->assertSame( $slug, $type->rewrite['slug'] );
	}

	public function test_slug_applied_is_from_parsed_name(): void {
		$name   = 'test';
		$expect = 'tests';

		( new PostType( $name ) )->register();

		$type = get_post_type_object( $name );

		$this->assertSame( $expect, $type->rewrite['slug'] );
	}

	public function test_slug_applied_is_from_plural_label(): void {
		$name = 'test';

		( new PostType( $name ) )->labels( 'Want', 'Wants' )->register();

		$type = get_post_type_object( $name );

		$this->assertSame( strtolower( $type->label ), $type->rewrite['slug'] );
	}

	public function test_slug_applied_is_from_custom_arg(): void {
		$name = 'test';
		$args = array( 'rewrite' => array( 'slug' => 'custom' ) );

		( new PostType( $name, $args ) )->labels( 'Want', 'Wants' )->register();

		$type = get_post_type_object( $name );

		$this->assertNotSame( strtolower( $type->label ), $type->rewrite['slug'] );
		$this->assertSame( $args['rewrite']['slug'], $type->rewrite['slug'] );
	}

	public function test_rewrite_if_non_public(): void {
		$name = 'test';
		$args = array( 'public' => false );

		( new PostType( $name, $args ) )->labels( 'Want', 'Wants' )->register();

		$type = get_post_type_object( $name );

		$this->assertFalse( $type->rewrite );
	}

	public function for_use_editor(): array {
		return array(
			'nothing set' => array( null, true ),
			'set classic' => array( true, false ),
			'force block' => array( false, true ),
		);
	}

	/** @dataProvider for_use_editor */
	public function test_use_editor( ?bool $classic_editor, bool $expect ): void {
		$post_type = 'test';

		$args = null === $classic_editor ? array() : compact( 'classic_editor' );

		( new PostType( $post_type, $args ) )->register();

		$this->assertSame( $expect, use_block_editor_for_post_type( $post_type ) );
	}

	public function test_for_messages_filter(): void {
		$post_type = 'test';

		( new PostType( $post_type ) )->register();
		global $post, $post_type_object;

		// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
		$post             = get_post( $this->factory()->post->create( compact( 'post_type' ) ) );
		$post_type_object = get_post_type_object( $post_type );
		$output           = apply_filters( 'post_updated_messages', array() );
		// phpcs:enable WordPress.WP.GlobalVariablesOverride.Prohibited

		$this->assertArrayHasKey( $post_type, $output );
	}

	public function test_for_bulk_messages_filter(): void {
		$post_type = 'test';

		( new PostType( $post_type ) )->register();
		global $post, $post_type_object;

		// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
		$post             = get_post( $this->factory()->post->create( compact( 'post_type' ) ) );
		$post_type_object = get_post_type_object( $post_type );
		$bulk_counts      = array(
			'updated'   => 0,
			'locked'    => 0,
			'deleted'   => 0,
			'trashed'   => 0,
			'untrashed' => 0,
		);
		// phpcs:enable WordPress.WP.GlobalVariablesOverride.Prohibited

		$output = apply_filters( 'bulk_post_updated_messages', array(), $bulk_counts );

		$this->assertArrayHasKey( $post_type, $output );
		$this->assertSame( array_keys( $bulk_counts ), array_keys( $output[ $post_type ] ) );
	}
}
