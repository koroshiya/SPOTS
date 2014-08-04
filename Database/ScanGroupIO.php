<?php

	require_once(databaseDir . 'Connection.php');

	/**
	 * Adds a new group to the DB.
	 * 
	 * @param $groupName Name for the new group.
	 * @param $URL URL for the new group.
	 **/
	function addGroup($groupName, $URL){
		$names = array('groupName', 'URL');
		$params = array($groupName, $URL);
		return insertIntoTable('ScanGroup', $names, $params);
	}

	/**
	 * Deletes an existing group from the DB.
	 * Fails if any ChapterGroup objects exist for this group.
	 * 
	 * @param $groupID ID of the group to delete.
	 */
	function deleteGroup($groupID){
		if ($groupID == homeGroup){
			return False; //can't delete home group
		}
		connectToMeekro();
		$result = DB::query("SELECT delete_scangroup(%i);", $groupID);
		return $result;
	}

	/**
	 * Deletes an existing group from the DB.
	 * 
	 * @param $groupID ID of the group to delete.
	 */
	function deleteGroupForce($groupID){
		if ($groupID == homeGroup){
			return False; //can't delete home group
		}
		connectToMeekro();
		$result = DB::query("SELECT delete_scangroup_force(%i);", $groupID);
		return $result;
	}

	/**
	 * Modifies an existing group in the DB.
	 * 
	 * @param $groupID ID of the group to modify.
	 * @param $groupName New name for the group (null if it should remain the same)
	 * @param $groupURL New URL for the group (null if it should remain the same)
	 **/
	function modifyGroup($groupID, $groupName, $groupURL){
		connectToMeekro();
		$result = DB::query("SELECT modify_scangroup(%i, %s, %s);", $groupID, $groupName, $groupURL);
		return $result;
	}

	function getGroupsInOrder($start){
		connectToMeekro();
		$result = DB::query("SELECT * FROM ScanGroup LIMIT %i, %i;", $start, 20);
		return $result;
	}

?>