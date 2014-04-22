<?php

	require_once('Connection.php');

	//If the user is the webmaster, returns true
	function isAdmin($userID){

		connectToMeekro();
		$result = DB::query("SELECT is_admin(%i);", $userID);
		return $result[0];
		
	}
	
	//If the user is a mod, returns true
	function isMod($userID){

		connectToMeekro();
		$result = DB::query("SELECT is_mod(%i);", $userID);
		return $result[0];
		
	}
?>