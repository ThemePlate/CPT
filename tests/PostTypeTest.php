<?php

/**
 * @package ThemePlate
 */

namespace Tests;

use ThemePlate\CPT\PostType;
use WP_UnitTestCase;

class PostTypeTest extends WP_UnitTestCase {
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

	public function test_late_taxonomy_association(): void {
		( new PostType( 'test' ) )->associate( 'this' )->register();

		$type = get_post_type_object( 'test' );

		$this->assertArrayHasKey( 'this', array_fill_keys( $type->taxonomies, '' ) );
		$this->assertTrue( true );
	}

	public function for_minimal_register(): array {
		return array(
			'with string ending "x"'   => array( 'fox', 'Fox', 'Foxes', 'foxes' ),
			'with string ending "ss"'  => array( 'truss', 'Truss', 'Trusses', 'trusses' ),
			'with string ending "sh"'  => array( 'dish', 'Dish', 'Dishes', 'dishes' ),
			'with string ending "ch"'  => array( 'torch', 'Torch', 'Torches', 'torches' ),
			'with string ending "as"'  => array( 'gas', 'Gas', 'Gases', 'gases' ),
			'with string ending "us"'  => array( 'bus', 'Bus', 'Buses', 'buses' ),
			'with string ending "y"'   => array( 'battery', 'Battery', 'Batteries', 'batteries' ),
			'with string ending "sis"' => array( 'genesis', 'Genesis', 'Geneses', 'geneses' ),
			'with string ending "s"'   => array( 'lens', 'Lens', 'Lens', 'lens' ),
			'with string ending !"s"'  => array( 'test', 'Tests', 'Tests', 'tests' ),
		);
	}

	/**
	 * @dataProvider for_minimal_register
	 */
	public function test_minimal_register( string $name, string $singular, string $plural, string $slug ): void {
		( new PostType( $name ) )->register();

		$type = get_post_type_object( $name );

		$this->assertSame( $plural, $type->label );
		$this->assertSame( $slug, $type->rewrite['slug'] );
	}
}
