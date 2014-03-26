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

if ($statusSearch != -1){
	if ($roleSearch != -1){
		$args = array($roleSearch, $statusSearch);
		$data = getDefinedTasksByRoleAndStatus($args);
	}else if ($seriesSearch != -1){
		$args = array($seriesSearch, $statusSearch);
		$data = getDefinedTasksByTitleAndStatus($args);
	}else{
		$args = array($statusSearch);
		$data = getDefinedTasksByStatus($args);
	}
}else if ($roleSearch != -1){
	if ($seriesSearch != -1){
		$args = array($seriesSearch, $roleSearch);
		$data = getDefinedTasksByTitleAndRole($args);
	}else{
		$args = array($roleSearch);
		$data = getDefinedTasksByRole($args);
	}
}else if ($seriesSearch != -1){
	$args = array($seriesSearch);
	$data = getDefinedTasksByTitle($args);
}else{
	$args = array($seriesSearch, $roleSearch, $statusSearch);
	$data = getFullyDefinedTasks($args);
}

echo json_encode($data);

?>
