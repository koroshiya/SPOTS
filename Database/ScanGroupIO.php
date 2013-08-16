<?php

	include 'Connection.php';

	/**
	 * Common parameters.
	 * 
	 * @param $groupID ID of the group to modify
	 * @param $groupName Name for the new group
	 * @param $groupURL URL for the new group
	 */

	/**
	 * Adds a new group to the DB.
	 *
	 * @return True or false, repending on success
	 **/
	function addGroup($groupName, $URL){
		
		global $connection;
		$procedure_name = 'insert_scangroup';
		$args = array($groupName, $URL);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	/**
	 * Deletes an existing group from the DB
	 *
	 * @return True or false, depending on success
	 */
	function deleteGroup($groupID){
				
		if (!(validID($groupID))){
			return false;
		}

		global $connection;
		$procedure_name = 'delete_scangroup';
		$result = executeFunction($procedure_name, $groupID, $connection);

		return $result;
	}

	/**
	 * Modifies an existing group in the DB.
	 *
	 * @param $groupName New name for the group (optional)
	 * @param $groupURL New URL for the group (optional)
	 * @return True or false, repending on success
	 **/
	function modifyGroup($groupID, $groupName, $groupURL){
				
		if (!(validID($groupID))){
			return false;
		}

		global $connection;
		$procedure_name = 'modify_scangroup';
		$args = array($groupID, $groupName, $URL);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

?>