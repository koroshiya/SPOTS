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
	<title><?php echo str_replace('_', ' ', $action); ?></title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo $actionDir; ?>/style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo $moduleDir; ?>/style.css" type="text/css">
</head>
<body>

<header>
	<nav style="display:inline-block; float:left; margin:0px; margin-left:10px;" role="navigation">
		<a class="header_nav" style="margin-right:40px;" href="?">SPOTS</a>
		<a class="header_nav" href="?action=Tasks">Tasks</a>
		<a class="header_nav" href="?action=Projects">Projects</a>
		<a class="header_nav" href="?action=UserCP">UserCP</a>
		<a class="header_nav" href="?action=AdminCP">AdminCP</a>
	</nav>
    <span id="header_user">UserName</span>
</header>
	<?php
		include $actionDir.'/sidebar.html';
		echo '<div id="module">';
		if (!include $moduleDir.'/mindex.php') {
			echo '<div style="margin-top:50px; margin-left:10px;">This page does not exist!</div>';
		}
		echo '</div>';
	?>

</body>
</html>
