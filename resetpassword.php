<?php
//session_start();
//getting email token and contact from forgetpassword.php
if(isset($_GET['email']) && isset($_GET['number']) && isset($_GET['token']))
{
	
	$d_user="root";
	$d_pass="metsat1";
	$d_name="user_account";
	
	$d = new PDO('mysql:host=localhost;dbname='.$d_name . ';charset=utf8;,$db_user', $d_user ,$d_pass);
	$d->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db = new PDO('mysql:host=localhost;dbname='.$d_name . ';charset=utf8;,$db_user', $d_user ,$d_pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
	
	$email=$_GET['email'];
	$number=$_GET['number'];
	$token=$_GET['token'];
	$st=$db->query("select id from registered_users where email='$email' and token='$token'");
	if($st->rowCount()>0)
	{
		if(isset($_POST['proceed']))
		{	//echo "string";
			
				$stm=$d->query("UPDATE registered_users SET password='".md5($_POST['password'])."' WHERE contact ='".$number."' and email ='".$email."'");
				echo "PASSWORD is set ";
				sleep(6);
				header('location: http://localhost/useraccount/login.php');
				
			
		}
	}
	else if($st->rowCount()==0){
		$d->query("select id from approved_users where email='$email' and token='$token'");
		if($d->rowCount()>0)
		{
			if(isset($_POST['proceed']))
			{	//echo "string";
				
					$stm=$d->query("UPDATE approved_users SET password='".md5($_POST['password'])."' WHERE contact ='".$number."' and email ='".$email."'");
					echo "PASSWORD is set ";
					sleep(6);
					header('location: http://localhost/useraccount/login.php');
					
				
			}
		}
	}

}
else{
	
	echo "something failed!";
	//sleep(5);
	header('location: login.php');
	exit();
	
}
?>
<form method="post">
	<p>ENTER NEW PASSWORD</p>
	<input type="password" name="password" placeholder="password">
	<br>
	<input type="submit" name="proceed">
</form>