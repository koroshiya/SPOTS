<?php

//Get Module names
if (!isset($_GET['action'])) {
	$action = 'Tasks';
} else {
	$action = str_replace('\0', '', $_GET['action']);
	
	if (isset($_GET['sub'])) {
		$sub = str_replace('\0', '', $_GET['sub']);
	} else {
		$sub = 'Main';
	}
}

//Declare SPOTS variables
$fromIndex = TRUE;
$actionDir = './Modules/'.$action;
$moduleDir = './Modules/'.$action.'/'.$sub;

require_once('./header.html');

require_once('./Database/Connection.php');
global $connection;
if ($connection === null || !mysqli_ping($connection)){
	connect('localhost', 'root', '', 'SPOTS');
}

$sidebarCheck = $actionDir.'/sidebar.php';
if (!file_exists($sidebarCheck) || !include_once($sidebarCheck)){
	$marginFix = ' style="margin-left:0px;"';
}else {
	$marginFix = '';
}

echo '<div id="module"'.$marginFix.'>';
$mindexCheck = $moduleDir.'/mindex.php';
if (!file_exists($mindexCheck) || !include_once($mindexCheck)) {
	echo '<div style="margin-top:50px;">This page does not exist!</div>';
}
echo '</div>';
echo '<script src="index.js"></script>';

if (file_exists($moduleDir.'/script.js')) {
	echo '<script src="'.$moduleDir.'/index.js"></script>';
}
if (file_exists($actionDir.'/script.js')) {
	echo '<script src="'.$actionDir.'/index.js"></script>';
}

require_once('./footer.html');
?>