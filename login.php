<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

if(isset($_POST['create'])){
	require_once('config.php');
	@$email=$_POST['email'];
	@$password=$_POST['password'];

	$sql = "SELECT * FROM admin WHERE email = ? AND password = ? LIMIT 1";
	$stmtresult = $db->prepare($sql);
	
	$result = $stmtresult->execute([$email, md5($password)]);
	echo $result;
	if($result){

		$user=$stmtresult->fetch(PDO::FETCH_ASSOC);
		if($stmtresult->rowCount()>0){
			$_SESSION["loggedin"]= true;
			header("Location: welcome.php");

		}
		
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="login.css">
	<meta  name="viewport" content="width=device-width, initial-scale=1.0">

<script type="text/javascript">
	
	function validate()
	{

		var mail = document.getElementById("email").value;
			var regx = /^([a-zA-Z0-9_]{2,10})@([a-zA-Z0-9_]{2,10}).com$/;

			if(!regx.test(mail))
			{
				alert("Invalid Email Address");
			}
		else
		{
			
				var password = document.getElementById("pass").value;
				var regx = /^([a-z A-Z 0-9 _ \.]{8,20})$/;

				if(!regx.test(password))
				{
					alert("Invalid Password");
				}
		}
	}
	

</script>

</head>
<body>



<div id="wrapper">
	<div class="container">

		<span class="heading">Account Login</span>
		<form class="login" method="post" >
			
			<div class="abcd">
			<div class="user">
				<span class="tag">Email Address</span><br><br>
				<input id="uname" type="text" name="email" placeholder="Email.." required></div>
			
			
			<div class="user">
				<span class="tag">Password</span><br><br>
				<input id="pass" type="Password" name="password" placeholder="Password.." required></div>
		
			
			<div class="sub">
				<button onclick="validate()" name="create">Sign in</button></div>
		
			<div class="already">Don't have an account? <a href="registration.php">Register</a></div>

			<div class="change">Forgot password? <a href="forgotpassword.php">Change password</a></div>

		</form>
		</div>

	</div>
</div>




</body>
</html>
