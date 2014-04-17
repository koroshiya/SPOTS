<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this page");
}

$statusSearch = $_POST['status'];
if (!in_array($statusSearch, array('A', 'I', 'C', 'S', '-1'))){
	die("Invalid status");
}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'TaskIO.php');

$start = 0;
if (isset($_POST['start']) && is_numeric($_POST['start'])){
	$start = $_POST['start'];
}

if ($statusSearch == -1){
	$data = getFullyDefinedTasks(array(null,null,null), $start, $_SESSION['SPOTS_ID']);
}else{
	$data = getFullyDefinedTasks(array(null,null,$statusSearch), $start, $_SESSION['SPOTS_ID']);
}

echo json_encode($data);

?>
