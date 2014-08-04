<?php

	require_once(databaseDir . 'Connection.php');

	/**
	 * Adds a new UserRole pairing to the database.
	 *
	 * @param $userID ID of the user to assign a role to.
	 * @param $name Name of the role to assign to a user.
	 */
	function addUserRole($userID, $name){
		connectToMeekro();
		$result = DB::query("SELECT user_add_role(%i, %s);", $userID, $name);
		return $result[0];
	}

	/**
	 * Removes a UserRole pairing from the database.
	 *
	 * @param $userID ID of the user specified in the pairing.
	 * @param $name Name of the role specified in the pairing.
	 */
	function removeUserRole($userID, $name){
		connectToMeekro();
		$result = DB::query("SELECT user_remove_role(%i, %s);", $userID, $name);
		return $result[0];
	}

	/**
	 * Removes all roles pertaining to a specific user.
	 *
	 * @param $userID ID of the user to remove all role from.
	 */
	function removeAllUserRoles($userID){
		connectToMeekro();
		$result = DB::query("SELECT user_remove_role_all(%i);", $userID);
		return $result[0];
	}

	/**
	 * Retrieves all roles pertaining to a specific user.
	 *
	 * @param $userID ID of the user specified in the pairing.
	 */
	function getUserRoles($userID){
		connectToMeekro();
		$result = DB::query("SELECT ur.name FROM UserRole AS ur WHERE ur.userID = %i;", $userID);
		return $result[0];
	}

	/**
	 * Retrieves all users of a specific role.
	 *
	 * @param $name Name of the role specified in the pairing.
	 */
	function getUsersByRole($name){
		connectToMeekro();
		$result = DB::query("SELECT * FROM ScanUser AS su INNER JOIN UserRole AS ur ON su.userID = ur.userID WHERE ur.name = %s;", $name);
		return $result[0];
	}

?>