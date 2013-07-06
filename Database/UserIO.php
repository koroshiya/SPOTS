<?php

/**
*File: UserIO.php
*Author: Koro
*Date created: 06/July/2012
*Date last modified: 06/July/2012
*Version: 1.00
*Changelog: 
*Purpose: Provides methods for interacting with User objects in the database
**/ 

	include 'Connection.php';
	
	function deleteUser($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'delete_user';
		
		$row = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
	
	function insertUser($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userName, $userPassword, $userRole, $email, $title){
		
		$procedure_name = 'delete_user';
		
		$array = [
				"userName" => $userName,
				"userPassword" => $userPassword,
				"userRole" => $userRole,
				"email" => $email,
				"title" => $title,
		];
		$row = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $array);
		return $row[0];
		
	}

?>