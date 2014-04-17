<?php

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
		if (!is_numeric($userID)){
			return array(False);
		}
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
		if (!is_numeric($userID)){
			return array(False);
		}
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
		if (!is_numeric($userID)){
			return array(False);
		}
		return executeChapterFunction($userID, 'get_user_task_count_complete');
	}

	function getTasks($start){
		if (!$start || !is_numeric($start)){
			$start = 0;
		}
		$proc = "SELECT * FROM Task limit $start, 10;";
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

	function getFullyDefinedTasks($args, $start, $userID){

		connectToMeekro();

		$clause = False;
		$where = new WhereClause('and');
		if (!is_null($args[1])){
			$where->add('userRole=%i', $args[1]);
			$clause = True;
		}
		if (!is_null($args[2])){
			$where->add('status=%s', $args[2]);
			$clause = True;
		}
		if (!is_null($userID)){
			$where->add('userID=%i', $userID);
			$clause = True;
		}
		if (!is_null($args[0])){
			if ($clause){
				$result = DB::query("SELECT * FROM Task AS t INNER JOIN Series AS s ON s.seriesID = %i WHERE %l LIMIT %i, %i;", $args[0], $where, $start, 10);
			}else{
				$result = DB::query("SELECT * FROM Task AS t INNER JOIN Series AS s ON s.seriesID = %i LIMIT %i, %i;", $args[0], $start, 10);
			}
		}else{
			if ($clause){
				$result = DB::query("SELECT * FROM Task AS t WHERE %l LIMIT %i, %i;", $where, $start, 10);
			}else{
				$result = DB::query("SELECT * FROM Task AS t LIMIT %i, %i;", $start, 10);
			}
		}

		return $result;

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