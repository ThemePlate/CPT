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
}
