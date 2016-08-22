<?php

$_SETTINGS = [];

//**** Database connection information - Required for installation ****//
$_SETTINGS['host_name'] = 'localhost';

$_SETTINGS['username'] = 'root';

$_SETTINGS['password'] = 'password';

$_SETTINGS['db_name'] = 'starky';

$_SETTINGS['tbl_prefix'] = 'stk';
//**** End connection information ****//

$_SETTINGS['db_type'] = 'mysql'; // Currently supports 'mysql'

//**** Content settings ****//
$_SETTINGS['posts_per_page'] = 10;

//**** Site settings ****//
$_SETTINGS['site_title'] = 'Starky CMS';

$_SETTINGS['time_zone'] = 'America/Chicago'; // Time zones listed here: http://php.net/manual/en/timezones.php

?>