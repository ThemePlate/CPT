<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\CPT;

interface CommonInterface {

	public function labels( string $singular, string $plural ): void;

	public function register(): void;

	public function hook(): void;

}