<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this page");
}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'UserIO.php');

if (isset($_POST['userID']) && is_numeric($_POST['userID'])){
	$user = getUser($_POST['userID']);
	echo json_encode($user);
}else{
	$start = 0;
	if (isset($_POST['start']) && is_numeric($_POST['start'])){
		$start = $_POST['start'];
	}

	$data = getUsersInOrder($start);
	echo json_encode($data);
}

?>