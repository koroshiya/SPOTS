<?php

	require_once(databaseDir . 'Connection.php');

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
		$names = array('seriesID', 'chapterNumber', 'chapterSubNumber', 'userID', 'description', 'status', 'userRole');
		$params = array($args[0], $args[1], $args[2], $args[3], 'NULL', 'A', $args[4]);
		return insertIntoTable('Task', $names, $params);
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
		connectToMeekro();
		$result = DB::query("DELETE FROM Task WHERE Task.seriesID = %i AND Task.chapterNumber = %i AND Task.chapterSubNumber = %i AND Task.userID = %i AND Task.userRole = %s;", $args[0], $args[1], $args[2], $args[3], $args[4]);
		return $result;		
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
		connectToMeekro();
		$result = DB::query("UPDATE Task AS t SET t.status = %s WHERE t.seriesID = %i AND t.chapterNumber = %i AND t.chapterSubNumber = %i AND t.userID = %i AND t.userRole = %s;", $args[5], $args[0], $args[1], $args[2], $args[3], $args[4]);
		return $result;
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
		connectToMeekro();
		$result = DB::query("UPDATE Task AS t SET t.description = %s WHERE t.seriesID = %i AND t.chapterNumber = %i AND t.chapterSubNumber = %i AND t.userID = %i AND t.userRole = %s;", $args[5], $args[0], $args[1], $args[2], $args[3], $args[4]);
		return $result;
	}
	
	/**
	 * Returns the number of tasks assigned to a user.
	 *
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns the total number of tasks a specific user has assigned to them.
	 */
	function getUserTaskCount($userID, $status){
		connectToMeekro();
		if (is_null($status)) {
			$result = DB::query("SELECT COUNT(*) FROM Task AS t WHERE t.userID = %i;", $userID);
		}else{
			$result = DB::query("SELECT COUNT(*) FROM Task AS t WHERE t.userID = %i AND t.status = %s;", $status);
		}
		return current($result[0]);
	}

	/**
	 * Returns the number of incomplete tasks assigned to a user.
	 *
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns the total number of tasks a specific user has started, but not completed.
	 */
	function getUserActiveTaskCount($userID){
		return getUserTaskCount($userID, 'A');
	}

	/**
	 * Returns the number of completed tasks assigned to a user.
	 *
	 * @param $userID ID of the user for whom to process the command.
	 *
	 * @return Returns the total number of tasks a specific user has completed.
	 */
	function getUserCompleteTaskCount($userID){
		return getUserTaskCount($userID, 'C');
	}

	function getTasks($start){
		connectToMeekro();
		$result = DB::query("SELECT * FROM Task limit %i, %i;", $start, 10);
		return $result;
	}

	/**
	 * Returns the number of tasks associated with a chapter
	 * Mandatory: $seriesID, $chapterNumber, $chapterSubNumber
	 *
	 * @param $args Arguments to process with this function.
	 *
	 * @return True if successful, otherwise false.
	 */
	function getChapterTaskCount($args, $status){
		connectToMeekro();
		if (is_null($status)) {
			$result = DB::query("SELECT COUNT(*) INTO total FROM Task AS t WHERE t.seriesID = %i AND t.chapterNumber = %i AND t.chapterSubNumber = %i;", $args[0], $args[1], $args[2]);
		}else{
			$result = DB::query("SELECT COUNT(*) INTO total FROM Task AS t WHERE t.seriesID = %i AND t.chapterNumber = %i AND t.chapterSubNumber = %i AND t.status = %s;", $args[0], $args[1], $args[2], $status);
		}
		return $result;
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
		return getChapterTaskCount($args, 'A');
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
		return getChapterTaskCount($args, 'C');
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
		connectToMeekro();
		$result = DB::query("SELECT * FROM Task AS t WHERE t.seriesID = %i AND t.chapterNumber = %i AND t.chapterSubNumber = %i;", $args[0], $args[1], $args[2]);
		return $result;
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
		//var_dump($where);
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
		
		connectToMeekro();
		$charStatus = DB::query("SELECT t.status FROM Task AS t WHERE t.seriesID = %i AND t.chapterNumber = %i AND t.chapterSubNumber = %i AND t.userID = %i AND t.userRole = %s;", $args[0], $args[1], $args[2], $args[3], $args[4]);

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

?>