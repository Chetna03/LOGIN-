<?php
require_once('config.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up Form</title>
	<link rel="stylesheet" type="text/css" href="register.css">
	<meta  name="viewport" content="width=device-width, initial-scale=1.0">

<script type="text/javascript">
	
	function validate()
	{

		var username = document.getElementById("uname").value;
		var regx = /^[a-z A-Z 0-9 _]{2,10}$/;

		if(!regx.test(username))
		{
			alert("Invalid username");
		}
		else
		{
			var mail = document.getElementById("email").value;
			var regx = /^([a-zA-Z0-9_]{2,10})@([a-zA-Z0-9_]{2,10}).com$/;

			if(!regx.test(mail))
			{
				alert("Invalid Email Address");
			}
			else
			{
				var word = document.getElementById("pass").value;
				var regx = /^([a-zA-Z0-9_\.]{8,20})$/;

				if(!regx.test(word))
				{
					alert("Invalid Password");
				}
			}
		}
	}
</script>
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
		$organisation=$_POST['organisation'];
		
		$check=$db->query("select * from user where email ='".$email."'");
		if($check->rowCount()>0){
			echo "<h2>already registered , SIGN IN please </h2>";
		}
		else{


		$sql = "INSERT INTO user (firstname, lastname, email, contact, password, organisation) VALUES(?,?,?,?,?,?)";
		$stmtinsert = $db->prepare($sql);
		$result = $stmtinsert->execute([$firstname, $lastname, $email, $contact, $password, $organisation]);
		if($result){

			echo "successfully saved";
		}
		else{
			echo "not saved";
		}
	}
	}
?>	

<div id="wrapper">
	<div class="container">

		<span class="heading">Sign Up</span>
		<form class="login" method="post">
			
			<div class="abcd">
			<div class="user">
				<span class="tag">Firstname</span><br><br>
				<input id="uname" type="text" name="firstname" placeholder="Firstname.." required></div>

			<div class="user">
				<span class="tag">Lastname</span><br><br>
				<input  type="text" name="lastname" placeholder="Lastname.." required></div>
			
			<div class="abcd">
			<div class="user">
				<span class="tag">Email Address</span><br><br>
				<input id="email" type="text" name="email" placeholder="Email Address.." required></div>

			<div class="user">
				<span class="tag">Contact</span><br><br>
				<input  type="text" name="contact" placeholder="Contact.." required></div>

			<div class="user">
				<span class="tag">Password</span><br><br>
				<input id="pass" type="Password" name="password" placeholder="Password.." required></div>

				<div class="user">
				<span class="tag">Organisation</span><br><br>
				<input  type="text" name="organisation" placeholder="Organisation.." required></div>
		
			
			<div class="sub">
				<button onclick="validate()" name="create" >Sign Up</button></div>
		
			<div class="already">Already have an account? <a href="login.php">Sign In</a></div>

			

		</form>
		</div>

	</div>
</div>

</body>
</html>