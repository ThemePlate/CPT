# ThemePlate CPT

## Usage

```php
use ThemePlate\CPT;

$args = array(
	'plural'   => 'Testers',
	'singular' => 'Tester',
	// 'labels'       => array(),
	// 'public'       => true,
	// 'show_in_rest' => true,
	// 'rewrite'      => array(),
);
```

### Post Type
```php
$args['name'] = 'tester-post-type';

new CPT\PostType( $args );
```

### Taxonomy
```php
$args['name'] = 'tester-taxonomy';
$args['type'] = 'tester-post-type';

new CPT\Taxonomy( $args );
```
