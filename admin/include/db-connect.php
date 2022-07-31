<?php
define('DB_HOST','127.0.0.1');
define('DB_USER','user');
define('DB_PASS','password');
define('DATABASE_NAME','database_name');
$con = mysql_connect(DB_HOST,DB_USER,DB_PASS) or die('Could not connect to server');
mysql_select_db(DATABASE_NAME) or die('Could not connect the Database');
$SITE_URL = "http://".$_SERVER["SERVER_NAME"]."/";
?>