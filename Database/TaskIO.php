<?php

/**
*File: TaskIO.php
*Author: Koro
*Date created: 06/July/2012
*Changelog: 1.01: Added getUser* and getUserCount* functions
					Added IO functions
			1.02: Implemented chapter functions, implemented/updated others
*Purpose: Provides methods for interacting with Task objects in the database
**/ 

	include 'Connection.php';

	//Example usage:
	//echo getUserTaskCount(1);

	//Creates a new task using the parameters passed in
	function addTask($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole){
		return executeIOFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, 'insert_task');
	}

	//Deletes an existing task corresponding to the Primary Keys passed in
	function deleteTask($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole){
		return executeIOFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, 'delete_task');
	}

	//Sets/updates a task's status
	function updateStatus($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $status){
		return executeFullFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $status, 'task_set_status');
	}

	//Sets/updates a task's description
	function updateDescription($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $description){
		return executeFullFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $description, 'task_set_description');
	}


	//Returns the number of tasks assigned to a user
	function getUserTaskCount($userID){
		return executeUserFunction($userID, 'get_user_task_count');
	}

	//Returns the number of incomplete tasks assigned to a user
	function getUserActiveTaskCount($userID){
		return executeUserFunction($userID, 'get_user_task_count_active');
	}

	//Returns the number of completed tasks assigned to a user
	function getUserCompleteTaskCount($userID){
		return executeUserFunction($userID, 'get_user_task_count_complete');
	}

	//Retrieves all tasks that a specific user has assigned to them
	function getUserTasks($userID){
		return executeUserProcedure($userID, 'get_user_tasks');
	}

	//Retrieves all tasks that a specific user has not completed
	function getUserActiveTasks($userID){
		return executeUserProcedure($userID, 'get_user_tasks_active');
	}

	//Retrieves all tasks that a specific user has completed
	function getUserCompleteTasks($userID){
		return executeUserProcedure($userID, 'get_user_tasks_complete');
	}


	//Returns the number of tasks associated with a chapter
	function getChapterTaskCount($seriesID, $chapterNumber, $chapterSubNumber){
		return executeChapterFunction($seriesID, $chapterNumber, $chapterSubNumber, 'get_chapter_task_count');
	}

	//Returns the number of incomplete tasks associated with a chapter
	function getChapterActiveTaskCount($seriesID, $chapterNumber, $chapterSubNumber){
		return executeChapterFunction($seriesID, $chapterNumber, $chapterSubNumber, 'get_chapter_task_count_active');
	}

	//Returns the number of complete tasks associated with a chapter
	function getChapterCompleteTaskCount($seriesID, $chapterNumber, $chapterSubNumber){
		return executeChapterFunction($seriesID, $chapterNumber, $chapterSubNumber, 'get_chapter_task_count_complete');
	}

	//Retrieves all tasks associated with a specific chapter
	function getChapterTasks($seriesID, $chapterNumber, $chapterSubNumber){
		return executeChapterFunction($seriesID, $chapterNumber, $chapterSubNumber, 'get_chapter_tasks');
	}

	//Retrieves all incomplete tasks associated with a specific chapter
	function getChapterActiveTasks($seriesID, $chapterNumber, $chapterSubNumber){
		return executeChapterFunction($seriesID, $chapterNumber, $chapterSubNumber, 'get_chapter_tasks_active');
	}

	//Retrieves all complete tasks associated with a specific chapter
	function getChapterCompleteTasks($seriesID, $chapterNumber, $chapterSubNumber){
		return executeChapterFunction($seriesID, $chapterNumber, $chapterSubNumber, 'get_chapter_tasks_complete');
	}


	function getTaskStatus($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole){
		
		$charStatus = executeIOFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, 'get_task_status');

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

	function executeUserProcedure($userID, $procedure_name){

		global $connection;
		
		$result = executeStoredProcedure($procedure_name, $userID, $connection);
		return $result;

	}

	function executeUserFunction($userID, $procedure_name){

		global $connection;
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}

	function executeChapterFunction($seriesID, $chapterNumber, $chapterSubNumber, $procedure_name){

		$args = [
				"seriesID" => $seriesID,
				"chapterNumber" => $chapterNumber,
				"chapterSubNumber" => $chapterSubNumber,
		];

		global $connection;
		
		$row = executeFunction($procedure_name, $args, $connection);
		return $row[0];
		
	}

	function executeIOFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $procedure_name){

		$args = [
				"seriesID" => $seriesID,
				"chapterNumber" => $chapterNumber,
				"chapterSubNumber" => $chapterSubNumber,
				"userID" => $userID,
				"userRole" => $userRole,
		];

		global $connection;
		
		$row = executeFunction($procedure_name, $args, $connection);
		return $row[0];
		
	}

	/**
	 *@param $var An additional variable to throw into the procedure, such as status or description
	 */
	function executeFullFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, $var, $procedure_name){

		$args = [
				"seriesID" => $seriesID,
				"chapterNumber" => $chapterNumber,
				"chapterSubNumber" => $chapterSubNumber,
				"userID" => $userID,
				"userRole" => $userRole,
				"var" => $var,
		];

		global $connection;
		
		$row = executeFunction($procedure_name, $args, $connection);
		return $row[0];
		
	}

?>