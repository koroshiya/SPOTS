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
	function isWebMaster($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'is_webmaster';
		
		$row = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
	
	//If the user is the site founder, returns true
	function isFounder($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'is_founder';
		
		$row = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
?>