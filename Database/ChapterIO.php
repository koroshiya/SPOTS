<?php

	require_once('Connection.php');

	/**
	 * Pushes the different parameters necessary to define a specific chapter into one array.
	 * 
	 * @param $seriesID ID of the series to which the chapter belongs.
	 * @param $chapterNumber Whole number representing the chapter number.
	 * @param $chapterSubNumber Point number for the chapter. 
	 * eg. If $chapterNumber was 10 and $chapterSubNumber was 5, you would be specifying chapter 10.5
	 *
	 * @return An array containing the necessary parameters to define a specific chapter.
	 */
	function setChapterParams($seriesID, $chapterNumber, $chapterSubNumber){
		return array($seriesID, $chapterNumber, $chapterSubNumber);
	}

	/**
	 * Adds a new chapter to the database.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * 
	 * @return True if command was successful, otherwise false.
	 */
	function addChapter($args){
		
		$procedure_name = 'insert_chapter';
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	/**
	 * Removes a chapter from the database.
	 * Command will fail if any incomplete tasks pertaining to the chapter exist.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * 
	 * @return True if command was successful, otherwise false.
	 */
	function deleteChapter($args){
		
		$procedure_name = 'delete_chapter';
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	/**
	 * Removes a chapter from the database.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * 
	 * @return True if command was successful, otherwise false.
	 */
	function deleteChapterForce($args){
		
		$procedure_name = 'delete_chapter_force';
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	function modifyChapter($args, $newArgs){
		//TODO: delete old, attempt to create new. If new fails, recreate old.
	}

	/**
	 * Sets the revision number of the chapter.
	 * eg. If the chapter has been revised once since release, revision number would be 1.
	 *
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * @param $revision Revision number to set.
	 *
	 * @return True or false, depending on success.
	 */
	function modifyChapterRevision($args, $revision){
		
		$procedure_name = 'chapter_revision_modify';
		array_push($args, $revision);
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	/**
	 * Attaches an existing group to the chapter.
	 * If the group is already attached, function returns false.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * @param $newGroupID ID of the group to attach to a chapter.
	 *
	 * @return True or false, depending on success.
	 **/
	function attachGroup($args, $newGroupID){
		
		$procedure_name = 'chapter_add_group';
		array_push($args, $newGroupID);
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	/**
	 * Removes an existing group from the chapter.
	 * If the group isn't attached, function returns false.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * @param $newGroupID ID of the group to remove from a chapter.
	 *
	 * @return True or false, depending on success.
	 **/
	function removeGroup($args, $newGroupID){
		
		$procedure_name = 'chapter_remove_group';
		array_push($args, $newGroupID);
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	/**
	 * Removes all groups attached to a chapter.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 *
	 * @return True or false, depending on success.
	 **/
	function removeGroupAll($args){
		
		$procedure_name = 'chapter_remove_group_all';
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	/**
	 * Checks if a chapter is visible to guest users or not.
	 *
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * 
	 * @return True if the chapter is visible to guest users, otherwise false.
	 */
	function isChapterVisible($args){

		$procedure_name = 'is_visible_chapter';
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	/**
	 * Makes a chapter visible or invisible to guest users.
	 *
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * @param $visible Boolean value indicating the new visibility of the chapter.
	 * 
	 * @return True if the command was successful, otherwise false
	 */
	function setChapterVisible($args, $visible){

		$procedure_name = 'chapter_set_visible';
		array_push($args, $visible);
		$result = executeFunction($procedure_name, $args);
		return $result[0];

	}

	function getChapterBySeriesId($seriesID){
		if (!is_numeric($seriesID)){
			return array(False);
		}
		$proc = "SELECT * FROM Series AS s WHERE s.seriesID = $seriesID;";
		return executeStoredProcedure($proc);
	}

	function getChapterListByGroupId($groupID, $start){
		if (!is_numeric($groupID)){
			return array(False);
		}elseif (!$start || !is_numeric($start)){
			$start = 0;
		}
		$proc = "SELECT * FROM ChapterGroup AS s INNER JOIN Chapter AS c ON c.seriesID = s.seriesID AND c.chapterNumber = s.chapterNumber AND c.chapterSubNumber = s.chapterSubNumber WHERE s.seriesID = $groupID LIMIT $start, 10;";
		return executeStoredProcedure($proc);
	}

	function getChapterListRecentByGroupId($groupID, $start, $total){
		if (!is_numeric($groupID)){
			return array(False);
		}
		if (!$total || !is_numeric($total)){
			$total = 0;
		}
		if (!$start || !is_numeric($start)){
			$start = 0;
		}
		$start = $total - $start;
		$proc = "SELECT * FROM ChapterGroup AS s INNER JOIN Chapter AS c ON c.seriesID = s.seriesID AND c.chapterNumber = s.chapterNumber AND c.chapterSubNumber = s.chapterSubNumber WHERE s.seriesID = $groupID LIMIT $start, 10;";
		return executeStoredProcedure($proc);
	}

	function getChapterCountByGroupId($groupID){
		if (!is_numeric($groupID)){
			return array(False);
		}
		$proc = "SELECT COUNT(*) AS count FROM ChapterGroup AS s WHERE s.seriesID = $groupID;";
		return executeStoredProcedure($proc);
	}

?>