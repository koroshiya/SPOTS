<?php

function addUser($userName, $userPassword, $userRole, $email=null, $title=null) {
	mysqli_query($dbconnect, "INSERT INTO users VALUES ($userName, $userPassword, $userRole, $email, $title)");
	return true;
}

function removeUser($userName) {
	mysqli_query($dbconnect, "DELETE * FROM users WHERE userName = $userName");
	return true;
}

function is_founder($userName) {
	$userID = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT userID FROM users WHERE userName = $userName"));
	$founderID = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT founderID FROM config"));
	if ($userID['0'] === $founderID['0']) {
		return true;
	} else {
		return false;
	}
}

function is_webmaster($userName) {
	$userID = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT userID FROM users WHERE userName = $userName"));
	$webmasterID = mysqli_fetch_array(mysqli_query($dbconnect, "SELECT webmasterID FROM config"));
	if ($userID['0'] === $webmasterID['0']) {
		return true;
	} else {
		return false;
	}
}

?>
