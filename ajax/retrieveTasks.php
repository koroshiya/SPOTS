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

if ($seriesSearch == -1){$seriesSearch = null;}
if ($roleSearch == -1){$roleSearch = null;}
if ($statusSearch == -1){$statusSearch = null;}

$args = array($seriesSearch, $roleSearch, $statusSearch);
if (isset($_POST['personal']) && $_POST['personal']){
	$data = getFullyDefinedTasks($args, $start, $_SESSION['SPOTS_ID']);
}else{
	$data = getFullyDefinedTasks($args, $start, null);
}

echo json_encode($data);

?>
