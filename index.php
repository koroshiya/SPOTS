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

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title><?php echo str_replace('_', ' ', $action); ?> | SPOTS</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo $moduleDir; ?>/style.css" type="text/css">
</head>
<body>

<header>
	<nav style="display:inline-block; float:left; margin:0px; margin-left:10px;" role="navigation">
		<span id="header_title">SPOTS</span>
		<a class="header_nav" href="?action=Tasks">Tasks</a>
		<a class="header_nav" href="?action=Projects">Projects</a>
		<a class="header_nav" href="?action=Members">Members</a>
		<a class="header_nav" href="?action=Groups">Groups</a>
		<a class="header_nav" href="?action=Settings">Settings</a>
	</nav>
    <span id="header_user">Guest</span>
</header>
<div id="userMenu">...</div>
	<?php

		//include_once($moduleDir.'/mindex.php');
		include_once('./Database/Connection.php');
		global $connection;
		if ($connection === null || !mysqli_ping($connection)){
			$connection = connect('localhost', 'root', '', 'SPOTS');
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
	?>
<script src="index.js"></script>
<?php 
	if (file_exists($moduleDir.'/script.js')) {
		echo '<script src="'.$moduleDir.'/index.js"></script>';
	}
	if (file_exists($actionDir.'/script.js')) {
		echo '<script src="'.$actionDir.'/index.js"></script>';
	}
?>
</body>
</html>
