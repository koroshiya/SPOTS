<?php

//Get Module names
if (!isset($_GET['action'])) {
	$action = 'Tasks';
	$sub = 'Main';
} else {
	$action = str_replace('\0', '', $_GET['action']);
	$sub = isset($_GET['sub']) ? str_replace('\0', '', $_GET['sub']) : 'Main';
}

//Declare SPOTS variables
$fromIndex = TRUE;
$actionDir = './Modules/'.$action;
$moduleDir = './Modules/'.$action.'/'.$sub;
$databaseDir = dirname(__FILE__).'/Database/';

require_once('./Database/Connection.php');
global $connection;
if ($connection === null || !mysqli_ping($connection)){
	connect('localhost', 'root', '', 'SPOTS');
}

require_once('./header.php');

$sidebar = $actionDir.'/sidebar.php';
if (!file_exists($sidebar) || !include_once($sidebar)){
	$marginFix = ' style="margin-left:0px;"';
}else {
	$marginFix = '';
}

echo '<div id="module"'.$marginFix.'>';
$mindex = $moduleDir.'/mindex.php';
if (!file_exists($mindex) || !include_once($mindex)) {
	echo '<div style="margin-top:50px;">This page does not exist!</div>';
}
echo '</div>';

require_once('./footer.html');

?>