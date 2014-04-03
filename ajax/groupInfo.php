<?php

if (!fromIndex){die('You must access this through the root index!');}
session_start();
if (!isset($_SESSION['SPOTS_authorized'])){
    die("You are not permitted to view this page");
}elseif (!isset($_POST['groupID']) || !is_numeric($_POST['groupID'])){
	die("Invalid groupID");
}

DEFINE('databaseDir', dirname(dirname(__FILE__)).'/Database/');
require_once(databaseDir.'ChapterIO.php');

$groupID = $_POST['groupID'];

$count = getChapterCountByGroupId($groupID);
$list = getChapterListRecentByGroupId($groupID, 0, $count[0]);

echo json_encode(array($count, $list));

?>
