<?php
//config.php is just for databse connection which is included in registration.php and login.php.
$db_user="root"; //database username 
$db_pass=""; //database password if any
$db_name="user_account";//database name 

$db = new PDO('mysql:host=localhost;dbname='.$db_name . ';charset=utf8;,$db_user', $db_user ,$db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//this was PDO connection.
?>