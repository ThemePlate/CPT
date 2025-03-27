<?php

/**
 * Setup custom taxonomies
 *
 * @package ThemePlate
 * @since 0.1.0
 */

namespace ThemePlate\CPT\Interfaces;

interface TaxonomyInterface {

	public function hierarchical( bool $hierarchical ): self;

	public function column( bool $column ): self;

}
