<?php

/**
 * Setup custom taxonomies
 *
 * @package ThemePlate
 * @since 0.1.0
 */

namespace ThemePlate\CPT;

class Taxonomy extends Base {

	protected string $taxonomy;
	protected array $object_type;


	public function __construct( string $taxonomy, array $object_type = array(), array $args = array() ) {

		$this->taxonomy    = $taxonomy;
		$this->object_type = $object_type;
		$this->args        = array_merge( $this->defaults, $args );

	}


	public function labels( string $singular, string $plural ): void {

		$labels = array(
			'name'                       => $plural,
			'singular_name'              => $singular,
			'search_items'               => 'Search ' . $plural,
			'popular_items'              => 'Popular ' . $plural,
			'all_items'                  => 'All ' . $plural,
			'parent_item'                => 'Parent ' . $singular,
			'parent_item_colon'          => 'Parent ' . $singular . ':',
			'edit_item'                  => 'Edit ' . $singular,
			'view_item'                  => 'View ' . $singular,
			'update_item'                => 'Update ' . $singular,
			'add_new_item'               => 'Add New ' . $singular,
			'new_item_name'              => 'New ' . $singular . ' Name',
			'separate_items_with_commas' => 'Separate ' . strtolower( $plural ) . ' with commas',
			'add_or_remove_items'        => 'Add or remove ' . strtolower( $plural ),
			'choose_from_most_used'      => 'Choose from the most used ' . strtolower( $singular ),
			'not_found'                  => 'No ' . strtolower( $plural ) . ' found.',
			'no_terms'                   => 'No ' . strtolower( $plural ),
			'items_list_navigation'      => $plural . ' list navigation',
			'items_list'                 => $plural . ' list',
			'most_used'                  => 'Most Used ' . $plural,
			'back_to_items'              => '&larr; Back to ' . $plural,
			'menu_name'                  => $plural,
			'name_admin_bar'             => $singular,
		);

		$this->args['labels'] = array_merge( $this->args['labels'], $labels );

	}


	public function hook(): void {

		register_taxonomy( $this->taxonomy, $this->object_type, $this->args );

	}

}
