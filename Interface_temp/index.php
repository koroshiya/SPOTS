<?php
if (!isset($_GET['action'])) {
	$action = 'Dashboard';
} else {
	$action = str_replace('\0', '', $_GET['action']);
	
	if (isset($_GET['sub'])) {
		$sub = str_replace('\0', '', $_GET['sub']);
	} else {
		$sub = 'Main';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title><?php echo str_replace('_', ' ', $action); ?></title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<link rel="stylesheet" href="./Modules/<?php echo $action; ?>/<?php echo $sub ?>/style.css" type="text/css">
</head>
<body>

<header>
	<nav style="display:inline-block; float:left; margin-left:10px;" role="navigation">
		<a class="header_nav" href="/" style="margin-right:20px;">SPOTS</a>
		<a class="header_nav" href="?action=Tasks">My Tasks</a>
		<a class="header_nav" href="?action=AdminCP">AdminCP</a>
		<a class="header_nav" href="?action=UserCP">UserCP</a>
	</nav>
    <span id="header_user">UserName</span>
</header>
<div style="width:100%; margin:0px">
	<?php
		if (!include './Modules/'.$action.'/mindex.php')
			echo '<div style="margin-top:50px; margin-left:10px;">This page does not exist!</div>';
	?>
</div>

</body>
</html>