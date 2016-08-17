# Starky CMS
### A PHP Headless Content Management System by Ronald Roe

#### Note: This is not ready for primetime. While entirely usable, no security measures have been implemented and the documentation is not nearly complete.

# Documentation

##Starky Object
###*Starky( array $args = [ ] )*

----
##Getters

###*get_author( int $id )*

###*get_datetime( string $timezone = null )*

###*get_page( array $args = [ ] )*

###*get_posts( array $args = [ ] )*

###*starky_title()*

----
##AJAX Getters

###*ajax_get_author( int $id )*

###*ajax_get_page( array $args = [ ] )*

###*ajax_get_posts( array $args = [ ] )*

###*ajax_starky_title()*

----
##Setters

###*delete_post( array $input )*

###*new_post( array $input )*

###*update_post( array $input )*

###*upsert_post( array $input )*

----
##AJAX Setters

###*ajax_delete_post( array $input )*

###*ajax_new_post( array $input )*

###*ajax_update_post( array $input )*

###*ajax_upsert_post( array $input )*

----
##Starky Standard Arguments

###*col_names - associative array*

###*post_type - string*

###*paged - int*

###*posts_per_page - int*

###*post_id - int*

###*slug - string*

----
#EXAMPLES

###*Get posts by id*

###*Get posts by slug*

###*Add new post*

###*Update post*

###*Shortcutting getting posts/pages*

###*Shortcutting new post*