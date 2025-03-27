<?php

/**
 * Setup custom post types
 *
 * @package ThemePlate
 * @since 0.1.0
 */

namespace ThemePlate\CPT\Interfaces;

interface PostTypeInterface {

	public function position( int $position ): self;

	public function archive( bool $archive ): self;

	public function classic( bool $classic ): self;

}
