<?php
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
		</tr>
		<?php

			$host='localhost';
			$dbname='useraccounts';
			$password='';
			$user='root';

			$dsn="mysql:host=$host;dbname=$dbname";
			$pdo = new PDO($dsn,$user,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql="select id, firstname, lastname, contact, email, organisation from user";
			$stmt=$pdo->query($sql);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				echo "<tr><td>". $row['id'] .'</td><td>'. $row['firstname']. '</td><td>'. $row['lastname'].'</td><td>'. $row['contact'].'</td><td>'. $row['email'].'</td><td>'. $row['organisation'].'</td></tr>';


			}



		?>


	</table>

</body>
</html>

<?php

if(isset($_POST['submit'])){

	//echo "gfb";
	$pdo2 = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
	$pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$check=$pdo->query("select email from user where id ='".$_POST['quantity']."'");
	while($aa=$check->fetch(PDO::FETCH_ASSOC))
	{
		$email_to_check=$aa['email'];
	
	}
	$check2=$pdo->query("select * from admin where email ='".$email_to_check."'");
	if($check2->rowCount()>0)
	{
		echo "<h2>ALREADY EXIST'S</h2>";
	}
	else{
			$sql2="select * from user where id ='". $_POST['quantity']."'";
			$stmt2=$pdo2->query($sql2);
			//$data=array();
			//echo "fs";
			$pdo3 = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
			$pdo3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			while ($key=$stmt2->fetch(PDO::FETCH_ASSOC)) 
			{
				
				$sql3=" insert into admin (firstname, lastname, email, contact, password, organisation) values (?, ?, ?, ?, ?, ?)";
				$stmt3=$pdo3->prepare($sql3);
				$stmt3->execute([$key['firstname'],$key['lastname'],$key['email'],$key['contact'],$key['password'],$key['organisation']]);
				$stmt5=$pdo->prepare("DELETE FROM user WHERE id = ?");
				$stmt5->execute([$_POST['quantity']]);
				header('location: http://localhost/useraccount/adminportal.php');
				if(mail($key['email'],"ACCEPTED LOGIN","You can now sign in to IMD","FROM:IMD@gmail.com \r\n")){
					echo "<br>"."gmail sent";
				}
						//echo "df";
			}
		}
	//foreach ($row as $key ) {
	
	//} 
	
	//$stmt2=$pdo2->query("delete from user where id ='2'");
	//echo "deleted";
	//header('location: http://localhost/useraccount/adminportal.php');

}


if(isset($_POST['submit2'])){
	
	$stmt6=$pdo->prepare("DELETE FROM user WHERE id = ?");
	$stmt6->execute([$_POST['delete']]);
	header('location: http://localhost/useraccount/adminportal.php');

}

if(isset($_POST['rpasswordrt']))
{	
	$pdo9 = new PDO($dsn,$user,$password);
			$pdo9->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$ps=$pdo9->query("UPDATE user SET password='".md5($_POST['passwordrt'])."' WHERE id ='".$_POST['idrt']."'");
	$s=$pdo->query("select email from user where id ='".$_POST['idrt']."'");
			while($row=$s->fetch(PDO::FETCH_ASSOC)){
				$email=$row['email'];

			}
	echo "password is reset, email is '$email' and password is ".$_POST['passwordrt']." ";
	$msg="password is reset, email is '$email' and password is ".$_POST['passwordrt']." ";

	if(mail($email,"PASSWORD RESET",$msg,"FROM:IMD@gmail.com \r\n"))
				{
					echo "<br>"."gmail sent";
		//			
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
		</tr>
		<?php

			

			
			$pdo4 = new PDO($dsn,$user,$password);
			$pdo4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql4="select id, firstname, lastname, contact, email, organisation from admin";
			$stmt4=$pdo4->query($sql4);
			while($row=$stmt4->fetch(PDO::FETCH_ASSOC)){
				echo "<tr><td>". $row['id'] .'</td><td>'. $row['firstname']. '</td><td>'. $row['lastname'].'</td><td>'. $row['contact'].'</td><td>'. $row['email'].'</td><td>'. $row['organisation'].'</td></tr>';


			}



		?>
	</table>


<?php
if(isset($_POST['submitlogin'])){
	
	$s=$pdo4->prepare("DELETE FROM admin WHERE id = ?");
	$s->execute([$_POST['deletelogin']]);
	header('location: http://localhost/useraccount/adminportal.php');
}
?>
<?php
$pdoap=new PDO($dsn,$user,$password);
$pdoap->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_POST['register']))
{
	$check=$pdoap->query("select * from adminportal where email ='".$_POST['adminemail']."'");
	if($check->rowCount()>0)
	{
		echo "<h2>already registered , SIGN IN please </h2>";
	}
	else
	{
		$sqlap="INSERT INTO adminportal (name, email, password, organisation) VALUES(?,?,?,?)";
		$stmtap=$pdoap->prepare($sqlap);
		$result=$stmtap->execute([$_POST['adminname'],$_POST['adminemail'],$_POST['adminpassword'],$_POST['organisation']]);
	
		
	}
}

if(isset($_POST['rpasswordlt']))
{	
	$pdo99 = new PDO($dsn,$user,$password);
			$pdo99->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$ps9=$pdo99->query("UPDATE admin SET password='".md5($_POST['passwordlt'])."' WHERE id ='".$_POST['idlt']."'");
	$s9=$pdo99->query("select email from admin where id ='".$_POST['idlt']."'");
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
	
	$stmt1ap=$pdoap->prepare("DELETE FROM adminportal WHERE id = ?");
	$stmt1ap->execute([$_POST['deleteap']]);
	header('location: http://localhost/useraccount/adminportal.php');

}
?>
		
	<table>
		<tr>
			<th>ID</th>
			<th>name</th>
			<th>email</th>
			<th>password</th>
			<th>organisation</th>
		</tr>
		<?php

			$host='localhost';
			$dbname='useraccounts';
			$password='';
			$user='root';

			$dsn="mysql:host=$host;dbname=$dbname";
			$pdo = new PDO($dsn,$user,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql="select id, name, email,password, organisation from adminportal";
			$stmt=$pdo->query($sql);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				echo "<tr><td>". $row['id'] .'</td><td>'. $row['name']. '</td><td>'. $row['email'].'</td><td>'. $row['password'].'</td><td>'. $row['organisation'].'</td></tr>';


			}


if(isset($_POST['rpasswordat']))
{	
	$pdo99a = new PDO($dsn,$user,$password);
			$pdo99a->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$ps9a=$pdo99a->query("UPDATE adminportal SET password='".md5($_POST['passwordat'])."' WHERE id ='".$_POST['idat']."'");
	$s9a=$pdo99a->query("select email from adminportal where id ='".$_POST['idat']."'");
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
{
	session_destroy(); 
	header("location: adminportal_login.php"); 
}
?>
<?php
$inactive = 1800;
if( !isset($_SESSION['timeout']) )
$_SESSION['timeout'] = time() + $inactive; 

$session_life = time() - $_SESSION['timeout'];

if($session_life > $inactive)
{  session_destroy(); 

	header("location: adminportal_login.php");     }

$_SESSION['timeout']=time();
?>