<?php 
if(isset($_POST['submit']))
{
	$num=$_POST['number'];
	// Account details
	$apiKey = urlencode('wlGoSM/u59U-s8cIovyrQ6HNFsXBR3DIBkN8ecKhMz');
	
	// Message details
	$msg="124309eoifnw0h9wnfuowh9nwfnb9wbfo";
	$msg=str_shuffle($msg);
	$msg=substr($msg, 0,5);

	$numbers = array($num);
	$sender = urlencode('TXTLCL');
	$message = rawurlencode('your OTP will expire in one min. OTP is '.$msg);
 	setcookie('otp',$msg,time()+60);
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	

}

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
}
?>

<form action="forgotpassword.php" method="post">
	<p>ENTER NUMBER </p>
	<input type="text" name="number" placeholder="number">
	<input type="submit" name="submit"><br><br>
	<p>ENTER OTP </p>
	<input type="text" name="otp" placeholder="otp">
	<input type="submit" name="otpverify">
	<p>OTP will expire in 1 min hurry!</p>
</form>
