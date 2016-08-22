<?php 

    include('s_settings.php');
    $settings = $_SETTINGS;
    $con;
    if( $settings['db_type'] == 'mysql' ){

    $con = new mysqli( $settings['host_name'], $settings['username'], $settings['password'], $settings['db_name'] )

    or die( "Could not connect: " . $mysqli->connect_error );

    }

    $posts_table = "CREATE TABLE `" . $settings['tbl_prefix'] . "_posts` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` text NOT NULL,
      `content` mediumtext NOT NULL,
      `author_id` int(11) NOT NULL,
      `date_created` datetime NOT NULL,
      `date_published` datetime DEFAULT NULL,
      `date_updated` datetime DEFAULT NULL,
      `post_type` varchar(45) NOT NULL,
      `slug` varchar(45) NOT NULL,
      `link` varchar(45) NOT NULL,
      `excerpt` text,
      `post_meta` text,
      `status` tinyint(1) DEFAULT NULL,
      PRIMARY KEY (`id`)
    )";

    $users_table = "CREATE TABLE `" . $settings['tbl_prefix'] . "_users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_first_name` varchar(32) NOT NULL,
      `user_last_name` varchar(32) NOT NULL,
      `user_url` varchar(64) DEFAULT NULL,
      `user_role` varchar(45) NOT NULL,
      `user_email` varchar(45) NOT NULL,
      `user_pass` char(128) DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `id_UNIQUE` (`id`)
    )";

    $con->query( $posts_table );

    $post_error = $con->error;

    $con->query( $users_table );

    $user_error = $con->error;

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Starky CMS Installer</title>
</head>
<body>
	<h1>Starky CMS Installation</h1>

    <?php 

    if( !$post_error && !$user_error ){

        echo( "<h2>Looks like everything worked</h2><p>Delete this installer file</p>" );

    } 

    if( $post_error ){

        echo( "<h2>There was an error creating the posts table: " . $post_error . "</h2>" );

    } 

    if( $user_error ){

        echo( "<h2>There was an error creating the users table: " . $user_error . "</h2>" );

    }

     ?>

</body>
</html>