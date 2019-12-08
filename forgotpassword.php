<?php
		

		//session_start();
		$host='localhost';
		$dbname='user_account';
		$password='';
		$user='root';
		$dsn="mysql:host=$host;dbname=$dbname";
		$pdo = new PDO($dsn,$user,$password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if(isset($_POST['emailverify']))
		{
			$num=$_POST['number'];
			$email=$_POST['email'];
		//	$_SESSION['number']=$num;
		//	$_SESSION['email']=$email;
			// reset password for users in registration table
			$sql="SELECT * FROM registered_users WHERE email=? and contact=? ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute([$email,$num]);
			if($stmt->rowCount()==1)
			{
				//if user is valid, then he/she will get email with link to reset password
				$str="jkuq7e9bfkua89fhqofvuihklqhf8qoif8hubfibfoguhvgiuowhfiofoulflwbfuowklhfiowffohwghio";
				$str=str_shuffle($str);
				$str=substr($str,0,10);
				$pdo->query("UPDATE registered_users SET token='$str' WHERE email='$email' AND contact='$num'");
				$msg="RESET YOUR PASSWORD http://localhost/useraccount/resetpassword.php?token=$str&email=$email&number=$num ";
				// change upper link to your website with host
				if(mail($email,"PASSWORD RESET",$msg,"FROM:IMD@gmail.com \r\n"))
				{
					echo "gmail sent";
		//			sleep(5);
					header('location: http://localhost/useraccount/login.php');
		//			$_SESSION['loggedinrp']='1';
				}

			}
			//reset password for user in login table  
			else if($stmt->rowCount()==0)
			{
			$sql1="SELECT * FROM approved_users WHERE email=? and contact=? ";
			$stmt1=$pdo->prepare($sql1);
			$stmt1->execute([$email,$num]);
			if($stmt1->rowCount()==1)
			{
				$str="jkuq7e9bfkua89fhqofvuihklqhf8qoif8hubfibfoguhvgiuowhfiofoulflwbfuo;wklhfiowffohwghio";
				$str=str_shuffle($str);
				$str=substr($str,0,10);
				$pdo->query("UPDATE approved_users SET token='$str' WHERE email='$email' AND contact='$num'");
				$msg="RESET YOUR PASSWORD http://localhost/useraccount/resetpassword.php?token=$str&email=$email&number=$num ";
				//upper link should be changed with hostname
				if(mail($email,"PASSWORD RESET",$msg,"FROM:IMD@gmail.com \r\n"))
				{
					echo "gmail sent";
		//			sleep(5);
					header('location: http://localhost/useraccount/login.php');
		//			$_SESSION['loggedinrp']='1';
				}
			}
		}
			

		}
		/*
		if(isset($_POST['otpverify']))
		{
			if($_POST['otp']==$_COOKIE['otp']){
				session_start();
				$_SESSION["number"]=$num;
				header('location: http://localhost/useraccount/resetpassword.php');
			}
			else{
				echo "wrong otp";
				sleep(5);
				header('location: http://localhost/useraccount/registration.php');
			}
		}*/
	
?>
		<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="wth2.css">
	
</head>
<body>

	<div class="wrapper">
		<form class="container" method="post" action="forgotpassword.php">
			
			<div class="mail-num">
				<div class="tag">
					Email Address
				</div>
				<div class="inside-container">
					<input type="text" name="email" placeholder="Email..">
				</div>
			</div>

			<div class="mail-num">
				<div class="tag">
					Mobile Number
				</div>
				<div class="inside-container">
					<input type="number" name="number" placeholder="Number..">
				</div>
			</div>
			<div class="sub">
				<button  name="emailverify" >confirm</button></div>

		</form>
	</div>

</body>
</html>