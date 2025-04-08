<?php

/**
 * @package ThemePlate
 */

namespace Tests;

trait TestProvider {
	/** @return array<string, string[]> */
	public function for_name_parsing(): array {
		return array(
			'with string ending "x"'   => array( 'fox', 'foxes', 'Fox', 'Foxes' ),
			'with string ending "ss"'  => array( 'truss', 'trusses', 'Truss', 'Trusses' ),
			'with string ending "sh"'  => array( 'dish', 'dishes', 'Dish', 'Dishes' ),
			'with string ending "ch"'  => array( 'torch', 'torches', 'Torch', 'Torches' ),
			'with string ending "as"'  => array( 'gas', 'gases', 'Gas', 'Gases' ),
			'with string ending "us"'  => array( 'bus', 'buses', 'Bus', 'Buses' ),
			'with string ending "y"'   => array( 'battery', 'batteries', 'Battery', 'Batteries' ),
			'with string ending "sis"' => array( 'genesis', 'geneses', 'Genesis', 'Geneses' ),
			'with string ending "s"'   => array( 'lens', 'lens', 'Lens', 'Lens' ),
			'with string ending !"s"'  => array( 'test', 'tests', 'Test', 'Tests' ),
		);
	}
}
