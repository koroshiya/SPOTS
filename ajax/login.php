<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (isset($_SESSION['SPOTS_authorized'])){
    die("-1");
}

if (isset($_POST['loginUser']) && isset($_POST['loginPass'])){
	$username = htmlspecialchars($_POST['loginUser']);
    $password = htmlspecialchars($_POST['loginPass']);
    unset($_POST['loginUser']);
    unset($_POST['loginPass']);

    DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
    require_once(databaseDir.'UserIO.php');
    $valid = userGetPasswordIsValidByName($username, $password);
	if ($valid != 65535){
		$_SESSION['SPOTS_authorized'] = $valid;
		$_SESSION['SPOTS_user'] = $username;
		$_SESSION['SPOTS_ID'] = $valid;
	}else{
		die("-1");
	}
	return "Success";
}
unset($_POST['loginUser']);
unset($_POST['loginPass']);
die("-1");

?>