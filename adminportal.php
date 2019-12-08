<?php
//admin portal is for admin(s) only 
//if already login, admin wont need to login again
session_start();
if(!isset($_SESSION["loggedinap"]) || $_SESSION["loggedinap"] !== true){
    header("location: adminportal_login.php");
   exit;
}	
?>
<!DOCTYPE html>
<html>
<head>
	<h1>REGISTRATION TABLE</h1>
	<title>admin portal</title>
	<style>
		table{
			border-collapse: collapse;
			width: 100%;
			color: #d96459;
			font-family: monospace;
			font-size: 25px;
			text-align: left;
		}

			th {
				background-color: #588c7e;
				color: white;
			}
			tr:nth-child(even) {background-color: #f2f2f2}
		
	</style>
</head>
<body>
	<form method="post">
		<input type="number" name="quantity" placeholder="ID which is to be accepted">
		<input type="submit" name="submit" value="accept">


		<input type="number" name="delete" placeholder="ID which is to be deleted">
		<input type="submit" name="submit2" value="delete">
			<br>
		<input type="number" name="idrt" placeholder="ID for reset password">
		<input type="password" name="passwordrt" placeholder="new password">
		<input type="submit" name="rpasswordrt" value="change password">
	</form>
	
		
	
	
		
	<table>
		<tr>
			<th>ID</th>
			<th>First name</th>
			<th>Last name</th>
		
			<th>Contact</th>
			<th>Email</th>
			<th>Organisation</th>
			<th>Purpose</th>
		</tr>
		<?php
			// display registered users.
			$host='localhost';
			$dbname='user_account';
			$password='';
			$user='root';

			$dsn="mysql:host=$host;dbname=$dbname";
			$pdo = new PDO($dsn,$user,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql="select id, firstname, lastname, contact, email, organisation,purpose from registered_users";
			$stmt=$pdo->query($sql);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				echo "<tr><td>". $row['id'] .'</td><td>'. $row['firstname']. '</td><td>'. $row['lastname'].'</td><td>'. $row['contact'].'</td><td>'. $row['email'].'</td><td>'. $row['organisation'].'</td><td>'.$row['purpose'].'</td></tr>';


			}



		?>


	</table>

</body>
</html>

<?php

if(isset($_POST['submit'])){

	
	$pdo2 = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
	$pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$check=$pdo->query("select email from registered_users where id ='".$_POST['quantity']."'");
	while($aa=$check->fetch(PDO::FETCH_ASSOC))
	{
		$email_to_check=$aa['email'];
	
	}
	$check2=$pdo->query("select * from approved_users where email ='".$email_to_check."'");
	if($check2->rowCount()>0)
	{
		//checking if user is present at login table or not.
		echo "<script type='text/javascript'>alert('already exist');</script>";
	}
	else{
		// add selected column of user from registration table(" user " database) to login table(" admin " database).
			$sql2="select * from registered_users where id ='". $_POST['quantity']."'";
			$stmt2=$pdo2->query($sql2);
			$pdo3 = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
			$pdo3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			while ($key=$stmt2->fetch(PDO::FETCH_ASSOC)) 
			{
				
				$sql3=" insert into approved_users (firstname, lastname, email, contact, password, organisation,token,purpose) values (?, ?, ?, ?, ?, ?, ?, ?)";
				$stmt3=$pdo3->prepare($sql3);
				$stmt3->execute([$key['firstname'],$key['lastname'],$key['email'],$key['contact'],$key['password'],$key['organisation'],'0',$key['purpose']]);
				$stmt5=$pdo->prepare("DELETE FROM registered_users WHERE id = ?");
				$stmt5->execute([$_POST['quantity']]);
				header('location: http://localhost/useraccount/adminportal.php');
				//email sent to let user know that they can now login.
				if(mail($key['email'],"ACCEPTED LOGIN","You can now sign in to IMD","FROM:IMD@gmail.com \r\n")){
					echo "<br>"."gmail sent";
				}
						
			}
		}
	//foreach ($row as $key ) {
	
	//} 
	
	//$stmt2=$pdo2->query("delete from user where id ='2'");
	//echo "deleted";
	//header('location: http://localhost/useraccount/adminportal.php');

}


if(isset($_POST['submit2'])){
	
	$stmt6=$pdo->prepare("DELETE FROM registered_users WHERE id = ?");
	$stmt6->execute([$_POST['delete']]);
	header('location: http://localhost/useraccount/adminportal.php');
    //delete column(user database=" user ") from registration 
}

if(isset($_POST['rpasswordrt']))
{	
	//reset password of user in registration table (user) 
	$pdo9 = new PDO($dsn,$user,$password);
			$pdo9->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$ps=$pdo9->query("UPDATE registered_users SET password='".md5($_POST['passwordrt'])."' WHERE id ='".$_POST['idrt']."'");
	$s=$pdo->query("select email from registered_users where id ='".$_POST['idrt']."'");
			while($row=$s->fetch(PDO::FETCH_ASSOC)){
				$email=$row['email'];

			}
	echo "password is reset, email is '$email' and password is ".$_POST['passwordrt']." ";
	$msg="password is reset, email is '$email' and password is ".$_POST['passwordrt']." ";

	if(mail($email,"PASSWORD RESET",$msg,"FROM:IMD@gmail.com \r\n"))
				{
					echo "<br>"."gmail sent";
		
				}

}

?>

<h1>LOGIN TABLE</h1>
<form method="post">
	<input type="number" name="deletelogin" placeholder="ID which is to be deleted">
	<input type="submit" name="submitlogin" value="delete">
			<br>
		<input type="number" name="idlt" placeholder="ID for reset password">
		<input type="password" name="passwordlt" placeholder="new password">
		<input type="submit" name="rpasswordlt" value="change password">
	
</form>

	<table>
		<tr>
			<th>ID</th>
			<th>First name</th>
			<th>Last name</th>
		
			<th>Contact</th>
			<th>Email</th>
			<th>Organisation</th>
			<th>Purpose</th>
		</tr>
		<?php

			//display admin table (database=" admin ")

			
			$pdo4 = new PDO($dsn,$user,$password);
			$pdo4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql4="select id, firstname, lastname, contact, email, organisation,purpose from approved_users";
			$stmt4=$pdo4->query($sql4);
			while($row=$stmt4->fetch(PDO::FETCH_ASSOC)){
				echo "<tr><td>". $row['id'] .'</td><td>'. $row['firstname']. '</td><td>'. $row['lastname'].'</td><td>'. $row['contact'].'</td><td>'. $row['email'].'</td><td>'. $row['organisation'].'</td><td>'.$row['purpose'].'</td></tr>';


			}



		?>
	</table>


<?php
if(isset($_POST['submitlogin'])){
	//delete column (user) from admin table
	$s=$pdo4->prepare("DELETE FROM approved_users WHERE id = ?");
	$s->execute([$_POST['deletelogin']]);
	header('location: http://localhost/useraccount/adminportal.php');
}
?>
<?php
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
		$sqlap="INSERT INTO admin_users (name, email, password, organisation,purpose) VALUES(?,?,?,?,?)";
		$stmtap=$pdoap->prepare($sqlap);
		$result=$stmtap->execute([$_POST['adminname'],$_POST['adminemail'],md5($_POST['adminpassword']),$_POST['organisation'],$_POST['purpose']]);
	
		
	}
}

