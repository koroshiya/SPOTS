<?php

	include 'Connection.php';

	/**
	 * Adds a new group to the DB.
	 * 
	 * @param $groupName Name for the new group.
	 * @param $URL URL for the new group.
	 *
	 * @return True or false, repending on success.
	 **/
	function addGroup($groupName, $URL){
		
		global $connection;
		$procedure_name = 'insert_scangroup';
		$args = array($groupName, $URL);
		return executeFunction($procedure_name, $args, $connection);

	}

	/**
	 * Deletes an existing group from the DB.
	 * 
	 * @param $groupID ID of the group to modify.
	 *
	 * @return True or false, depending on success.
	 */
	function deleteGroup($groupID){

		global $connection;
		$procedure_name = 'delete_scangroup';
		return executeFunction($procedure_name, $groupID, $connection);
		
	}

	/**
	 * Modifies an existing group in the DB.
	 * 
	 * @param $groupID ID of the group to modify.
	 * @param $groupName New name for the group (null if it should remain the same)
	 * @param $groupURL New URL for the group (null if it should remain the same)
	 * 
	 * @return True or false, repending on success
	 **/
	function modifyGroup($groupID, $groupName, $groupURL){

		global $connection;
		$procedure_name = 'modify_scangroup';
		$args = array($groupID, $groupName, $groupURL);
		return executeFunction($procedure_name, $args, $connection);

	}

?>