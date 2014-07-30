<?php

	require_once('Connection.php');
	
	function isAdmin($userID){
		return getUserRole($userID) === 'A';
	}
	
	function isMod($userID){
		return getUserRole($userID) === 'M';
	}

	function getUserRole($userID){
		connectToMeekro();
		$result = DB::query("SELECT su.userRole INTO suUserRole FROM ScanUser AS su WHERE su.userID = %i;", $userID);
		return $result;
	}

?>