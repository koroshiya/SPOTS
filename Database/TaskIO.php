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
	//echo getUserTaskCount($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);

	//Returns the number of tasks assigned to a user
	function getUserTaskCount($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'get_user_task_count';
		
		$row = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}

	//TODO: number of unfinished tasks, number of complete tasks, actual tasks, actual incomplete tasks, actual complete tasks

?>