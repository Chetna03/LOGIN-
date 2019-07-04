<?php
session_start();
if(isset($_SESSION["loggedinap"]) && $_SESSION["loggedinap"] === true){
    header("location:adminportal.php");
    exit;
}
if(isset($_POST['createap'])){

$host='localhost';
$dbname='useraccounts';
$password='';
$user='root';
$dsn="mysql:host=$host;dbname=$dbname";
$pdo = new PDO($dsn,$user,$password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$emailap=$_POST['emailap'];
$passwordap=$_POST['passwordap'];
$stmt=$pdo->query("select id from adminportal where email = '$emailap' and password= '$passwordap'");
echo $stmt->rowCount();
if($stmt->rowCount()==1){
	$_SESSION["loggedinap"]=true;
	header("Location: adminportal.php");
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

		<span class="heading">Admin Login</span>
		<form class="login" action="adminportal_login.php" method="post">
			
			<div class="abcd">
			<div class="user">
				<span class="tag">Email Address</span><br><br>
				<input id="uname" type="text" name="emailap" placeholder="Email.." required></div>
			
			
			<div class="user">
				<span class="tag">Password</span><br><br>
				<input id="pass" type="Password" name="passwordap" placeholder="Password.." required></div>
		
			
			<div class="sub">
				<button onclick="validate()" name="createap">Sign in</button></div>
		
			

		</form>
		</div>

	</div>
</div>
</body>
</html>
