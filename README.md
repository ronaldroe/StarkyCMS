#Starky CMS
###A PHP Headless Content Management System by Ronald Roe

####Note: This CMS is in a very early stage. All security is on the developer. While the user table *does* have a password column, it is not ready for use in a secure environment. TL;DR - Don't use this for anything where security is a concern.
----
##To Do

- Install script
- Automatic Excerpts

----
#Documentation

##Starky Object
###*Starky( array $args = [ ] )*
- Accepts an expanded version of the Starky standard arguments array *(optional)*.
- Additional array arguments:
	- 'action'
		- 'get' - Retrieves either posts or a page by setting the 'post_type'
		- 'new' - Adds new post
All arguments are optional. It is possible to use the 'action' argument in conjunction with 'post_type' and other post data to retrieve or create new posts or pages. See below for examples.

----
##Getters

###*get_author( int $id )*
- Return type: array
- Requires author's id
Returns author data.

###*get_datetime( string $timezone = null )*
- Return type: string
- Accepts timezone as string, defaults to timezone in settings if empty. List of accepted timezones here: <http://php.net/manual/en/timezones.php>
Returns current timestamp formatted for MySQL input.

###*get_page( array $args )*
- Return type: array
- Accepts Starky standard arguments array
Returns data for requested page. Currently, pages can be pulled by either id or slug. Will priortize id over slug if both are passed.

###*get_posts( array $args = [ ] )*
- Return type: array
- Accepts Starky standard arguments array
Returns post data for requested posts. Posts may be pulled using any column in the table. post_type, slug and id may be requested from the array directly. Will prioritize id over slug if both are passed. All other columns must be entered as a sub array under col_names. Will return in descending order by date created, only if status is 'published', unless status is overridden in the arguments array. Posts per page will be returned according to s_settings.php unless overridden in the arguments array.

Paging is accomplished by setting the paged argument to the page number minus 1. See the Starky standard arguments section for more information.

If no arguments are passed, most recent posts are returned.

###*starky_title()*
- Return type: string
Returns the title set in s_settings.php

----
##AJAX Getters
These methods are AJAX wrappers for their respective methods. Except where noted, inputs have the same requirements, and output is echoed versus returned.

###*ajax_get_author( int $id )*
- Echoes: JSON-formatted author data
- id argument is required

###*ajax_get_page( array $args = [ ] )*
- Echoes: JSON-formatted page data
- Input is prioritized as follows:
	1. $_POST
	2. $_GET
	3. $args input
The arguments array is optional in this context. $_GET and $_POST are passed automatically. $_POST values have the highest priorty, and will override other values for the same input.

###*ajax_get_posts( array $args = [ ] )*
- Echoes: JSON-formatted posts data
- Input is prioritized as follows:
	1. $_POST
	2. $_GET
	3. $args input
The arguments array is optional in this context. $_GET and $_POST are passed automatically. $_POST values have the highest priorty, and will override other values for the same input.

###*ajax_starky_title()*
- Echoes the title string

----
##Setters

