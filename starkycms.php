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

	private $settings = [];

	//****************************** CONSTRUCTOR ******************************//

	function __construct( array $args = [] ) {

		// Attach settings
		$settings = $this->get_settings();

	}

	//****************************** METHODS ******************************//


	//^^^********************** CRUD **********************^^^//

	public function get_posts( array $args = [] ) {

		$settings = $this->get_settings();
		$posts = [];

		if($settings['db_type'] == 'mysql'){

			$posts = $this->get_posts_mysql_query( $args );

		}

		return $posts;

	}

	private function get_posts_mysql_query( array $args = [] ){

		/// Set current page
		$args = array_merge( $args, $_GET, $_POST );

		if( empty( $args['post_type'] ) ){

			$args['post_type'] = 'post';

		}

		$settings = $this->get_settings();

		/// Build SQL query
		$sql = "SELECT * FROM " . $settings['tbl_prefix'] . "posts";
			
		$sql .= " WHERE post_type='" . $args['post_type'] . "'";

		if( !empty( $args['col_names'] ) ){

			foreach( $args['col_names'] as $key => $value ){

				$sql .= " AND " . $key . "='" . $value . "'";

			}

		}

		// Find by post_id
		if( !empty( $args['post_id'] ) ){
			$sql .= " AND id=" . intval( $args['post_id'] );
		}

		// Find by slug
		if( !empty( $args['slug'] ) ){
			$sql .= " AND slug='" . $args['slug'] . "'";
		}

		// Set max posts per page
		if( !empty( $args['posts_per_page'] ) && intval( $args['posts_per_page'] ) > 0 ){

			$sql .= " LIMIT " . intval( $args['posts_per_page'] );

		} elseif ( empty( $args['posts_per_page'] ) && intval( $settings['posts_per_page'] ) > 0 ){

			$sql .= " LIMIT " . intval( $settings['posts_per_page'] );

		}

		// Set offset for paging
		if( isset( $args['paged'] ) ){

			$paged = $args['paged'] * $settings['posts_per_page'];
			$sql .= " OFFSET " . $paged;

		}

		/// Connect and run query
		$con = $this->connect_db( $settings );
		$posts = $con->query( $sql );
		$posts = mysqli_fetch_all( $posts, MYSQLI_ASSOC );

		return $posts;

	}

	private function connect_db( array $settings ) {

		if( $settings['db_type'] == 'mysql' ) {

			$con = new mysqli( $settings['host_name'], $settings['username'], $settings['password'], $settings['db_name'] ) or die( "Could not connect: " . $mysqli->connect_error );

		} elseif ( $settings['db_type'] == 'mongodb' ) {

			// SOME CODE FOR MONGODB

		}

		return $con;

	}

	public function get_page( array $args = [] ) {

		$args['post_type'] = 'page';

		if( empty( $args['post_id'] ) ){

			$args['post_id'] = $_GET['page'] || $_GET['post_id'];

		}

		$settings = $this->get_settings();

		$sql = "SELECT * FROM " . $settings['tbl_prefix'] . "posts WHERE post_type='" . $args['post_type'] . "'";



		$con = $this->connect_db( $settings );
		$page = $con->query( $sql );
		$page = mysqli_fetch_all( $page, MYSQLI_ASSOC );

		return $page;

	}

	public function new_post( array $input ) {

	}

	public function update_post( array $input ) {

	}

	public function delete_post( array $input ) {

	}

	//^^^********************** GETTERS **********************^^^//

	public function starky_title(){

		$settings = $this->get_settings();

		return $settings['site_title'];

	}

	private function get_settings() {

		include( 's_settings.php' );
		return $_SETTINGS;

	}

	//^^^********************** SETTERS **********************^^^//



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

	//^^^^^^^^^^^^^^^^^^ AJAX SETTERS ^^^^^^^^^^^^^^^^^^//

	public function ajax_update_post( array $args = [] ){

	}

	public function ajax_delete_post( array $args = [] ){

	}

}

?>