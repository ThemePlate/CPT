# ThemePlate CPT

## Usage

```php
use ThemePlate\CPT\PostType;
use ThemePlate\CPT\Taxonomy;

$args  = array(
	'supports' => array( 'title', 'editor', 'thumbnail' ),
	'rewrite'  => array( 'slug' => 'houses' ),
);
$house = new PostType( 'house', $args );

$house->labels( 'House', 'Houses' );
$house->register();

( new PostType( 'furniture' ) )->register();

$style = new Taxonomy( 'style', array( 'house', 'furniture' ) );

$style->labels( 'Style', 'Styles' );
$style->register();
```
