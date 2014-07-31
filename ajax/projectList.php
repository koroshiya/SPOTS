<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'SeriesIO.php');

	$start = 0;
	if (isset($_POST['start']) && is_numeric($_POST['start'])){
		$start = $_POST['start'];
	}

	if (!isset($_SESSION['SPOTS_authorized'])){
		$data = getSeriesAllPublic($start);
	}else{
		$data = getSeriesAll($start);
	}
	echo json_encode($data);

?>