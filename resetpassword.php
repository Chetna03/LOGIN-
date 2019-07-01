<?php
session_start();
$d_user="root";
$d_pass="";
$d_name="useraccounts";
$_SESSION["number"]='9711091772';
$d = new PDO('mysql:host=localhost;dbname='.$d_name . ';charset=utf8;,$db_user', $d_user ,$d_pass);
$d->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
require_once('config.php');
if(isset($_POST['proceed']))
{	//echo "string";
	$sql="select id from user where contact='".$_SESSION["number"]."'";
	$stmt=$db->query($sql);
	echo $stmt->rowCount();
	if(($stmt->rowCount())==1)
	{	
		$stm=$d->query("UPDATE user SET password='".md5($_POST['password'])."' WHERE contact ='".$_SESSION["number"]."'");
		echo "PASSWORD is set ";
		//sleep(6);
		//header('location: http://localhost/useraccount/login.php');
		//session_destroy();
	}
	else if(($stmt->rowCount())<1)
	{
		$stt=$d->query(" UPDATE admin SET password='".md5($_POST['password'])."' WHERE contact ='".$_SESSION["number"]."'");
		echo "PASSWORD is set ";
		sleep(6);
		header('location: http://localhost/useraccount/login.php');
		session_destroy();
	}
	else{
		echo "something went worng";
	}

}

?>
<form method="post">
	<p>ENTER NEW PASSWORD</p>
	<input type="password" name="password" placeholder="password">
	<input type="submit" name="proceed">
</form>