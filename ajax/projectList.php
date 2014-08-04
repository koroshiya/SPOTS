<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'SeriesIO.php');

	if (isset($_POST['start']) && is_numeric($_POST['start'])){
		$start = $_POST['start'];
	}else{
		$start = 0;
	}

	if (isset($_POST['status']) && strlen($_POST['status']) == 1){
		if (in_array($_POST['status'], array('A', 'S', 'I', 'H', 'D', 'C', 'L'))){
			$status = $_POST['status'];
		}else{
			$status = null;
		}
	}else{
		$status = null;
	}

	if (!isset($_SESSION['SPOTS_authorized'])){ //TODO: if status not null
		$data = getSeriesAllPublic($status, $start);
		$count = getProjectCountPublic($status);
	}else{
		$data = getSeriesAll($status, $start);
		$count = getProjectCount($status);
	}
	echo json_encode(array($count, $data));

?>