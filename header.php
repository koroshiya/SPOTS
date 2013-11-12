<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title><?php echo str_replace('_', ' ', $action); ?> | SPOTS</title>
	<link href='css/font-face.css' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<?php
		if (file_exists(moduleDir.'/style.css')) {
			echo '<link rel="stylesheet" href="'.moduleDir.'/style.css" type="text/css">';
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
    <span id="header_user" onclick="userMenuClick()">Guest</span>
</header>
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
?>
	<a style="width:100%; height:40px; color:white;" href="index.php?action=UserCP">UserCP</a><br />
	<a style="width:100%; height:40px; color:white;" href="index.php?action=logout">Logout</a>
<?php
	//Or something like this :/
	}
?>

</div>