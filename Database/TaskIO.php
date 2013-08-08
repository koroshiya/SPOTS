<?php

/**
*File: TaskIO.php
*Author: Koro
*Date created: 06/July/2012
*Changelog: 1.01: Added getUser* and getUserCount* functions
					Added IO functions
*Purpose: Provides methods for interacting with Task objects in the database
**/ 

	include 'Connection.php';

	//Example usage:
	//echo getUserTaskCount(1);
	//TODO: get task by chapter

	//Creates a new task using the parameters passed in
	function addTask($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole){
		return executeIOFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, 'insert_task');
	}

	//Deletes an existing task corresponding to the Primary Keys passed in
	function deleteTask($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole){
		return executeIOFunction($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole, 'delete_task');
	}

	//modifyTask
	function modifyTask($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole){
		//return executeFullFunction( 'modify_task'); //TODO
	}

	//updateStatus
	function updateStatus($seriesID, $chapterNumber, $chapterSubNumber, $userID, $userRole){
		//return executeFullFunction( 'task_update_status'); //TODO
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
	getUserTasks($userID){
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

	function executeUserProcedure($userID, $procedure_name){

		if (!(validID($userID))){
			return false;
		}

		global $connection;
		
		$result = executeStoredProcedure($procedure_name, $userID, $connection);
		return $result;

	}

	function executeUserFunction($userID, $procedure_name){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		
		$row = executeFunction($procedure_name, $userID, $connection);
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

?>