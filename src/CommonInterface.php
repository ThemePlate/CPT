<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\CPT;

interface CommonInterface {

	public function defaults(): array;

	public function config( array $config ): self;

	public function public( bool $is_public ): self;

	public function labels( string $singular, string $plural ): self;

	public function associate( string $identifier ): self;

	public function register(): void;

	public function hook(): void;

	public function custom_messages( array $messages ): array;

}
