# Starky CMS
### A PHP Headless Content Management System by Ronald Roe

# Documentation

###*Starky( string $init_type = '', array $args = [] )*

- Base class. Second argument accepts an expanded set of the StarkyCMS standard args associative array. See args documentation for list of accepted arguments.
- *$init_type* determines what is returned and accepts the following arguments:
	- empty string - returns connection object
	- *connect* - same as empty string
	- *none* - returns Starky object
- NOTE: Currently, passing arguments to the base class does precisely nothing. :)


##CRUD Operations

###*get_posts( array $args = [] )*

- Return type: array
- Public method available on a Starky instance
- Accepts StarkyCMS standard args array. See args documentation for list of accepted arguments.
```PHP
$example = new Starky();

$args = [
	'post_type' => 'post'
];

$posts = $example->get_posts( $args );
```



##AJAX Operations

###*ajax_get_posts( array $args = [] )*

- Return type: JSON-formatted data
- Echos: JSON-formatted data
- Public method available on a Starky instance.
- May be used the same way as get_posts(). The only difference is return format.
- Prioritizes inputs for arguments as follows:
	1. POST
	2. GET
	3. $args
- Thus, if $args is passed to the function, but a POST value with the same key exists, the POST value will be used.
- Accepts StarkyCMS standard args array. See args documentation for list of accepted arguments.
```PHP
$example = new Starky();

$example->ajax_get_posts();
```
This example will echo back the posts as a JSON object.
Note that no arguments are required. All data may be passed as POST or GET requests. 


##Getters

###*get_author( object $con, int $author_id )*

- Return type: array
- Public method available on a Starky instance.
- Description: Retrieves author details.
- Requires 2 arguments
	1. *object $con* - mysqli connect object
	2. *int $author_id* - int value of the author's id
```PHP
$con = new mysqli( $host, $user, $pass, $db );

$s = new Starky;

// Retrieves the first author
$author = $s->get_author( $con, 1 );
```


##Starky Standard Arguments

###*col_names (associative array)*

- *post_id (int)*
- *title (string)*
- *author_id (int)* - Numeric id for an individual author
- *date_created (datetime)*
- *date_published (datetime)*
- *post_type (string)*
	- post (default)  
	- page  
- *slug (string)*

###*post_type (string)*

- post (default for get_posts)
- page (overwritten in get_page)

###*paged (int)*

- Equal to 1 less than the page number - e.g., paged will be 9 for page 10.

###*posts_per_page (int)*

- Overrides posts_per_page in s_settings.php.

###*post_id (int)*

- Requests post or page by unique id number.

###*slug (string)*

- Requests post or page by slug. Slugs are URL-friendly, hyphenated, lowercase strings - e.g., The slug for "My First Post" would be "my-first-post".