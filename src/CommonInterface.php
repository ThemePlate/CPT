<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\CPT;

interface CommonInterface {

	public function labels( string $singular, string $plural ): self;

	public function associate( string $identifier ): self;

	public function register(): void;

	public function hook(): void;

}
