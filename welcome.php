<?php
session_start();
$inactive = 600;
if( !isset($_SESSION['timeout']) )
$_SESSION['timeout'] = time() + $inactive; 

$session_life = time() - $_SESSION['timeout'];

if($session_life > $inactive)
{  session_destroy(); 

	header("location: login.php");     }

$_SESSION['timeout']=time();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
   exit;
}	

echo "<h1>WELCOME </h1>";
?>
<form method="post">
	<input type="submit" name="logout" value="logout">
</form>
<?php
if(isset($_POST['logout']))
{
	session_destroy(); 
	header("location: login.php"); 
}
?>