<!DOCTYPE html>
<html>
<head>
	<title>Starky CMS Installer</title>
</head>
<body>
	<h1>Starky CMS Installation</h1>
	CREATE TABLE `stk_posts` (
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
CREATE TABLE `stk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(32) NOT NULL,
  `user_last_name` varchar(32) NOT NULL,
  `user_url` varchar(64) DEFAULT NULL,
  `user_role` varchar(45) NOT NULL,
  `user_email` varchar(45) NOT NULL,
  `user_pass` char(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
</body>
</html>