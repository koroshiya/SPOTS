<?php

	require_once('Connection.php');
	
	/**
	 * Inserts a new user into the database.
	 *
	 * @param $userName Name of the user to create.
	 * @param $userPassword Password of the user to create.
	 * @param $userRole Role of the user to create.
	 * @param $email Email address of the user to create.
	 * @param $title Title given to user to create.
	 */
	function insertUser($userName, $userPassword, $userRole, $email, $title){

		$names = array('userName', 'userPassword', 'userRole', 'email', 'title');
		$params = array($userName, $userPassword, $userRole, $email, $title);
		return insertIntoTable('ScanUser', $names, $params);
		
	}
	
	/**
	 * Deletes the user specified.
	 * Fails if the user is assigned to any incomplete tasks or other such tables.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 */
	function deleteUser($userID){

		connectToMeekro();
		$result = DB::query("SELECT delete_user(%i);", $userID);
		return $result;
		
	}
	
	/**
	 * Deletes the user specified.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function deleteUserForcibly($userID){

		connectToMeekro();
		$result = DB::query("SELECT delete_user_force(%i);", $userID);
		return $result;
		
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

		connectToMeekro();
		$result = DB::query("SELECT user_set_password(%i, %s);", $userID, $newPassword);
		return $result;
		
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

		connectToMeekro();
		$result = DB::query("SELECT user_set_email(%i, %s);", $userID, $newEmail);
		return $result;
		
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

		connectToMeekro();
		$result = DB::query("SELECT user_get_password_valid(%i, %s);", $userID, $passwordAttempt);
		return $result;
		
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

		connectToMeekro();
		$result = DB::query("SELECT user_get_password_valid_by_name(%s, %s);", $name, $passwordAttempt);
		return $result;

	}

	/**
	 * Retrieves the email account associated with the user specified.
	 *
	 * @param $userID ID of the user to be affected by this function.
	 *
	 * @return Email address of the user passed in.
	 */
	function userGetEmail($userID){

		connectToMeekro();
		$result = DB::query("SELECT user_get_email(%i);", $userID);
		return $result;
		
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

		connectToMeekro();
		$result = DB::query("SELECT user_set_permission(%i, %s);", $userID, $char);
		return $result;
		
	}

	/**
	 *@return Returns user permission as character. Can be translated into sensible text by decodePermission
	 */
	function userGetPermission($userID){

		connectToMeekro();
		$result = DB::query("SELECT user_get_permission(%i);", $userID);
		return $result;
		
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
	 */
	function isProjectManager($userID){

		connectToMeekro();
		$result = DB::query("SELECT is_project_manager(%i);", $userID);
		return $result;
		
	}

	/**
	 * Checks if the specified user is the project manager of a particular series.
	 * 
	 * @param $userID ID of the user to check the authority of.
	 */
	function isProjectManagerOfSeries($userID, $seriesID){

		connectToMeekro();
		$result = DB::query("SELECT is_project_manager_of_series(%i, %i);", $userID, $seriesID);
		return $result;
		
	}

	/**
	 * Retrieves a user from the DB specified by their ID.
	 *
	 * @param $userID Unique ID used to define the user we want to grab from the DB.
	 *
	 * @return User specified by ID. False if function fails.
	 */
	function getUser($userID){

		connectToMeekro();
		$result = DB::query("SELECT * FROM ScanUser AS s WHERE s.userID = %i;", $userID);
		return $result[0];

	}

	/**
	 * Retrieves all users from the DB.
	 *
	 * @return All users stored in the DB. False if function fails.
	 */
	function getUsersAll(){

		connectToMeekro();
		$result = DB::query("SELECT * FROM ScanUser;");
		return $result;

	}

	function getUsersInOrder($start){

		connectToMeekro();
		$result = DB::query("SELECT * FROM ScanUser LIMIT %i, %i;", $start, 20);
		return $result;

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
		if ($position === 'S' OR $position === 'A' OR $position === 'M'){ /*s = staff, a = admin, m = mod*/
			connectToMeekro();
			$result = DB::query("SELECT * FROM ScanUser AS s WHERE s.title = %s;", $position);
			return $result;
		}else{
			return getUsersAll();
		}
	}

?>
