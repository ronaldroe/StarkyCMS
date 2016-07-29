<?php

/* 
 * StarkyCMS is a simple, "headless" content management system by Ronald Roe.
 * By design, there is no built-in gui. What is contained in this class is a series of methods
 * designed to manipulate, store and retrieve page content. The methods are simply a way to 
 * communicate with a database. It's up to the developer to figure out what to do with it.
 * 
 * LICENSING
 * I probably won't add a license or other terms or conditions to this. I really just want it to
 * be useful for people, so do what you want. If you do use it, it'd be pretty cool if you linked
 * back to either THE WEBSITE or my personal site, http://ronaldroe.com. Or don't. That's fine too.
 * It'd also be pretty cool if you sent an email to ron@ronaldroe.com so I can check out what
 * you used it for.
 */


// StarkyCMS base class
class Starky {

	//****************************** PROPERTIES ******************************//

	protected $settings = [];

	//****************************** CONSTRUCTOR ******************************//

	function __construct( string $init_type = '', array $args = [] ) {

		// Attach settings
		$settings = $this->get_settings();

		if( !$init_type || $init_type = 'connect' ){
			
			return $this->connect_db( $settings );
			
		}
		elseif ( $init_type == 'none'  ) {
			
			return;

		}

	}

	//****************************** METHODS ******************************//

	protected function connect_db( array $settings = [] ) {

		if( $settings['db_type'] == 'mysql' ) {

			$con = new mysqli( $settings['host_name'], $settings['username'], $settings['password'], $settings['db_name'] ) 

			or die( "Could not connect: " . $mysqli->connect_error );

		}

		return $con;

	}

	//^^^********************** GETTERS **********************^^^//

	public function get_posts( array $args = [] ) {

		$settings = $this->get_settings();
		$posts = [];

		if( $settings['db_type'] == 'mysql' ){

			$posts = $this->mysql_get_posts( $args );

		} 
		else { 

			die( 'ERROR: Database type is not set or is invalid/unsupported.' );

		}

		return $posts;

	}

	public function get_page( array $args = [] ) {

		$settings = $this->get_settings();
		$posts = [];

		if( $settings['db_type'] == 'mysql' ){

			$posts = $this->mysql_get_page( $args );

		} 
		else { 

			die( 'ERROR: Database type is not set or is invalid/unsupported.' );

		}

		return $posts;

	}

	protected function mysql_get_posts( array $args = [] ){

		/// Set current page
		$args = array_merge( $args, $_GET, $_POST );
		
		$settings = $this->get_settings();

		$sql = "SELECT * FROM " . $settings['tbl_prefix'] . "_posts";
		$where = $limit = $offset = '';

		// Set default post type if empty
		if( empty( $args['post_type'] ) ){

			$args['post_type'] = 'post';

		}

		/// Build WHERE portion of the query
			
		$where = " WHERE post_type='" . $args['post_type'] . "'";

		if( !empty( $args['col_names'] ) ){

			foreach( $args['col_names'] as $key => $value ){

				$where .= " AND " . $key . "='" . $value . "'";

			}

		}

		// Find by post_id - prioritizes post_id
		if( !empty( $args['post_id'] ) || ( !empty( $args['slug'] ) && !empty( $args['post_id'] ) ) ){

			$where .= " AND id=" . intval( $args['post_id'] );

		} // Find by slug

		elseif( !empty( $args['slug'] ) && empty( $args['post_id'] ) ){

			$where .= " AND slug='" . $args['slug'] . "'";

		}

		/// Set LIMIT (max posts per page)
		if( !empty( $args['posts_per_page'] ) && intval( $args['posts_per_page'] ) > 0 ){

			$limit = " LIMIT " . intval( $args['posts_per_page'] );

		} elseif ( empty( $args['posts_per_page'] ) && intval( $settings['posts_per_page'] ) > 0 ){

			$limit = " LIMIT " . intval( $settings['posts_per_page'] );

		}

		/// Set OFFSET (for paging)
		if( isset( $args['paged'] ) ){

			$paged = $args['paged'] * $settings['posts_per_page'];
			$offset = " OFFSET " . $paged;

		}

		/// Build
		$sql = $sql . $where . $limit . $offset;

		/// Connect and run query
		$con = $this->connect_db( $settings );
		$posts = $con->query( $sql );
		$posts = mysqli_fetch_all( $posts, MYSQLI_ASSOC );


		/// Add author info to each post
		for ( $i = 0; $i < count( $posts ); $i++ ) {

			$author = $this->mysql_get_author( $con, $posts[$i]['author_id']);

			$posts[$i]['author'] = $author;

			unset( $posts[$i]['author_id'] );

		}

		if ( $con->error ) {
			
			echo( $con->error );
			return;

		}

		return $posts;

	}

