<title>Starky CMS Test Page</title>
<?php 
	
	include( '../starkycms.php' );
	
	$test = new Starky;
	
	$posts = $test->get_posts();
	
	$page = $test->get_page();
	
	$new_args = [
		'title' => 'Test page title 123',
		'thumbnail' => 'http://placekitten.com/150x150',
		'author_id' => 1,
		'status' => 'published',
		'content' => 'This is some test content. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore, consequuntur, dolor enim dicta ex voluptates praesentium voluptatibus deleniti quidem rerum temporibus nostrum aut quod aspernatur maxime minus magnam assumenda natus animi dignissimos doloribus? Aliquid, laborum, officiis, ipsam odit error quos officia id est repudiandae nisi eligendi sed aliquam ab nostrum!'
	];
	
	$new = $test->new_post( $new_args );
	
	$get_new_args = ['slug' => 'test-page-title-123'];
	
	$get_new = $test->get_posts( $get_new_args );

	$update_args = [];	
	$update_args['id'] = $get_new[0]['id'];
	$update_args['title'] = 'Test page title 456';
	
	$update = $test->update_post( $update_args );
	
	$get_updated = $test->get_posts( ['post_id' => $update_args['id']] );
	
	$delete = $test->delete_post( $update_args );
	
	$get_deleted = $test->get_posts( ['post_id' => $update_args['id']] );
	
 ?>
 <h2>Class output</h2>
 <pre>
 	<?php print_r( $test ); ?>
 </pre>
 
 <hr />
 <h2>Posts</h2>
 <pre>
 	<?php print_r( $posts ); ?>
 </pre>
 
 <hr />
 <h2>Page</h2>
 <pre>
 	<?php print_r( $page ); ?>
 </pre>
 
 <hr />
 <h2>New Post In</h2>
 <pre>
 	<?php print_r( $new ); ?>
 </pre>
 
 <hr />
 <h2>New Post Out</h2>
 <pre>
 	<?php print_r( $get_new ); ?>
 </pre>
 
 <hr />
 <h2>Update In</h2>
 <pre>
 	<?php print_r( $update ); ?>
 </pre>
 
 <hr />
 <h2>Update Out</h2>
 <pre>
 	<?php print_r( $get_updated ); ?>
 </pre>
 
 <hr />
 <h2>Delete In</h2>
 <pre>
 	<?php print_r( $delete ); ?>
 </pre>
 
 <hr />
 <h2>Delete Out</h2>
 <pre>
 	<?php print_r( $get_deleted ); ?>
 </pre>