<?php 
	include('../s_settings.php');

	$settings = $_SETTINGS;

	$con = new mysqli( $settings['host_name'], $settings['username'], $settings['password'], $settings['db_name'] );

	$out = $con->query('SHOW COLUMNS FROM stk_posts');

	$out = mysqli_fetch_all($out, MYSQLI_ASSOC);
 ?>

 <pre>
 	<?php 
 		print_r($out);
 	 ?>
 </pre>