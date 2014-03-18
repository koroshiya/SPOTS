<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>SPOTS</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="./js/ToolTip.js"></script>
</head>
<body>

<header>
	<nav style="display:inline-block; float:left; margin:0px; margin-left:10px;" role="navigation">
		<a id="header_title">SPOTS</a>
		<?php if ($loggedIntoSPOTS){ ?>
		<a class="header_nav" id="nav_tasks">Tasks</a>
		<a class="header_nav" id="nav_projects">Projects</a>
		<a class="header_nav" id="nav_members">Members</a>
		<a class="header_nav" id="nav_groups">Groups</a>
		<a class="header_nav" id="nav_settings">Settings</a>
		<? } ?>
	</nav>
    <span id="header_user"><?php echo (isset($_SESSION['SPOTS_user']) ? $_SESSION['SPOTS_user'] : "Login") ?></span>
</header>
<div id="userMenu">
<?php
	if (!$loggedIntoSPOTS){
?>	
	<br />
	<form id="loginForm" name="loginForm" method="post">
		Username:<br /><input type="text" id="loginUser" name="loginUser" /><br />
		Password:<br /><input type="password" id="loginPass" name="loginPass" /><br />
		<input action="index.php" type="submit" value="login" style="margin-top:12px;" />
	</form><br />
<?php
	}else{
?>
	<a style="width:100%; height:40px; color:white;" href="index.php?action=logout">Logout</a>
<?php
	}
?>

</div>

<br /><br />
<div id="pageContent"></div>