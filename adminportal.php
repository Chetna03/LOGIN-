
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
	</form>
	
	
		
	<table>
		<tr>
			<th>ID</th>
			<th>First name</th>
			<th>Last name</th>
		
			<th>contact</th>
			<th>email</th>
		</tr>
		<?php

			$host='localhost';
			$dbname='useraccounts';
			$password='';
			$user='root';

			$dsn="mysql:host=$host;dbname=$dbname";
			$pdo = new PDO($dsn,$user,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql="select id, firstname, lastname, contact, email from user";
			$stmt=$pdo->query($sql);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				echo "<tr><td>". $row['id'] .'</td><td>'. $row['firstname']. '</td><td>'. $row['lastname'].'</td><td>'. $row['contact'].'</td><td>'. $row['email'].'</td></tr>';


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
		echo "<h1>ALREADY EXIST'S</h1>";
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
				
				$sql3=" insert into admin (firstname, lastname, email, contact, password) values (?, ?, ?, ?, ?)";
				$stmt3=$pdo3->prepare($sql3);
				$stmt3->execute([$key['firstname'],$key['lastname'],$key['email'],$key['contact'],$key['password']]);
				$stmt5=$pdo->prepare("DELETE FROM user WHERE id = ?");
				$stmt5->execute([$_POST['quantity']]);
				header('location: http://localhost/useraccount/adminportal.php');
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

?>

<h1>LOGIN TABLE</h1>
<form method="post">
	<input type="number" name="deletelogin" placeholder="ID which is to be deleted">
	<input type="submit" name="submitlogin" value="delete">
</form>

	<table>
		<tr>
			<th>ID</th>
			<th>First name</th>
			<th>Last name</th>
		
			<th>contact</th>
			<th>email</th>
		</tr>
		<?php

			

			
			$pdo4 = new PDO($dsn,$user,$password);
			$pdo4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql4="select id, firstname, lastname, contact, email from admin";
			$stmt4=$pdo4->query($sql4);
			while($row=$stmt4->fetch(PDO::FETCH_ASSOC)){
				echo "<tr><td>". $row['id'] .'</td><td>'. $row['firstname']. '</td><td>'. $row['lastname'].'</td><td>'. $row['contact'].'</td><td>'. $row['email'].'</td></tr>';


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