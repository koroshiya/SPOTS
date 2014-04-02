<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this page");
}elseif (!isset($_POST['userID']) || !is_numeric($_POST['userID'])){
	die("Invalid userID");
}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'UserIO.php');
require_once(databaseDir.'TaskIO.php');

$userID = $_POST['userID'];

$isPM = isProjectManager($userID);
$isPM = $isPM ? "1" : "-1";
$count = getUserActiveTaskCount($userID);

$data = array($isPM, $count);
echo json_encode($data);

?>
