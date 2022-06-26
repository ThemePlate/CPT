# ThemePlate CPT

## Usage

```php
use ThemePlate\CPT\PostType;
use ThemePlate\CPT\Taxonomy;

// One-liner
( new PostType( 'vehicle' ) )->register();
( new Taxonomy( 'brand' ) )->register();
```

### Full customization
```php
/** https://developer.wordpress.org/reference/functions/register_post_type/#parameters */
$args   = array(
	'has_archive' => true,
	'supports'    => array( 'title', 'editor', 'thumbnail' ),
);
$person = new PostType( 'person', $args );

// Custom singular and plural
$person->labels( 'Person', 'People' );
$person->register();


/** https://developer.wordpress.org/reference/functions/register_taxonomy/#parameters */
$args = array(
	'hierarchical' => true,
	'default_term' => 'Unknown',
);
$job  = new Taxonomy( 'job', $args );

// Custom singular and plural
$job->labels( 'Job Title', 'Job Titles' );
$job->register();
```

### Associations
```php
( new PostType( 'house' ) )->associate( 'category' )->register();
( new PostType( 'furniture' ) )->associate( 'category' )->register();
( new Taxonomy( 'style' ) )->associate( 'house' )->associate( 'furniture' )->register();
```
