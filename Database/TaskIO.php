<?php

/**
*File: TaskIO.php
*Author: Koro
*Date created: 06/July/2012
*Date last modified: 06/July/2012
*Version: 1.00
*Changelog: 
*Purpose: Provides methods for interacting with Task objects in the database
**/ 

	include 'Connection.php';

	//Example usage:
	//echo getUserTaskCount(1);

	//Returns the number of tasks assigned to a user
	function getUserTaskCount($userID){
		
		if (!(validID($userID))){
			return false;
		}

		global $connection;
		$procedure_name = 'get_user_task_count';
		
		$row = executeFunction($procedure_name, $userID);
		return $row[0];
		
	}

	function getUserActiveTaskCount(){

	}

	function getUserCompleteTaskCount(){

	}

	getUserTasks(){
		
	}

	function getUserActiveTasks(){

	}

	function getUserCompleteTasks(){

	}

	//TODO: number of unfinished tasks, number of complete tasks, actual tasks, actual incomplete tasks, actual complete tasks

?>