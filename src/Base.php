<?php

/**
 * Setup custom posts and taxonomies
 *
 * @package ThemePlate
 * @since 0.1.0
 */

namespace ThemePlate\CPT;

abstract class Base implements CommonInterface {

	protected array $args;
	protected array $defaults = array(
		'labels'       => array(),
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => array(
			'with_front' => false,
		),
	);


	public function register(): void {

		if ( did_action( 'init' ) ) {
			$this->hook();
		} else {
			add_action( 'init', array( $this, 'hook' ) );
		}

	}

}