###*delete_post( array $input )*
- Return type: int or string
- If delete is successful, returns 1. If delete fails, returns error string.
Accepts input array with id or post_id assigned/*required*.

###*new_post( array $input )*
- Return type: int or string
- If insert is successful, returns 1. If insert fails, returns error string.
Accepts Starky standard arguments array. See below for more details. 

###*update_post( array $input )*
- Return type: int or string
- If update is successful, returns 1. If update fails, returns error string.
Accepts Starky standard arguments array. See below for more details. id or post_id *required*.

###*upsert_post( array $input )*
- Return type: int or string
- If upsert is successful, returns 1. If upsert fails, returns error string.
Accepts Starky standard arguments array. If id or post_id are passed, existing post is updated, otherwise new post is created.

----
##AJAX Setters
These methods are AJAX wrappers for their respective methods. Except where noted, inputs have the same requirements, and output is echoed versus returned.

###*ajax_delete_post( array $input )*
- id or post_id argument is required

###*ajax_new_post( array $input = [ ] )*
- Input is prioritized as follows:
	1. $_POST
	2. $_GET
	3. $args input
The arguments array is optional in this context. $_GET and $_POST are passed automatically. $_POST values have the highest priorty, and will override other values for the same input.

###*ajax_update_post( array $input = [ ] )*
- id or post_id is required
- Input is prioritized as follows:
	1. $_POST
	2. $_GET
	3. $args input
The arguments array is optional in this context. $_GET and $_POST are passed automatically. $_POST values have the highest priorty, and will override other values for the same input.

###*ajax_upsert_post( array $input = [ ] )*
- Input is prioritized as follows:
	1. $_POST
	2. $_GET
	3. $args input
The arguments array is optional in this context. $_GET and $_POST are passed automatically. $_POST values have the highest priorty, and will override other values for the same input.

----
##Starky Standard Arguments

###*col_names - array*
Used to target posts table columns that do not have an attached argument.
Works with: get_posts()

###*content - string*
Page content.
Works with: set methods

###*excerpt - string*
Store a short excerpt for the post.
Works with: set methods

###*id - int*
Corresponds to the post's id.
Works with: all get/set methods

###*paged - int*
Paging variable. With posts_per_page, determines offset for current page. Actual page is paged + 1, i.e. paged = 1 for page 2.
Note: to determine the current page, paged is multiplied by posts_per_page to create an offset.
Works with: get_posts()

###*post_id - int*
Alias for id. If both are provided, post_id takes priority.
Works with: all get/set methods

###*post_type - string*
Sets post type. Custom post types are allowed.
Note: to insert a new page, 'page' *must* be passed as the post_type.
Works with: all get/set methods except get_page()

###*posts_per_page - int*
Overrides posts_per_page from s_settings.php
Works with: get_posts()

###*slug - string*
Pass to retrieve post by slug.
Works with: get methods

----
##Post Meta
The post_meta column stores input as JSON that is converted to an array on retrieval. Any data passed to new_post(), update_post() or upsert_post() that does not correspond to an existing column or other standard input will be stored as part of post_meta automatically. This is the perfect place to store any extra post data such as post images/thumbnails.

Troubleshooting information: if you're attempting to post data and it doesn't appear to be going where you'd expect, check the post_meta. If the argument name is misspelled or otherwise mistyped, the data will go into post_meta.

----
#EXAMPLES

###*Get posts by id*

```PHP
$s = new Starky;

$post = s->get_posts( ['id' => 1] );
// post with id = 1 is retrieved as $post[0];
```

###*Get page by id*

```PHP
$s = new Starky;

$page = s->get_page( ['id' => 3] );
// page with id = 3 is retrieved as $page;
```

###*Get posts by slug*
Note: this also works with get_page()

```PHP
$s = new Starky;

$post = s->get_posts( ['slug' => 'my-post-slug'] );
// post with slug = 'my-post-slug' is retrieved as $post[0];
```

###*Add new post*

```PHP
$s = new Starky;

// This array is only necessary if not using $_POST or $_GET or if you need to pass more information
$post_args = [
	'title' => 'Starky CMS is the Best Ever',
	'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus sunt esse dicta ullam doloremque temporibus ipsa culpa rem magni alias voluptate quo corrupti, nesciunt ducimus repellat impedit minus iure, eveniet laboriosam voluptatem. Blanditiis placeat, eaque nisi, cupiditate, tenetur quod excepturi vitae repellat est a ipsa cumque porro? Hic, quos atque.',
	'excerpt' => 'Lorem ipsum dolor sit amet...'
];

$s->new_post( $post_args );
// Returns 1 if successful, error text if fails
```

###*Update post*
```PHP
$s = new Starky;

// This array is only necessary if not using $_POST or $_GET or if you need to pass more information
$post_args = [
	'id' => 2, // Required for update
	'title' => 'Updated Post Title'
];

$s->update_post( $post_args );
// Returns 1 if successful, error text if fails
```

###*Shortcutting getting posts*
```PHP
$post_args = [
	'action' => 'get', // Required to get posts
	'post_type' => 'post', // Optional for posts, not for pages
	'id' => 2
];

$s = new Starky( $post_args );
// post with id = 2 is retrieved as $s->output[0];
```

###*Shortcutting getting posts*
```PHP
$post_args = [
	'action' => 'get', // Required to get posts
	'post_type' => 'page',
	'id' => 3
];

$s = new Starky( $post_args );
// page with id = 3 is retrieved as $s->output;
```

###*Shortcutting new post*
```PHP
// This array is only necessary if not using $_POST or $_GET or if you need to pass more information
$post_args = [
	'action' => 'new', // Required for new post
	'title' => 'Starky CMS is the Best Ever',
	'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus sunt esse dicta ullam doloremque temporibus ipsa culpa rem magni alias voluptate quo corrupti, nesciunt ducimus repellat impedit minus iure, eveniet laboriosam voluptatem. Blanditiis placeat, eaque nisi, cupiditate, tenetur quod excepturi vitae repellat est a ipsa cumque porro? Hic, quos atque.',
	'excerpt' => 'Lorem ipsum dolor sit amet...'
];

$s = new Starky( $post_args );
// $s->output is 1 if successful, error text if fails
```