if(isset($_POST['rpasswordlt']))
{	//password reset for registration table (admin)
	$pdo99 = new PDO($dsn,$user,$password);
			$pdo99->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$ps9=$pdo99->query("UPDATE approved_users SET password='".md5($_POST['passwordlt'])."' WHERE id ='".$_POST['idlt']."'");
	$s9=$pdo99->query("select email from approved_users where id ='".$_POST['idlt']."'");
			while($row=$s9->fetch(PDO::FETCH_ASSOC)){
				$email9=$row['email'];

			}
	echo "password is reset, email is '$email9' and password is ".$_POST['passwordlt']." ";
	$msg9="password is reset, email is '$email9' and password is ".$_POST['passwordlt']."for login imd ";

	if(mail($email9,"PASSWORD RESET",$msg9,"FROM:IMD@gmail.com \r\n"))
				{
					echo "<br>"."gmail sent";
		//			
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
<br>
<form method="post">
		<input type="number" name="deleteap" placeholder="ID which is to be deleted">
		<input type="submit" name="submitap" value="delete">
		<br>
		<input type="number" name="idat" placeholder="ID for reset password">
		<input type="password" name="passwordat" placeholder="new password">
		<input type="submit" name="rpasswordat" value="change password">
	
</form>
<?php
if(isset($_POST['submitap'])){
	//delete of admin column from admin portal
	$stmt1ap=$pdoap->prepare("DELETE FROM admin_users WHERE id = ?");
	$stmt1ap->execute([$_POST['deleteap']]);
	header('location: http://localhost/useraccount/adminportal.php');

}
?>
		
	<table>
		<tr>
			<th>ID</th>
			<th>name</th>
			<th>email</th>
			<th>organisation</th>

		</tr>
		<?php
			// display admin portal
			$host='localhost';
			$dbname='user_account';
			$password='';
			$user='root';

			$dsn="mysql:host=$host;dbname=$dbname";
			$pdo = new PDO($dsn,$user,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql="select id, name, email,password, organisation from admin_users";
			$stmt=$pdo->query($sql);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				echo "<tr><td>". $row['id'] .'</td><td>'. $row['name']. '</td><td>'. $row['email'].'</td><td>'. $row['organisation'].'</td></tr>';


			}


if(isset($_POST['rpasswordat']))
{	
	//reset password of adminportal
	$pdo99a = new PDO($dsn,$user,$password);
			$pdo99a->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$ps9a=$pdo99a->query("UPDATE admin_users SET password='".md5($_POST['passwordat'])."' WHERE id ='".$_POST['idat']."'");
	$s9a=$pdo99a->query("select email from admin_users where id ='".$_POST['idat']."'");
			while($row=$s9a->fetch(PDO::FETCH_ASSOC)){
				$email9a=$row['email'];

			}
	echo "password is reset, email is '$email9a' and password is ".$_POST['passwordat']." ";
	$msg9a="password is reset, email is '$email9a' and password is ".$_POST['passwordat']."for adminportal ";

	if(mail($email9a,"PASSWORD RESET",$msg9a,"FROM:IMD@gmail.com \r\n"))
				{
					echo "<br>"."gmail sent";
		//			
				}

}



?>


	</table>

</body>
</html>
<br><br>
<form method="post">
	<input type="submit" name="logout" value="logout">
</form>
<?php
if(isset($_POST['logout']))
{	//if logout, then need to login again 
	session_destroy();
	header("location: adminportal_login.php"); 

	
}
?>
<?php
//if nothing happens for 30 minutes automatic logout
$inactive = 1800;//1800 is 30 minutes in seconds 
if( !isset($_SESSION['timeout']) )
$_SESSION['timeout'] = time() + $inactive; 

$session_life = time() - $_SESSION['timeout'];

if($session_life > $inactive)
{  session_destroy(); 

	header("location: adminportal_login.php");     }

$_SESSION['timeout']=time();
?>