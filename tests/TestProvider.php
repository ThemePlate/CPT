<?php

/**
 * @package ThemePlate
 */

namespace Tests;

trait TestProvider {
	public function for_name_parsing(): array {
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
}
