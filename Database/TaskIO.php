<?php

/**
 *File: TaskIO.php
 *Author: Koro
 *Date created: 06/July/2012
 *Changelog: 1.01: Added getUser* and getUserCount* functions
 *					Added IO functions
 *			1.02: Implemented chapter functions, implemented/updated others
 *			1.03: Reduced repeat params, removed no longer necessary functions
 *Purpose: Provides methods for interacting with Task objects in the database
**/ 

	require_once('Connection.php');

	//Example usage:
	//echo getUserTaskCount(1);

	/**
	 * Pushes the different parameters necessary to define a specific task into one array.
	 * 
	 * @param $seriesID ID of the series to which the task belongs. (mandatory)
	 * @param $chapterNumber Whole number representing the chapter number. (mandatory)
	 * @param $chapterSubNumber Point number for the chapter. (mandatory)
	 * eg. If $chapterNumber was 10 and $chapterSubNumber was 5, you would be specifying chapter 10.5
	 * @param $userID (optional; null if not required)
	 * @param $userRole (optional; null if not required)
	 * @param $status (optional; null if not required)
	 * @param $description (optional; null if not required)
	 *
	 * @return An array containing the necessary parameters to define a specific task.
	 */
	function setTaskParams($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $status, $description){
		return array($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $status, $description);
	}

	/**
	 * Creates a new task using the parameters passed in
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function addTask($args){
		return executeChapterFunction($args, 'insert_task');
	}

	/**
	 * Deletes an existing task corresponding to the Primary Keys passed in.
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function deleteTask($args){
		return executeChapterFunction($args, 'delete_task');
	}

	/**
	 * Sets/updates a task's status.
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $status
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function updateStatus($args){
		return executeChapterFunction($args, 'task_set_status');
	}

	/**
	 * Sets/updates a task's description
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $description
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function updateDescription($args){
		return executeChapterFunction($args, 'task_set_description');
	}
	
	/**
	 * Returns the number of tasks assigned to a user.
	 *
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns the total number of tasks a specific user has assigned to them.
	 */
	function getUserTaskCount($userID){
		return executeChapterFunction($userID, 'get_user_task_count');
	}

	/**
	 * Returns the number of incomplete tasks assigned to a user.
	 *
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns the total number of tasks a specific user has started, but not completed.
	 */
	function getUserActiveTaskCount($userID){
		return executeChapterFunction($userID, 'get_user_task_count_active');
	}

	/**
	 * Returns the number of completed tasks assigned to a user.
	 *
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns the total number of tasks a specific user has completed.
	 */
	function getUserCompleteTaskCount($userID){
		return executeChapterFunction($userID, 'get_user_task_count_complete');
	}

	/**
	 * Retrieves all tasks that a specific user has assigned to them
	 *
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns all tasks pertaining to a specific user.
	 */
	function getUserTasks($userID){
		$userID = getEscapedSQLParam($userID);
		$proc = "SELECT * FROM Task AS t WHERE t.userID = $userID;";
		return executeStoredProcedure($proc);
	}

	/**
	 * Retrieves all tasks that a specific user has not completed.
	 *
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns all tasks that a specific user has started, but not completed.
	 */
	function getUserActiveTasks($userID){
		$userID = getEscapedSQLParam($userID);
		$proc = "SELECT * FROM Task AS t WHERE t.userID = $userID AND NOT t.status = 'C';";
		return executeStoredProcedure($proc);
	}

	/**
	 * Retrieves all tasks that a specific user has completed.
	 * 
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns all tasks that a specific user has completed.
	 */
	function getUserCompleteTasks($userID){
		$userID = getEscapedSQLParam($userID);
		$proc = "SELECT * FROM Task AS t WHERE t.userID = $userID AND t.status = 'C';";
		return executeStoredProcedure($proc);
	}

	/**
	 * Returns the number of tasks associated with a chapter
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function getChapterTaskCount($args){
		return executeChapterFunction($args, 'get_chapter_task_count');
	}

	/**
	 * Returns the number of incomplete tasks associated with a chapter
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function getChapterActiveTaskCount($args){
		return executeChapterFunction($args, 'get_chapter_task_count_active');
	}

	/**
	 * Returns the number of complete tasks associated with a chapter
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function getChapterCompleteTaskCount($args){
		return executeChapterFunction($args, 'get_chapter_task_count_complete');
	}

	/**
	 * Retrieves all tasks associated with a specific chapter.
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function getChapterTasks($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$args[1] = getEscapedSQLParam($args[1]);
		$args[2] = getEscapedSQLParam($args[2]);
		$proc = "SELECT * FROM Task AS t WHERE t.seriesID = $args[0] AND t.chapterNumber = $args[1] AND t.chapterSubNumber = $args[2];";
		return executeStoredProcedure($proc);
	}

	/**
	 * Retrieves all incomplete tasks associated with a specific chapter.
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function getChapterActiveTasks($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$args[1] = getEscapedSQLParam($args[1]);
		$args[2] = getEscapedSQLParam($args[2]);
		$proc = "SELECT * FROM Task AS t WHERE t.seriesID = $args[0] AND t.chapterNumber = $args[1] AND t.chapterSubNumber = $args[2];";
		return executeStoredProcedure($proc);
	}

	/**
	 * Retrieves all complete tasks associated with a specific chapter.
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function getChapterCompleteTasks($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$args[1] = getEscapedSQLParam($args[1]);
		$args[2] = getEscapedSQLParam($args[2]);
		$proc = "SELECT * FROM Task AS t WHERE t.seriesID = $args[0] AND t.chapterNumber = $args[1] AND t.chapterSubNumber = $args[2];";
		return executeStoredProcedure($proc);
	}

	function getFullyDefinedTasks($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$args[1] = getEscapedSQLParam($args[1]);
		$args[2] = getEscapedSQLParam($args[2]);
		$proc = "SELECT * FROM Task AS t INNER JOIN Series AS s ON s.visibleToPublic = true WHERE s.seriesTitle = $args[0] AND t.userRole = $args[1] AND t.status = $args[2];";
		return executeStoredProcedure($proc);
	}

	function getDefinedTasksByTitleAndRole($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$args[1] = getEscapedSQLParam($args[1]);
		$proc = "SELECT * FROM Task AS t INNER JOIN Series AS s ON s.visibleToPublic = true WHERE s.seriesTitle = $args[0] AND t.userRole = $args[1];";
		return executeStoredProcedure($proc);
	}

	function getDefinedTasksByRoleAndStatus($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$args[1] = getEscapedSQLParam($args[1]);
		$proc = "SELECT * FROM Task AS t INNER JOIN Series AS s ON s.visibleToPublic = true WHERE t.userRole = $args[0] AND t.status = $args[1];";
		return executeStoredProcedure($proc);
	}

	function getDefinedTasksByTitleAndStatus($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$args[1] = getEscapedSQLParam($args[1]);
		$proc = "SELECT * FROM Task AS t INNER JOIN Series AS s ON s.visibleToPublic = true WHERE s.seriesTitle = $args[0] AND t.status = $args[1];";
		return executeStoredProcedure($proc);
	}

	function getDefinedTasksByTitle($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$proc = "SELECT * FROM Task AS t INNER JOIN Series AS s ON s.visibleToPublic = true WHERE s.seriesTitle = $args[0];";
		return executeStoredProcedure($proc);
	}

	function getDefinedTasksByRole($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$proc = "SELECT * FROM Task AS t INNER JOIN Series AS s ON s.visibleToPublic = true WHERE t.userRole = $args[0];";
		return executeStoredProcedure($proc);
	}

	function getDefinedTasksByStatus($args){
		$args[0] = getEscapedSQLParam($args[0]);
		$proc = "SELECT * FROM Task AS t INNER JOIN Series AS s ON s.visibleToPublic = true WHERE t.status = $args[0];";
		return executeStoredProcedure($proc);
	}

	/**
	 * Converts a char to its equivalent status string. eg. d = dropped.
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return Status as string corresponding to char thrown in.
	 */
	function getTaskStatus($args){
		
		$charStatus = executeChapterFunction($args, 'get_task_status');

		if ($charStatus === 'A'){
			return 'Active';
		}else if ($charStatus === 'I'){
			return 'Inactive';
		}else if ($charStatus === 'S'){
			return 'Stalled';
		}else if ($charStatus === 'C'){
			return 'Complete';
		}else {
			return 'N/A';
		}

	}

	/**
	 * Executes a function using a variable set of possible Task params.
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber
	 *
	 * @param $args Arguments to process with this function.
	 * @param $procedure_name Name of the procedure to execute.
	 *
	 * @return False if command failed, otherwise returns the result of the function.
	 */
	function executeChapterFunction($args, $procedure_name){
		
		$row = executeFunction($procedure_name, $args);
		return $row[0];
		
	}

?>