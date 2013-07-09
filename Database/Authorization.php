<?php
	
/**
*File: Authorization.php
*Author: Koro
*Date created: 06/July/2012
*Date last modified: 06/July/2012
*Version: 1.00
*Changelog: 
*Purpose: Provides methods for determining user permissions
**/ 

	include 'Connection.php';

	//Example usage:
	//echo isWebMaster($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);
	//echo isFounder($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);

	//If the user is the webmaster, returns true
	function isWebMaster($userID){
		
		if (!validID($userID)){
			return false;
		}

		global $connection;
		$procedure_name = 'is_webmaster';
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}
	
	//If the user is the site founder, returns true
	function isFounder($userID){
				
		if (!validID($userID)){
			return false;
		}

		global $connection;
		$procedure_name = 'is_founder';
		
		$row = executeFunction($procedure_name, $userID, $connection);
		return $row[0];
		
	}
?>