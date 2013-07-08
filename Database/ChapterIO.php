<?php

	include 'Connection.php';

	//Example usage:

	function addChapter($seriesID, $chapterNumber, $chapterSubNumber){
		
		$procedure_name = 'insert_chapter';
		$args = array($groupName, $URL);
		$result = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args);

		return $result;
	} //insert_chapter

	function deleteChapter($seriesID, $chapterNumber, $chapterSubNumber){
		
		$procedure_name = 'delete_chapter';
		$args = array($groupName, $URL);
		$result = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args);

		return $result;
	} //delete_chapter

	function deleteChapterForce($seriesID, $chapterNumber, $chapterSubNumber){
		
		$procedure_name = 'delete_chapter_force';
		$args = array($groupName, $URL);
		$result = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args);

		return $result;
	} //delete_chapter_force

	/**
	 * Attaches an existing group to the chapter.
	 * If the chapter already has 3 groups attached, or the group is already attached, function returns false.
	 *
	 * @return True or false, depending on success
	 **/
	function attachGroup($seriesID, $chapterNumber, $chapterSubNumber, $newGroupID){
		
		$procedure_name = 'chapter_add_group';
		$args = array($groupName, $URL);
		$result = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args);

		return $result;
	} //chapter_add_group

?>