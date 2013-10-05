<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title><?php echo str_replace('_', ' ', $action); ?> | SPOTS</title>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic' rel='stylesheet' type='text/css'>
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
<div id="umClickOff" style="width:100%; height:100%; position:fixed; visibility:hidden; z-index:1000;"></div>
<div id="userMenu">
<?php
	if (!isset($_SESSION['authorized'])){
?>
	<form id="loginForm" name="loginForm" method="post">
		Username:<br /><input type="text" id="loginUser" name="loginUser" /><br />
		Password:<br /><input type="password" id="loginPass" name="loginPass" /><br />
		<input action="index.php" type="submit" value="login" style="margin-top:12px;" />
	</form>
<?php
	}else{
		//TODO: display relevant user info? Don't show this div at all?
	}
?>

</div>