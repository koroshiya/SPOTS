<?php
include('../Settings.php');

if (isset($_COOKIE['PK_User']) && isset($_COOKIE['PK_Pass'])) {
	echo '<meta content="0; url = ../" http-equiv="refresh">';
	exit();
}

if (isset($_POST['PK_User']) && isset($_POST['PK_Pass'])) {
	//TODO: Add call to Stored Procedure in DB to validate login
	
	$time = time() + 60 * 60;
	if ($_POST['rememberme'] == 'on') {
		$time *= 24*365; // Create cookies for 1 year
	} 
	setcookie('PK_User', $_POST['PK_User'], $time, '/', '', false, false);
	setcookie('PK_Pass', $_POST['PK_Pass'], $time, '/', '', false, false);
	
	echo '<meta content="0; url = ../" http-equiv="refresh">';
	exit();
		
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href="index.css" type="text/css" rel="stylesheet">
	<meta charset="UTF-8">
</head>
<body>
	<form id="login-panel" method="POST" action="index.php">
		<p style="font-weight:bold; text-align:center">Login</p>
		<input type="text" name="PK_User" class="textbox" value="Username" onfocus="(this.value == 'Username') && (this.value = '')" onblur="(this.value == '') && (this.value = 'Username')" />
		<input type="text" name="PK_Pass" class="textbox" value="Password" onfocus="if (this.value == 'Password') (this.value = '');  (this.type = 'password');" onblur="if (this.value == '') { (this.value = 'Password') (this.type = 'text'); }" />
		<input type="checkbox" name="rememberme" id="rememberme" /><label for="rememberme">Remember me</label>
		<input type="submit" id="loginSubmit" value="Login" />
		<a id="forgotpass">Forgot password?</a>
	</form>
</body>
</html>
