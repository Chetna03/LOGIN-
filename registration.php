<?php
require_once('config.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>registration form</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>


	<div>
	<?php
	if(isset($_POST['create']))
	{
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$contact = $_POST['contact'];
		$password = md5($_POST['password']);
		
		$check=$db->query("select * from user where email ='".$email."'");
		if($check->rowCount()>0){
			echo "<h2>already registered , SIGN IN please </h2>";
		}
		else{


		$sql = "INSERT INTO user (firstname, lastname, email, contact, password) VALUES(?,?,?,?,?)";
		$stmtinsert = $db->prepare($sql);
		$result = $stmtinsert->execute([$firstname, $lastname, $email, $contact, $password]);
		if($result){

			echo "successfully saved";
		}
		else{
			echo "not saved";
		}
	}
	}
?>	
	</div>

<div>
	<form action="registration.php" method="post">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
				<h1>Registration</h1>
				<hr class="mb-3">
				<label for="firstname"><b>First name</b></label>
				<input class="form-control" type="text" name="firstname" required>

				<label for="lastname"><b>Last name</b></label>
				<input class="form-control" type="text" name="lastname" required>

				<label for="email"><b>Email</b></label>
				<input class="form-control" type="email" name="email">

				<label for="contact"><b>Contact</b></label>
				<input class="form-control" type="text" name="contact" required>

				<label for="password"><b>Password</b></label>
				<input class="form-control" type="password" name="password" required>
				<hr class="mb-3">

				<input class="btn btn-primary" type="submit" name="create" value="Sign Up">
				</div>
   		 	</div>
		</div>
	</form>
</div>
<p>if already registered and accepted by admin : <a href="login.php">SIGN IN</p></a>
<p>FORGOT PASSWORD : <a href="forgotpassword.php">click me </a></p>
</body>
</html>