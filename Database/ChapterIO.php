<?php

	include 'Connection.php';

	//Example usage:

	/**
	 * Common parameters:
	 * @param $seriesID ID of the series to which the chapter belongs
	 * @param $chapterNumber Whole number representing the chapter number
	 * @param $chapterSubNumber Point number for the chapter. 
	 * eg. If $chapterNumber was 10 and $chapterSubNumber was 5, you would be specifying chapter 10.5
	 */

	function addChapter($seriesID, $chapterNumber, $chapterSubNumber){
		
		global $connection;
		$procedure_name = 'insert_chapter';
		$args = array($seriesID, $chapterNumber, $chapterSubNumber);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function deleteChapter($seriesID, $chapterNumber, $chapterSubNumber){
		
		global $connection;
		$procedure_name = 'delete_chapter';
		$args = array($seriesID, $chapterNumber, $chapterSubNumber);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function deleteChapterForce($seriesID, $chapterNumber, $chapterSubNumber){
		
		global $connection;
		$procedure_name = 'delete_chapter_force';
		$args = array($seriesID, $chapterNumber, $chapterSubNumber);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	/**
	 * Sets the revision number of the chapter.
	 * eg. If the chapter has been revised once since release, revision number would be 1.
	 *
	 * @param $revision Revision number to set
	 * @return True or false, depending on success
	 */
	function modifyChapterRevision($seriesID, $chapterNumber, $chapterSubNumber, $revision){
		
		global $connection;
		$procedure_name = 'chapter_revision_modify';
		$args = array($seriesID, $chapterNumber, $chapterSubNumber, $revision);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	/**
	 * Attaches an existing group to the chapter.
	 * If the chapter already has 3 groups attached, or the group is already attached, function returns false.
	 *
	 * @return True or false, depending on success
	 **/
	function attachGroup($seriesID, $chapterNumber, $chapterSubNumber, $newGroupID){
		
		global $connection;
		$procedure_name = 'chapter_add_group';
		$args = array($seriesID, $chapterNumber, $chapterSubNumber, $newGroupID);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function isChapterVisible($seriesID, $chapterNumber, $chapterSubNumber){

		global $connection;
		$procedure_name = 'is_visible_chapter';
		$args = array($seriesID, $chapterNumber, $chapterSubNumber);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

	function setChapterVisible($seriesID, $chapterNumber, $chapterSubNumber, $visible){

		global $connection;
		$procedure_name = 'chapter_set_visible';
		$args = array($seriesID, $chapterNumber, $chapterSubNumber, $visible);
		$result = executeFunction($procedure_name, $args, $connection);

		return $result;
	}

?>