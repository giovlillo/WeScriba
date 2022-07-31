<?php
include_once('mysql-fix.php');
include ('admin/include/db-connect.php');

if(isset($_POST['user_name']))
{
 $name=$_POST['user_name'];

 $checkdata=" SELECT user_name FROM users WHERE user_name='$name' ";

 $query=mysql_query($checkdata);

 if(mysql_num_rows($query)>0)
 {
  echo "Username already in use";
 }
 else
 {
  echo "";
 }
 exit();
}

if(isset($_POST['user_email_address']))
{
 $emailId=$_POST['user_email_address'];

 $checkdata=" SELECT user_email_address FROM users WHERE user_email_address='$emailId' ";

 $query=mysql_query($checkdata);

 if(mysql_num_rows($query)>0)
 {
  echo "Email already in use";
 }
 else
 {
  echo "";
 }
 exit();
}
?>