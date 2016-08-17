#Starky CMS
###A PHP Headless Content Management System by Ronald Roe

####Note: This CMS is in a very early stage. All security is on the developer. While the user table *does* have a password column, it is not ready for use in a secure environment. TL;DR - Don't use this for anything where security is a concern.

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

###*id - int*

###*paged - int*

###*post_id - int*

###*post_type - string*

###*posts_per_page - int*

###*slug - string*

----
#EXAMPLES

###*Get posts by id*

###*Get posts by slug*

###*Add new post*

###*Update post*

###*Shortcutting getting posts/pages*

###*Shortcutting new post*