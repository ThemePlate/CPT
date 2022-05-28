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

		$this->initialize( $taxonomy, $args );

	}


	public function labels( string $singular, string $plural ): self {

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

		return $this;

	}


	public function associate( string $identifier ): self {

		$this->object_type[] = $identifier;

		return $this;

	}


	public function hook(): void {

		register_taxonomy( $this->taxonomy, $this->object_type, $this->args );

		add_filter( 'term_updated_messages', array( $this, 'custom_messages' ) );

	}


	public function custom_messages( array $messages ): array {

		$singular = $this->args['labels']['singular_name'];
		$plural   = $this->args['labels']['name'];

		$messages[ $this->taxonomy ] = array(
			0 => '',
			1 => $singular . ' added.',
			2 => $singular . ' deleted.',
			3 => $singular . ' updated.',
			4 => $singular . ' not added.',
			5 => $singular . ' not updated.',
			6 => $plural . ' deleted.',
		);

		return $messages;

	}

}
