<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this page");
}

$seriesSearch = $_POST['series'];
$roleSearch = $_POST['role'];
$statusSearch = $_POST['status'];

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'TaskIO.php');

if ($statusSearch == -1 && $roleSearch == -1 && $seriesSearch == -1){
	//get all //disallow?
	$data = array("N/A");
}elseif ($statusSearch == -1){
	if ($roleSearch == -1){
		$args = array($seriesSearch);
		$data = getDefinedTasksByTitle($args);
	}elseif ($seriesSearch == -1){
		$args = array($roleSearch);
		$data = getDefinedTasksByRole($args);
	}else{
		$args = array($seriesSearch, $roleSearch);
		$data = getDefinedTasksByTitleAndRole($args);
	}
}elseif ($roleSearch == -1){
	if ($statusSearch == -1){
		$args = array($seriesSearch);
		$data = getDefinedTasksByTitle($args);
	}elseif ($seriesSearch == -1){
		$args = array($statusSearch);
		$data = getDefinedTasksByStatus($args);
	}else{
		$args = array($seriesSearch, $statusSearch);
		$data = getDefinedTasksByTitleAndStatus($args);
	}
}elseif ($seriesSearch == -1){
	if ($statusSearch == -1){
		$args = array($roleSearch);
		$data = getDefinedTasksByRole($args);
	}elseif ($roleSearch == -1){
		$args = array($statusSearch);
		$data = getDefinedTasksByStatus($args);
	}else{
		$args = array($roleSearch, $statusSearch);
		$data = getDefinedTasksByRoleAndStatus($args);
	}
}else{
	$args = array($seriesSearch, $roleSearch, $statusSearch);
	$data = getFullyDefinedTasks($args);
}

echo json_encode($data);

?>
