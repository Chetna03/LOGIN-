<?php


		//session_start();
		$host='localhost';
		$dbname='useraccounts';
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
			$sql="SELECT * FROM user WHERE email=? and contact=? ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute([$email,$num]);
			if($stmt->rowCount()==1)
			{	$str="jkuq7e9bfkua89fhqofvuihklqhf8qoif8hubfibfoguhvgiuowhfiofoulflwbfuo;wklhfiowffohwghio";
				$str=str_shuffle($str);
				$str=substr($str,0,10);
				$pdo->query("UPDATE user SET token='$str' WHERE email='$email' AND contact='$num'");
				$msg="RESET YOUR PASSWORD http://localhost/useraccount/resetpassword.php?token=$str&email=$email&number=$num ";
				if(mail($email,"PASSWORD RESET",$msg,"FROM:IMD@gmail.com \r\n"))
				{
					echo "gmail sent";
		//			sleep(5);
					header('location: http://localhost/useraccount/login.php');
		//			$_SESSION['loggedinrp']='1';
				}

			}
			else if($stmt->rowCount()==0)
			{
			$sql1="SELECT * FROM admin WHERE email=? and contact=? ";
			$stmt1=$pdo->prepare($sql1);
			$stmt1->execute([$email,$num]);
			if($stmt1->rowCount()==1)
			{
				$str="jkuq7e9bfkua89fhqofvuihklqhf8qoif8hubfibfoguhvgiuowhfiofoulflwbfuo;wklhfiowffohwghio";
				$str=str_shuffle($str);
				$str=substr($str,0,10);
				$pdo->query("UPDATE admin SET token='$str' WHERE email='$email' AND contact='$num'");
				$msg="RESET YOUR PASSWORD http://localhost/useraccount/resetpassword.php?token=$str&email=$email&number=$num ";
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

		<form action="forgotpassword.php" method="post">
			<p>ENTER GMAIL </p>
			<input type="email" name="email" placeholder="gmail">
			<br>
			
			<p>ENTER NUMBER </p>
			<input type="text" name="number" placeholder="number">
			<br>
			<input type="submit" name="emailverify">
			
		</form>
		</html>
	