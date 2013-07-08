<?php

	include 'Connection.php';

	//Example usage:

	/**
	 * Adds a new group to the DB.
	 *
	 * @param $groupName Name for the new group
	 * @param $groupURL URL for the new group
	 * @return True or false, repending on success
	 **/
	function addGroup($groupName, $URL){
		
		$procedure_name = 'insert_scangroup';
		$args = array($groupName, $URL);
		$result = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args);

		return $result;
	}

	/**
	 * Deletes an existing group from the DB
	 *
	 * @param $groupID ID of the group to delete
	 * @return True or false, depending on success
	 */
	function deleteGroup($groupID){
		
		$procedure_name = 'delete_scangroup';
		$result = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $groupID);

		return $result;
	}

	/**
	 * Modifies an existing group in the DB.
	 *
	 * @param $groupID ID of the group to modify
	 * @param $groupName New name for the group (optional)
	 * @param $groupURL New URL for the group (optional)
	 * @return True or false, repending on success
	 **/
	function modifyGroup($groupID, $groupName, $groupURL){
		
		$procedure_name = 'modify_scangroup';
		$args = array($groupID, $groupName, $URL);
		$result = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args);

		return $result;
	}

?>