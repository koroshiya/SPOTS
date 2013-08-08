<?php

/**
*File: UserIO.php
*Author: Koro
*Changelog: 1.01: Implemented getUserRole and getUserTitle
*Purpose: Provides methods for interacting with User objects in the database
**/ 

	include 'Connection.php';
	
	//TODO: type checking for insertUser
	function insertUser($userName, $userPassword, $userRole, $email, $title){
		
		$procedure_name = 'delete_user';
		
		$array = [
				"userName" => $userName,
				"userPassword" => $userPassword,
				"userRole" => $userRole,
				"email" => $email,
				"title" => $title,
		];
		global $connection;
		$row = executeFunction($procedure_name, $array, $connection);
		return $row[0];
		
	}
	
	function deleteUser($userID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'delete_user';
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

	function getUserRole($userID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'user_get_role'; //Not yet implemented DB side
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

	function getUserTitle($userID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'user_get_title'; //Not yet implemented DB side
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

?>