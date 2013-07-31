<?php
/*
 * SPOTS - Simple Project Organization Tool for Scanlation
 * 
 * Authors: Daktyl198, Koro
 * Version: 0.0.1
 */

//Declare SPOTS variables
$fromIndex = TRUE;
$loggedIn = FALSE;

// Connect to the database or show error upon failure to connect
$dbconnect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$dbconnect) {
    die('Connection Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
}

// Check if the user is logged in, and if so set an associative array for easy access to their information
if (isset($_COOKIE['SPOTS_USER']) && isset($_COOKIE['SPOTS_PASS'])) {
	$userInfoRaw = mysqli_fetch_array(mysqli_query($dbconnect, 'SELECT * FROM users WHERE userName = '. $_COOKIE['SPOTS_USER']));
	
	if ($_COOKIE['SPOTS_PASS'] === $userInfoRaw[2]) {
		$loggedIn = true;
		
		$userInfo = [
			'userID' => $userInfoRaw[0],
			'userName' => $userInfoRaw[1],
			'userRole' => $userInfoRaw[3],
			'userEmail' => $userInfoRaw[4],
			'userTitle' => $userInfoRaw[5],
		];
		unset($userInfoRaw); // Destroy the raw array to use as little memory as possible.

		//Get the name of the module, and if it isn't set go to dashboard.
		if (!isset($_GET['action'])) {
			$action = 'Dashboard';
		} else {
			$action = str_replace('\0', '', $_GET['action']);
			
			//Get the name of the sub-module, and if it isn't set use "Main"
			if (isset($_GET['sub'])) {
				$sub = str_replace('\0', '', $_GET['sub']);
			} else {
				$sub = 'Main';
			}
		}
	}
	else {
		$action = 'Project_Page';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title><?php echo str_replace('_', ' ', $action); ?></title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<link rel="stylesheet" href="./Modules/<?php echo $action; ?>/<?php echo $sub; ?>/style.css" type="text/css">
</head>
<body>

<header>
	<nav style="display:inline-block; float:left; margin-left:10px;" role="navigation">
		<a class="header_nav" href="/" style="margin-right:20px;">SPOTS</a>
		<a class="header_nav" href="?action=Tasks">My Tasks</a>
		<a class="header_nav" href="?action=AdminCP">AdminCP</a>
		<a class="header_nav" href="?action=UserCP">UserCP</a>
	</nav>
    <a id="header_user" href="#"><?php echo $userInfo['userName'];?></a>
</header>
<div style="width:100%; margin:0px">
	<?php
		if (!include './Modules/'.$action.'/mindex.php')
			echo '<div style="margin-top:50px; margin-left:10px;">This page does not exist!</div>';
	?>
</div>

</body>
</html>
<?php

// Disconnect from the database
mysqli_close($dbconnect);

?>
