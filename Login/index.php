<?php
include('../Settings.php');

if (isset($_COOKIE['PK_User']) && isset($_COOKIE['PK_Pass'])) {
	echo '<meta content="0; url = ../" http-equiv="refresh">';
	exit();
}

if (isset($_POST['PK_User']) && isset($_POST['PK_Pass'])) {
	if ($_POST['rememberme'] == 'on') {
		// Create cookies for 1 year here
		$year = time()+60*60*24*365;
		setcookie('PK_User', $_POST['PK_User'], $year, '/', '', false, false);
		setcookie('PK_Pass', $_POST['PK_Pass'], $year, '/', '', false, false);
		
		echo '<meta content="0; url = ../" http-equiv="refresh">';
		exit();
	} else {
		// Create cookies for 1 hour here
		$hour = time()+60*60;
		setcookie('PK_User', $_POST['PK_User'], $hour, '/', '', false, false);
		setcookie('PK_Pass', $_POST['PK_Pass'], $hour, '/', '', false, false);
		
		echo '<meta content="0; url = ../" http-equiv="refresh">';
		exit();
	}
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
