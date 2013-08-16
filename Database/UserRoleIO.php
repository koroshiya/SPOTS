<?php

/**
*File: UserRoleIO.php
*Author: Koro
*Changelog: 
*Purpose: Provides methods for interacting with UserRole objects in the database
**/ 

	include 'Connection.php';

	function addUserRole($userID, $name){
		return userIOFunction($userID, $name, 'user_add_role');
	}

	function removeUserRole($userID, $name){
		return userIOFunction($userID, $name, 'user_remove_role');
	}

	function removeAllUserRoles($userID){
		return userFunction($userID, 'user_remove_role_all');
	}

	function getUserRoles($userID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		return executeStoredProcedure('user_get_roles', $userID, $connection);
	}

	function getUsersByRole($name){
		global $connection;
		return executeStoredProcedure('user_get_by_role', $name, $connection);
	}
	
	function userIOFunction($userID, $name, $procedure_name){
		
		if (!(validID($userID))){
			return false;
		}

		$array = [
				"userID" => $userID,
				"name" => $name,
		];

		global $connection;
		
		$row = executeFunction($procedure_name, $array, $connection);
		return $row[0];
		
	}
	
	function userFunction($userID, $procedure_name){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

?>