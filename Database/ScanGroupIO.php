<?php

	require_once('Connection.php');

	/**
	 * Adds a new group to the DB.
	 * 
	 * @param $groupName Name for the new group.
	 * @param $URL URL for the new group.
	 *
	 * @return True or false, repending on success.
	 **/
	function addGroup($groupName, $URL){
		
		$procedure_name = 'insert_scangroup';
		$args = array($groupName, $URL);
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	/**
	 * Deletes an existing group from the DB.
	 * Fails if any ChapterGroup objects exist for this group.
	 * 
	 * @param $groupID ID of the group to modify.
	 *
	 * @return True or false, depending on success.
	 */
	function deleteGroup($groupID){

		$procedure_name = 'delete_scangroup';
		$result = executeFunction($procedure_name, $groupID);
		return $result[0];
		
	}

	/**
	 * Deletes an existing group from the DB.
	 * 
	 * @param $groupID ID of the group to modify.
	 *
	 * @return True or false, depending on success.
	 */
	function deleteGroupForce($groupID){

		$procedure_name = 'delete_scangroup_force';
		$result = executeFunction($procedure_name, $groupID);
		return $result[0];
		
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

		$procedure_name = 'modify_scangroup';
		$args = array($groupID, $groupName, $groupURL);
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

?>