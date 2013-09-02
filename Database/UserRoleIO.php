<?php

/**
 *File: UserRoleIO.php
 *Author: Koro
 *Changelog: 1.01: Grouped similar functions, removed unnecessary.
 *Purpose: Provides methods for interacting with UserRole objects in the database
**/ 

	include_once('Connection.php');

	/**
	 * Adds a new UserRole pairing to the database.
	 *
	 * @param $userID ID of the user to assign a role to.
	 * @param $name Name of the role to assign to a user.
	 *
	 * @return True if successful, otherwise false.
	 */
	function addUserRole($userID, $name){
		return userIOFunction($userID, $name, 'user_add_role');
	}

	/**
	 * Removes a UserRole pairing from the database.
	 *
	 * @param $userID ID of the user specified in the pairing.
	 * @param $name Name of the role specified in the pairing.
	 *
	 * @return True if successful, otherwise false.
	 */
	function removeUserRole($userID, $name){
		return userIOFunction($userID, $name, 'user_remove_role');
	}

	/**
	 * Removes all roles pertaining to a specific user.
	 *
	 * @param $userID ID of the user to remove all role from.
	 *
	 * @return True if successful, otherwise false.
	 */
	function removeAllUserRoles($userID){
		return userIOFunction($userID, null, 'user_remove_role_all');
	}

	/**
	 * Retrieves all roles pertaining to a specific user.
	 *
	 * @param $userID ID of the user specified in the pairing.
	 *
	 * @return All roles pertaining to a specific user.
	 */
	function getUserRoles($userID){
		return executeStoredProcedure('user_get_roles', $userID);
	}

	/**
	 * Retrieves all users of a specific role.
	 *
	 * @param $name Name of the role specified in the pairing.
	 *
	 * @return All users of a specific role.
	 */
	function getUsersByRole($name){
		return executeStoredProcedure('user_get_by_role', "'" . $name . "'");
	}
	
	/**
	 * Executes a user function.
	 *
	 * @param $userID ID of the user whom the function affected.
	 * @param $name Name of the role to process. (not mandatory)
	 */
	function userIOFunction($userID, $name, $procedure_name){

		$array = array($userID, $name);
		$row = executeFunction($procedure_name, $array);
		return $row[0];
		
	}

?>