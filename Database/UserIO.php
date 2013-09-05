<?php

/**
 *File: UserIO.php
 *Author: Koro
 *Changelog: 1.01: Implemented getUserRole and getUserTitle
 *			1.02: Implemented other IO and validation methods
 *			1.03: Grouped similar functions
 *			1.04: Fixed invalid connection passing, implemented getUser functions
 *			1.05: Fix for insertUser function
 *Purpose: Provides methods for interacting with User objects in the database
**/ 

	require_once('Connection.php');
	
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
		
		$array = array($userName, $userPassword, $userRole, $email, $title);
		return executeUserFunction($procedure_name, $array);
		
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
		return executeUserFunction($procedure_name, $userID);
		
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
		return executeUserFunction($procedure_name, $userID);
		
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
		return executeUserFunction($procedure_name, $arr);
		
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
		return executeUserFunction($procedure_name, $arr);
		
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
		return executeUserFunction($procedure_name, $arr);
		
	}

	/**
	 * Tests if the password entered is valid or not.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 * @param $passwordAttempt Password user input
	 *
	 * @return True if password is correct, otherwise false
	 */
	function userGetPasswordIsValidByName($name, $passwordAttempt){
		$procedure_name = 'user_get_password_valid_by_name';
		$arr = array($name, $passwordAttempt);
		return executeUserFunction($procedure_name, $arr);
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
		return executeUserFunction($procedure_name, $userID);
		
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
		return executeUserFunction($procedure_name, $arr);
		
	}

	/**
	 *@return Returns user permission as character. Can be translated into sensible text by decodePermission
	 */
	function userGetPermission($userID){

		$procedure_name = 'user_get_permission';
		return executeUserFunction($procedure_name, $userID);
		
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
		return executeUserFunction($procedure_name, $userID);
		
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
		return executeUserFunction($procedure_name, $arr);
		
	}

	/**
	 * Retrieves a user from the DB specified by their ID.
	 *
	 * @param $userID Unique ID used to define the user we want to grab from the DB.
	 *
	 * @return User specified by ID. False if function fails.
	 */
	function getUser($userID){
		$procedure_name = 'get_user_by_id';
		return executeStoredProcedure($procedure_name, $userID);
	}

	/**
	 * Retrieves all users from the DB.
	 *
	 * @return All users stored in the DB. False if function fails.
	 */
	function getUsersAll(){
		$procedure_name = 'get_users_all';
		return executeStoredProcedure($procedure_name, null);
	}

	/**
	 * Retrieves all users from the DB who belong to a certain title/status.
	 *
	 * @param $position Char representing the user's title/status.
	 *
	 * @return All users specified by query. If the position doesn't exist, all users in DB are returned.
	 *			False if function fails.
	 */
	function getUsersByPosition($position){
		$procedure_name = 'get_users_by_position';
		return executeStoredProcedure($procedure_name, $position);
	}

	/**
	 * Processed a user function and attempts to run it.
	 *
	 * @param $procedure_name Name of the function/procedure we want to run.
	 * @param $array Array of arguments (or single argument, or null) to pass into the function we want to run.
	 *
	 * @return First row returned by the function. False if function fails.
	 */
	function executeUserFunction($procedure_name, $array){
		$row = executeFunction($procedure_name, $array);
		return $row[0];
	}

?>