<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (isset($_SESSION['SPOTS_authorized'])){
    die("Already logged in");
}

if (isset($_POST['loginUser']) && isset($_POST['loginPass']) &&
	!empty($_POST['loginUser']) && !empty($_POST['loginPass'])){
	$username = htmlspecialchars($_POST['loginUser']);
    $password = htmlspecialchars($_POST['loginPass']);
    unset($_POST['loginUser']);
    unset($_POST['loginPass']);

    DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
    require_once(databaseDir.'UserIO.php');
    $valid = userGetPasswordIsValidByName($username, $password);
	if (is_numeric($valid) && $valid != 65535){
		$_SESSION['SPOTS_authorized'] = $valid;
		$_SESSION['SPOTS_user'] = $username;
		$_SESSION['SPOTS_ID'] = $valid;
		die("Success");
	}else{
		die("Invalid password or username");
	}
}else{
	unset($_POST['loginUser']);
	unset($_POST['loginPass']);
	die("Username and/or password not set");
}

?>