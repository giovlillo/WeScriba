<?php

	

	//connection
    include_once('mysql-fix.php');
	include ('admin/include/db-connect.php');

	$q = "select user_name from users where user_name='".$_POST['unm']."'";

	

	$result = mysql_query($q) or die("Cnt fire querry..".$q);

			

	if(mysql_num_rows($result) != 0)

	{

		echo 'Username Alreay exits';

	}

	else

	{

		echo 'Vaild Username';

	}



?>

