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

$start = 0;
if (isset($_POST['start']) && is_numeric($_POST['start'])){
	$start = $_POST['start'];
}

if ($statusSearch == -1 && $roleSearch == -1 && $seriesSearch == -1){
	if (isset($_POST['personal']) && $_POST['personal']){
		$data = getUserTasks($_SESSION['SPOTS_ID'], $start);
	}else{
		$data = getTasks($start);
	}
}elseif ($statusSearch == -1){
	if ($roleSearch == -1){
		$args = array($seriesSearch);
		$data = getDefinedTasksByTitle($args, $start);
	}elseif ($seriesSearch == -1){
		$args = array($roleSearch);
		$data = getDefinedTasksByRole($args, $start);
	}else{
		$args = array($seriesSearch, $roleSearch);
		$data = getDefinedTasksByTitleAndRole($args, $start);
	}
}elseif ($roleSearch == -1){
	if ($statusSearch == -1){
		$args = array($seriesSearch);
		$data = getDefinedTasksByTitle($args, $start);
	}elseif ($seriesSearch == -1){
		$args = array($statusSearch);
		$data = getDefinedTasksByStatus($args, $start);
	}else{
		$args = array($seriesSearch, $statusSearch);
		$data = getDefinedTasksByTitleAndStatus($args, $start);
	}
}elseif ($seriesSearch == -1){
	if ($statusSearch == -1){
		$args = array($roleSearch);
		$data = getDefinedTasksByRole($args, $start);
	}elseif ($roleSearch == -1){
		$args = array($statusSearch);
		$data = getDefinedTasksByStatus($args, $start);
	}else{
		$args = array($roleSearch, $statusSearch);
		$data = getDefinedTasksByRoleAndStatus($args, $start);
	}
}else{
	$args = array($seriesSearch, $roleSearch, $statusSearch);
	$data = getFullyDefinedTasks($args, $start);
}

echo json_encode($data);

?>
