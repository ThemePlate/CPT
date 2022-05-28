<?php

/**
 * @package ThemePlate
 */

namespace Tests;

use ThemePlate\CPT\Taxonomy;
use WP_UnitTestCase;

class TaxonomyTest extends WP_UnitTestCase {
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
		$tax = new Taxonomy( 'test' );

		$tax->associate( 'this' );
		$tax->register();

		$tax = get_taxonomy( 'test' );

		$this->assertArrayHasKey( 'this', array_fill_keys( $tax->object_type, '' ) );
	}
}
