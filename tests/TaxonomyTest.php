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

		new Taxonomy( $config );

		$this->assertArrayHasKey( $config['name'], get_taxonomies() );

		$tax = get_taxonomy( $config['name'] );

		$this->assertSame( $config['plural'], $tax->label );
		$this->assertSame( $config['args']['hierarchical'], $tax->hierarchical );
		$this->assertTrue( $tax->public );
		$this->assertTrue( $tax->show_in_rest );
		$this->assertFalse( $tax->rewrite['with_front'] );
	}
}
