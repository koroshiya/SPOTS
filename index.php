<?php
/*
 * SPOTS - Simple Project Organization Toool for Scanlation
 * 
 * Version: 0.0.0
 */

// Connect to the database
$dbconnect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Show error upon failure to connect
if (!$dbconnect) {
    die('Connection Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
}

// Check if the user is logged in, and if so set an associative array for easy access to their information || TODO Check cookies against the database
if (isset($_COOKIE['SPOTS_USER']) && isset($_COOKIE['SPOTS_PASS'])) {
	$loggedIn = true;
	
	$userInfoRaw = mysqli_fetch_array(mysqli_query($dbconnect, 'SELECT * FROM users WHERE userName = '.$_COOKIE['SPOTS_USER']));
	$userInfo = array(
		'userID' => $userInfoRaw['0'],
		'userName' => $userInfoRaw['1'],
		'userRole' => $userInfoRaw['3'],
		'userEmail' => $userInfoRaw['4'],
		'userTitle' => $userInfoRaw['5'],
	);
	unset($userInfoRaw); // Destroy the raw array to use as little memory as possible.
}


if ($loggedIn) {
	
	// Where the magic happens
	
} else {
	
	// Show the "projects page"
	
}


// Disconnect from the database
mysqli_close($dbconnect);

?>
