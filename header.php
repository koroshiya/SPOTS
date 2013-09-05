<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title><?php echo str_replace('_', ' ', $action); ?> | SPOTS</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<?php
		if (isset($moduleDir) && file_exists($moduleDir.'/style.css')) {
			echo '<link rel="stylesheet" href="'.$moduleDir.'/style.css" type="text/css">';
		}
	?>
</head>
<body>

<header>
	<nav style="display:inline-block; float:left; margin:0px; margin-left:10px;" role="navigation">
		<a id="header_title" href="index.php">SPOTS</a>
		<a class="header_nav" href="index.php?action=Tasks">Tasks</a>
		<a class="header_nav" href="index.php?action=Projects">Projects</a>
		<a class="header_nav" href="index.php?action=Members">Members</a>
		<a class="header_nav" href="index.php?action=Groups">Groups</a>
		<a class="header_nav" href="index.php?action=Settings">Settings</a>
	</nav>
    <span id="header_user">Guest</span>
</header>
<div id="userMenu">...</div>