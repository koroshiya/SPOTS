<?php

/**
*File: UserIO.php
*Author: Koro
*Date created: 06/July/2012
*Date last modified: 06/July/2012
*Version: 1.00
*Changelog: 
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

	function getUserRole($userID){} //user_get_role

	function getUserTitle($userID){} //user_get_title

?>