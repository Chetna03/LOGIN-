<?php
	
if(isset($_POST['create'])){
	require_once('config.php');
	@$email=$_POST['email'];
	@$password=$_POST['password'];

	$sql = "SELECT * FROM admin WHERE email = ? AND password = ? LIMIT 1";
	$stmtresult = $db->prepare($sql);
	
	$result = $stmtresult->execute([$email, md5($password)]);

	if($result){

		$user=$stmtresult->fetch(PDO::FETCH_ASSOC);
		if($stmtresult->rowCount()>0){
			header("Location: welcome.php");

		}
		
	}
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
if($stmt->rowCount()==1){
	header("Location: adminportal.php");
}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Authentication</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

</head>
<body>


<div>
	<form action="login.php" method="post">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
				<h1>Login</h1>
				<hr class="mb-3">
			
				<label for="email"><b>Email</b></label>
				<input class="form-control" type="email" name="email">

		
				<label for="password"><b>Password</b></label>
				<input class="form-control" type="password" name="password" required>
				<hr class="mb-3">

				<input class="btn btn-primary" type="submit" name="create" value="Sign In">
				</div>
   		 	</div>
		</div>
	</form>
</div>
<p>if not registered : <a href="registration.php">SIGN UP</a></p>
<p>FORGOT PASSWORD : <a href="forgotpassword.php">click me </a></p>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<br><br>
<h2>FOR ADMIN PORTAL SIGN IN :</h2>

<div>
	<form action="login.php" method="post">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
				<h1>Login</h1>
				<hr class="mb-3">
			
				<label for="emailap"><b>Email</b></label>
				<input class="form-control" type="email" name="emailap">

		
				<label for="password"><b>Password</b></label>
				<input class="form-control" type="password" name="passwordap" required>
				<hr class="mb-3">

				<input class="btn btn-primary" type="submit" name="createap" value="Sign In">
				</div>
   		 	</div>
		</div>
	</form>
</div>
</body>
</html>