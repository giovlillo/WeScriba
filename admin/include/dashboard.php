<?php

include ('include/db-connect.php');



session_start();



//check if session is set or not

if(isset($_SESSION['user_name'])) {



    //get value of session varible to php varible

    $user_name = $_SESSION['user_name'];

    $password = $_SESSION['password'];

    $active = "";



	//fetch value from db

    $query = "SELECT * FROM users WHERE `user_name`='$user_name' and `password`='$password' and `active`='1' and type = 'admin'";

    $result = mysql_query($query);

	$result = mysql_fetch_array($result);



	//check whether credentials are correct or not

    if (!(is_array($result))) {

        unset($_SESSION["password"]);

        unset($_SESSION["user_id"]);

        unset($_SESSION["user_name"]);

		header("Location: login.php");

    }

} else {

    header("Location: login.php");

}

?>