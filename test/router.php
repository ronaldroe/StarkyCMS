<pre>
	<?php 

	// This is just a primitive router for testing. Takes the last 2 items in the address as the arguments for get_post()

	$server = explode('/', $_SERVER['REQUEST_URI']);

	$type = $server[count($server) - 2];

	$slug = $server[count($server) - 1];

	print_r($server);

	if ( $type == 'post' && is_string( $slug ) ) {
		
		include( '../starkycms.php' );

		$r_posts = new Starky;

		$r_post = $r_posts->get_posts([
			'slug' => $slug
		]);

		print_r( $r_post );

	} elseif ( $type == 'page' && is_string( $slug ) ) {
		
		include( '../starkycms.php' );

		$r_posts = new Starky;

		$r_post = $r_posts->get_page([
			'slug' => $slug
		]);

		print_r( $r_post );

	} else {

		

	}

	?>
</pre>