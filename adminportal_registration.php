<?php 

$host='localhost';
$dbname='user_account';
$password='';
$user='root';
$dsn="mysql:host=$host;dbname=$dbname";

// Registration of admin portal
$pdoap=new PDO($dsn,$user,$password);
$pdoap->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_POST['register']))
{//check if admin is exist or not.
	$check=$pdoap->query("select * from admin_users where email ='".$_POST['adminemail']."'");
	if($check->rowCount()>0)
	{
		echo "<script type='text/javascript'>alert('already registered , SIGN IN please');</script>";
	}
	else
	{
		//registeration of admin
		$sqlap="INSERT INTO admin_users (name, email, password, organisation) VALUES(?,?,?,?)";
		$stmtap=$pdoap->prepare($sqlap);
		$result=$stmtap->execute([$_POST['adminname'],$_POST['adminemail'],md5($_POST['adminpassword']),$_POST['organisation']]);
		echo "<script type='text/javascript'>alert('Registered');</script>";
	
		
	}
}
?>

<html>
<form method="post">
	<h1>REGISTRATION FOR ADMINPORTAL</h1><br>
	<label>Name</label>
	<input type="text" name="adminname" placeholder="name"></input>
	<label>Email</label>
	<input type="email" name="adminemail" placeholder="email"></input>
	<label>Password</label>
	<input type="password" name="adminpassword" placeholder="password"></input>
	<label>Organisation</label>
	<input type="text" name="organisation" placeholder="organisation"></input>
	<input type="submit" name="register" name="register">
</form>
</html>