<?php

/**
 * @package ThemePlate
 */

namespace Tests;

use ThemePlate\CPT\Taxonomy;
use WP_UnitTestCase;

class TaxonomyTest extends WP_UnitTestCase {
	use TestProvider;

	public function test_register(): void {
		$config = array(
			'name'     => 'classification',
			'plural'   => 'Classifications',
			'singular' => 'Classification',
			'type'     => 'post',
			'args'     => array(
				'hierarchical' => true,
			),
		);

		$tax = new Taxonomy( $config['name'], array( $config['type'] ), $config['args'] );

		$tax->labels( $config['singular'], $config['plural'] );
		$tax->register();

		$this->assertArrayHasKey( $config['name'], get_taxonomies() );

		$tax = get_taxonomy( $config['name'] );

		$this->assertSame( $config['plural'], $tax->label );
		$this->assertSame( $config['args']['hierarchical'], $tax->hierarchical );
		$this->assertTrue( $tax->public );
		$this->assertTrue( $tax->show_in_rest );
		$this->assertFalse( $tax->rewrite['with_front'] );
	}

	public function test_late_post_type_association(): void {
		( new Taxonomy( 'test' ) )->associate( 'this' )->register();

		$tax = get_taxonomy( 'test' );

		$this->assertArrayHasKey( 'this', array_fill_keys( $tax->object_type, '' ) );
	}

	/**
	 * @dataProvider for_name_parsing
	 */
	public function test_minimal_register( string $name, string $singular, string $plural, string $slug ): void {
		( new Taxonomy( $name ) )->register();

		$tax = get_taxonomy( $name );

		$this->assertSame( $plural, $tax->label );
		$this->assertSame( $slug, $tax->rewrite['slug'] );
	}

	public function test_for_messages_filter(): void {
		$taxonomy = 'test';

		( new Taxonomy( $taxonomy ) )->register();

		$output = apply_filters( 'term_updated_messages', array() );

		$this->assertArrayHasKey( $taxonomy, $output );
	}
}
