<?php

	require_once(databaseDir . 'Connection.php');

	/**
	 * @param $seriesID ID of the series to which the chapter belongs.
	 * @param $chapterNumber Whole number representing the chapter number.
	 * @param $chapterSubNumber Point number for the chapter. 
	 * eg. If $chapterNumber was 10 and $chapterSubNumber was 5, you would be specifying chapter 10.5
	 */

	/**
	 * Adds a new chapter to the database.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 */
	function addChapter($seriesID, $chapterNumber, $chapterSubNumber){

		connectToMeekro();
		$result = DB::query("SELECT insert_chapter(%i, %i, %i);", $seriesID, $chapterNumber, $chapterSubNumber);
		return $result[0];

	}

	/**
	 * Removes a chapter from the database.
	 * Command will fail if any incomplete tasks pertaining to the chapter exist.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 */
	function deleteChapter($seriesID, $chapterNumber, $chapterSubNumber){

		connectToMeekro();
		$result = DB::query("SELECT delete_chapter(%i, %i, %i);", $seriesID, $chapterNumber, $chapterSubNumber);
		return $result[0];

	}

	/**
	 * Removes a chapter from the database.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 */
	function deleteChapterForce($seriesID, $chapterNumber, $chapterSubNumber){

		connectToMeekro();
		$result = DB::query("SELECT delete_chapter_force(%i, %i, %i);", $seriesID, $chapterNumber, $chapterSubNumber);
		return $result[0];

	}

	function modifyChapter($args, $newArgs){
		//TODO
	}

	/**
	 * Sets the revision number of the chapter.
	 * eg. If the chapter has been revised once since release, revision number would be 1.
	 *
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * @param $revision Revision number to set.
	 */
	function modifyChapterRevision($seriesID, $chapterNumber, $chapterSubNumber, $revision){

		connectToMeekro();
		$result = DB::query("SELECT chapter_revision_modify(%i, %i, %i, %i);", $seriesID, $chapterNumber, $chapterSubNumber, $revision);
		return $result[0];

	}

	/**
	 * Attaches an existing group to the chapter.
	 * If the group is already attached, function returns false.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * @param $newGroupID ID of the group to attach to a chapter.
	 **/
	function attachGroup($seriesID, $chapterNumber, $chapterSubNumber, $newGroupID){

		connectToMeekro();
		$result = DB::query("SELECT chapter_add_group(%i, %i, %i, %i);", $seriesID, $chapterNumber, $chapterSubNumber, $newGroupID);
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
	function removeGroup($seriesID, $chapterNumber, $chapterSubNumber, $newGroupID){

		connectToMeekro();
		$result = DB::query("SELECT chapter_remove_group(%i, %i, %i, %i);", $seriesID, $chapterNumber, $chapterSubNumber, $newGroupID);
		return $result[0];

	}

	/**
	 * Removes all groups attached to a chapter.
	 * 
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 *
	 * @return True or false, depending on success.
	 **/
	function removeGroupAll($seriesID, $chapterNumber, $chapterSubNumber){

		connectToMeekro();
		$result = DB::query("SELECT chapter_remove_group_all(%i, %i, %i);", $seriesID, $chapterNumber, $chapterSubNumber);
		return $result[0];

	}

	/**
	 * Checks if a chapter is visible to guest users or not.
	 *
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 */
	function isChapterVisible($seriesID, $chapterNumber, $chapterSubNumber){

		connectToMeekro();
		$result = DB::query("SELECT is_visible_chapter(%i, %i, %i);", $seriesID, $chapterNumber, $chapterSubNumber);
		return $result[0];

	}

	/**
	 * Makes a chapter visible or invisible to guest users.
	 *
	 * @param $args Array of arguments necessary to uniquely identify a specific chapter.
	 * @param $visible Boolean value indicating the new visibility of the chapter.
	 */
	function setChapterVisible($seriesID, $chapterNumber, $chapterSubNumber, $visible){

		connectToMeekro();
		$result = DB::query("SELECT chapter_set_visible(%i, %i, %i, %s);", $seriesID, $chapterNumber, $chapterSubNumber, $visible);
		return $result[0];

	}

	function getChapterBySeriesId($seriesID){
		connectToMeekro();
		$result = DB::query("SELECT * FROM Series AS s WHERE s.seriesID = %i;", $seriesID);
		return $result;
	}

	function getChapterListByGroupId($groupID, $start){
		if (!$start){
			$start = 0;
		}

		connectToMeekro();
		$result = DB::query("SELECT * FROM ChapterGroup AS s INNER JOIN Chapter AS c ON c.seriesID = s.seriesID AND c.chapterNumber = s.chapterNumber AND c.chapterSubNumber = s.chapterSubNumber WHERE s.seriesID = %i LIMIT %i, %i;", $groupID, $start, 10);
		return $result;
	}

	function getChapterListRecentByGroupId($groupID, $start, $total){
		if (!$total){
			$total = 0;
		}
		if (!$start){
			$start = 0;
		}
		$start = $total - $start;

		connectToMeekro();
		$result = DB::query("SELECT * FROM ChapterGroup AS s INNER JOIN Chapter AS c ON c.seriesID = s.seriesID AND c.chapterNumber = s.chapterNumber AND c.chapterSubNumber = s.chapterSubNumber WHERE s.seriesID = %i LIMIT %i, %i;", $groupID, $start, 10);
		return $result;
	}

	function getChapterCountByGroupId($groupID){

		connectToMeekro();
		$result = DB::query("SELECT COUNT(*) AS count FROM ChapterGroup AS s WHERE s.seriesID = %i;", $groupID);
		return current($result[0]);

	}

?>