<?php

/**
*File: UserIO.php
*Author: Koro
*Changelog: 1.01: Implemented getUserRole and getUserTitle
			1.02: Implemented other IO and validation methods
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
	
	function deleteUserForcibly($userID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'delete_user_force';
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

	function userSetPassword($userID, $newPassword){

		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'user_set_password';
		$arr = array($userID, $newPassword);
		
		$row = executeFunction($procedure_name, $arr, $connection);
		return $row[0];
		
	}

	function userSetEmail($userID, $newEmail){

		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'user_set_email';
		$arr = array($userID, $newEmail);
		
		$row = executeFunction($procedure_name, $arr, $connection);
		return $row[0];
		
	}

	/**
	 *@param $passwordAttempt Password user input
	 *
	 *@return True if password is correct, otherwise false
	 */
	function userGetPasswordIsValid($userID, $passwordAttempt){

		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'user_get_password_valid';
		$arr = array($userID, $passwordAttempt);
		
		$row = executeFunction($procedure_name, $arr, $connection);
		return $row[0];
		
	}

	function userGetEmail($userID){

		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'user_get_email';
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

	function userSetPermission($userID, $char){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'user_set_permission';
		$arr = array($userID, $char);
		
		$row = executeFunction($procedure_name, $arr, $connection);
		return $row[0];
		
	}

	/**
	 *@return Returns user permission as character. Can be translated into sensible text by decodePermission
	 */
	function userGetPermission($userID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'user_get_permission';
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

	/**
	 * Used in conjunction with userGetPermission
	 */
	function decodePermission($char){

		if ($char === 'S'){
			return 'Staff';
		}else if ($char === 'M'){
			return 'Mod';
		}else if ($char === 'A'){
			return 'Admin';
		} else {
			return 'N/A';
		}

	}

	function isProjectManager($userID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'is_project_manager';
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

	function isProjectManagerOfSeries($userID, $seriesID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'is_project_manager_of_series';
		$arr = array($userID, $seriesID);
		
		$row = executeFunction($procedure_name, $arr, $connection);
		return $row[0];
		
	}

?>