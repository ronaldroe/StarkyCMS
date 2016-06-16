# Starky CMS
### A PHP Headless Content Management System by Ronald Roe

# Documentation

###*Starky( array $args = null )*
- Base class. Accepts an expanded set of the StarkyCMS standard args associative array. See args documentation for list of accepted arguments.


##CRUD Operations
###*get_posts( array $args = null )*
- Return type: array
- Public method available on a Starky instance.
- Accepts StarkyCMS standard args associative array. See args documentation for list of accepted arguments.
```PHP
$example = new Starky();

$args = [
	'post_type' => 'post'
];

$posts = $example->get_posts( $args );
```








##Starky Standard Arguments

###*col_names (associative array)*

- *post_id (int)*
- *title (string)*
- *author_name (string)*
- *date_created (datetime)*
- *date_published (datetime)*
- *post_type (string)*

	- post (default)  
	- page  

- *slug (string)*

###*post_type (string)*

- post (default for get_posts)
- page (default for get_page)

###*paged (int)*

- Equal to 1 less than the page number - e.g., paged will be 9 for page 10.

###*posts_per_page (int)*

- Overrides posts_per_page in s_settings.php.

###*post_id (int)*

- Requests post or page by unique id number.

###*slug (string)*

- Requests post or page by slug. Slugs are URL-friendly, hyphenated, lowercase strings - e.g., The slug for "My First Post" would be "my-first-post".