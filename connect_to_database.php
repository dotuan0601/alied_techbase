<?php
define('HOST_NAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DB_NAME', 'alied_techbase');

mysql_connect(HOST_NAME, USERNAME, PASSWORD) or die(mysql_error()); 
mysql_select_db(DB_NAME);
?> 