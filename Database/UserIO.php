<?php

/**
 *File: UserIO.php
 *Author: Koro
 *Changelog: 1.01: Implemented getUserRole and getUserTitle
 *			1.02: Implemented other IO and validation methods
 *			1.03: Grouped similar functions
 *Purpose: Provides methods for interacting with User objects in the database
**/ 

	include 'Connection.php';
	
	/**
	 * Inserts a new user into the database.
	 *
	 * @param $userName Name of the user to create.
	 * @param $userPassword Password of the user to create.
	 * @param $userRole Role of the user to create.
	 * @param $email Email address of the user to create.
	 * @param $title Title given to user to create.
	 *
	 * @return True if successful, otherwise false.
	 */
	function insertUser($userName, $userPassword, $userRole, $email, $title){
		
		$procedure_name = 'delete_user';
		
		$array = [
				"userName" => $userName,
				"userPassword" => $userPassword,
				"userRole" => $userRole,
				"email" => $email,
				"title" => $title,
		];
		return executeFunction($procedure_name, $array, $connection);
		
	}
	
	/**
	 * Deletes the user specified.
	 * Fails if the user is assigned to any incomplete tasks or other such tables.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function deleteUser($userID){

		$procedure_name = 'delete_user';
		return executeFunction($procedure_name, $userID, $connection);
		
	}
	
	/**
	 * Deletes the user specified.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function deleteUserForcibly($userID){

		$procedure_name = 'delete_user_force';
		return executeFunction($procedure_name, $userID, $connection);
		
	}

	/**
	 * Updates a user's password.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 * @param $newPassword New password (as plain text) to set for the user.
	 *
	 * @return True if successful, otherwise false.
	 */
	function userSetPassword($userID, $newPassword){

		$procedure_name = 'user_set_password';
		$arr = array($userID, $newPassword);
		return executeFunction($procedure_name, $arr, $connection);
		
	}

	/**
	 * Updates a user's email address.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 * @param $newEmail New email address to associate with the specified user.
	 *
	 * @return True if successful, otherwise false.
	 */
	function userSetEmail($userID, $newEmail){

		$procedure_name = 'user_set_email';
		$arr = array($userID, $newEmail);
		return executeFunction($procedure_name, $arr, $connection);
		
	}

	/**
	 * Tests if the password entered is valid or not.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 * @param $passwordAttempt Password user input
	 *
	 * @return True if password is correct, otherwise false
	 */
	function userGetPasswordIsValid($userID, $passwordAttempt){

		$procedure_name = 'user_get_password_valid';
		$arr = array($userID, $passwordAttempt);
		return executeFunction($procedure_name, $arr, $connection);
		
	}

	/**
	 * Retrieves the email account associated with the user specified.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 *
	 * @return Email address of the user passed in.
	 */
	function userGetEmail($userID){

		$procedure_name = 'user_get_email';
		return executeFunction($procedure_name, $userID, $connection);
		
	}

	/**
	 * Updates a specific user's level of permission.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 * @param $char Character representing the user's new permission level.
	 *
	 * @return True if successful, otherwise false.
	 */
	function userSetPermission($userID, $char){

		$procedure_name = 'user_set_permission';
		$arr = array($userID, $char);
		return executeFunction($procedure_name, $arr, $connection);
		
	}

	/**
	 *@return Returns user permission as character. Can be translated into sensible text by decodePermission
	 */
	function userGetPermission($userID){

		$procedure_name = 'user_get_permission';
		return executeFunction($procedure_name, $userID, $connection);
		
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

	/**
	 * Checks if the specified user is the project manager of any series'.
	 * 
	 * @param $userID ID of the user to check the authority of.
	 *
	 * @return True if the user is the project manager of at least one series, otherwise false.
	 */
	function isProjectManager($userID){

		$procedure_name = 'is_project_manager';
		return executeFunction($procedure_name, $userID, $connection);
		
	}

	/**
	 * Checks if the specified user is the project manager of a particular series.
	 * 
	 * @param $userID ID of the user to check the authority of.
	 *
	 * @return True if the user is the project manager of a specific series, otherwise false.
	 */
	function isProjectManagerOfSeries($userID, $seriesID){

		$procedure_name = 'is_project_manager_of_series';
		$arr = array($userID, $seriesID);
		return executeFunction($procedure_name, $arr, $connection);
		
	}

	function executeUserFunction($procedure_name, $array, $connection){
		global $connection;
		$row = executeFunction($procedure_name, $array, $connection);
		return $row[0];
	}

?>