	protected function mysql_get_page( array $args = [] ){

		$args = array_merge( $args, $_GET, $_POST );
		$args['post_type'] = 'page';

		$settings = $this->get_settings();

		$sql = "SELECT * FROM " . $settings['tbl_prefix'] . "_posts";
		$where = '';

		$where .= " WHERE post_type='" . $args['post_type'] . "'";

		// Find by post_id - prioritizes post_id
		if( !empty( $args['post_id'] ) || ( !empty( $args['slug'] ) && !empty( $args['post_id'] ) ) ){

			$where .= " AND id=" . intval( $args['post_id'] );

		} // Find by slug
		elseif( !empty( $args['slug'] ) && empty( $args['post_id'] ) ){

			$where .= " AND slug='" . $args['slug'] . "'";

		}

		if( !empty( $args['col_names'] ) ){

			foreach( $args['col_names'] as $key => $value ){

				$where .= " AND " . $key . "='" . $value . "'";

			}

		}

		/// Build query
		$sql .= $where;

		$con = $this->connect_db( $settings );
		$page = $con->query( $sql );

		if ( $con->error ) {
			
			echo( $con->error );
			return;

		}

		$page = mysqli_fetch_array( $page, MYSQLI_ASSOC );


		// Add author info
		$page['author'] = $this->mysql_get_author( $con, $page['author_id'] );

		unset( $page['author_id'] );

		$con->close();

		return $page;

	}

	public function starky_title(){

		$settings = $this->get_settings();

		return $settings['site_title'];

	}

	public function get_date(){

		$date = [];

	}

	protected function get_settings() {

		include( 's_settings.php' );

		return $_SETTINGS;

	}

	protected function mysql_get_author( $con, int $id ){

		$settings = $this->get_settings();

		$author_sql = "SELECT user_first_name, user_last_name, user_url, user_email FROM " . $settings['tbl_prefix'] // Line break for readability
		. "_users WHERE id=" . intval( $id );

		$author = $con->query( $author_sql );

		$author = mysqli_fetch_array( $author, MYSQLI_ASSOC );

		return $author;

	}

	//^^^^^^^^^^^^^^^^^^ AJAX GETTERS ^^^^^^^^^^^^^^^^^^//

	public function ajax_get_posts( array $args = [] ){

		$args = array_merge( $args, $_GET, $_POST );

		$ajax = $this->get_posts( $args );

		echo json_encode( $ajax );

	}

	public function ajax_get_page( array $args = [] ){

		$args = array_merge( $args, $_GET, $_POST );

		$ajax = $this->get_page( $args );

		echo json_encode( $ajax );

	}

	//^^^********************** SETTERS **********************^^^//


	public function new_post( array $input = [] ) {

		if( !$input ){

			echo( 'Input required' );

		}
		else{

			$settings = $this->get_settings();

			if( $settings['db_type'] == 'mysql' ){

				$output = $this->mysql_new_post( $input );

				return $output;

			}
			else { 

				die( 'ERROR: Database type is not set or is invalid/unsupported.' );

			}

		}

	}

	protected function mysql_new_post( array $input ){

		$input = array_merge( $input, $_GET, $_POST );
		
		$settings = $this->get_settings();

		$con = $this->connect_db( $settings );

		$post_meta = [];

		$columns = [];
		$data = [];

		{

			/// Get column names from posts table.
			/// We're going to use this to check for extra (post_meta) columns.

			$cols = $con->query( "SHOW COLUMNS FROM " . $settings['tbl_prefix'] . "_posts" );
			$cols = mysqli_fetch_all( $cols, MYSQLI_ASSOC );

			$col_names = [];

			foreach ( $cols as $col ) {
				
				array_push( $col_names, $col['Field']);

			}

		}

		/// Build post meta, column data
		foreach ($input as $key => $value) {
			
			if( !in_array( $key, $col_names )){

				array_push( $post_meta, [$key => $value] );

			}
			else{

				array_push( $columns, $key );
				array_push( $data, $value );

			}

		}

		// Create slug
		array_push( $columns, 'slug' );

		array_push( $data, $this->get_slug( $input['title'] ) );

		// Post meta as JSON
		$post_meta_json = json_encode( $post_meta );

		/// Build out SQL
		$sql = "INSERT INTO " . $settings['tbl_prefix'] . "_posts (post_meta";

		foreach( $columns as $column ){

			$sql .= ", " . $column;

		}

		$sql .= ") VALUES('" . $post_meta_json . "'";

		foreach( $data as $item ){

			$sql .= ", '" . $item . "'";

		}

		$sql .= ")";

		$info_out = $con->query( $sql );
		print_r($sql);

		if ( $con->error ) {
			
			return $con->error;

		}

		return $info_out;

	}

	public function update_post( array $input ) {
		// Will need to return any MySQL errors
		// Add an update_post_mysql_query function

	}

	public function delete_post( array $input ) {
		// Will need to return any MySQL errors
		// Add a delete_post_mysql_query function

	}


	//^^^^^^^^^^^^^^^^^^ AJAX SETTERS ^^^^^^^^^^^^^^^^^^//

	public function ajax_update_post( array $args = [] ){

	}

	public function ajax_delete_post( array $args = [] ){

	}

	public function ajax_new_post( array $input ){

		$input = array_merge( $input, $_GET, $_POST );

		$ajax = $this->new_post( $input );

		return json_encode( $ajax );

	}

	//^^^********************** MISC **********************^^^//

	protected function get_slug( $string ) {

	    $string = preg_replace( "/[^a-z0-9 ]/i", "", $string );

	    $string = str_replace( ' ', '-', $string );

	    return strtolower( $string );

	}

}

?>