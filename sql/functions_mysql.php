<?php

function addUser($userName, $userPassword, $userRole, $email=null, $title=null) {
	mysqli_query($dbconnect, "INSERT INTO users VALUES ($userName, $userPassword, $userRole, $email, $title)");
}

function removeUser($userName) {
	mysqli_query($dbconnect, "DELETE * FROM users WHERE userName = $userName");
}

function is_founder($userName) {
	array $userID = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT userID FROM users WHERE userName = $userName"));
	array $founderID = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT founderID FROM config"));
	if ($userID['0'] === $founderID['0']) {
		$results = true;
	} else {
		$results = false;
	}
	
	return $results;
}

function is_webmaster($userName) {
	array $userID = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT userID FROM users WHERE userName = $userName"));
	array $webmasterID = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT webmasterID FROM config"));
	if ($userID['0'] === $webmasterID['0']) {
		$results = true;
	} else {
		$results = false;
	}
	
	return $results;
}

?>
