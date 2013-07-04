<?php
/**
*File: Util.php
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 04/July/2012
*Version: 1.0
*Changelog: 
*Purpose: Acts as an IO driver for interacting with the database.
*/ 

	$mysql_host = 'localhost';
	$mysql_user = '';
	$mysql_password = '';
	$mysql_database = 'SPMS';
	
	echo getProjectCount($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	
	/**
	 * Example method for the use of this class.
	 * If the database has been set up properly, returns the number of Series currently in the DB.
	 *  
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @param $mysql_database Password of the database for which to create a connection
	 * @return Number of projects ("Series" in the DB). If connection failed, returns false.
	 * */
	function getProjectCount($mysql_host, $mysql_user, $mysql_password, $mysql_database){
		
		$procedure_name = 'get_project_count';
		
		return connectAndExecuteSingleResultProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database);
		
	}
	
	/**
	 * Executes a stored procedure that accepts a single OUT argument.
	 *  
	 * @param $procedure_name Name of the stored procedure to run WITHOUT the brackets. eg. function, not function() or function(integer)
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @param $mysql_database Password of the database for which to create a connection
	 * @return Result of the executed procedure
	 * */
	function connectAndExecuteSingleResultProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database){
		
		$connection = connect($mysql_host, $mysql_user, $mysql_password);
		
		if ($connection === FALSE){
			return false;
		}
		
		$result = executeSingleResultProcedure($connection, $mysql_database, $procedure_name);
		
		if ($result === FALSE) {
			mysql_close($connection);
			return false;
		}
		$row = mysql_fetch_array($result);
		mysql_close($connection);
		return $row[0];
		
	}
	
	
	/**
	 * Attempts to connect to MySQL on the target machine with the credentials supplied
	 * 
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @return False if the connection failed, otherwise returns the established connection
	 * */
	function connect($mysql_host, $mysql_user, $mysql_password){
		
		$connection = @mysql_connect($mysql_host, $mysql_user, $mysql_password);
		return $connection;
		
	}
	
	/**
	 * Executes a stored procedure that accepts a single OUT argument.
	 *  
	 * @param $connection Established database connection through which the procedure will be invoked
	 * @param $mysql_database Password of the database for which to create a connection
	 * @param $procedure_name Name of the stored procedure to run WITHOUT the brackets. eg. function, not function() or function(integer)
	 * @return False if the connection failed, otherwise the result of the procedure is returned.
	 * */
	function executeSingleResultProcedure($connection, $mysql_database, $procedure_name){
		
		if ($connection && @mysql_select_db($mysql_database)){
				
			echo 'Connected!<br />';
			$total = 0;
			$query = "call $procedure_name(@total)";
			$result = mysql_query($query);
			$result = mysql_query('SELECT @total');
			return $result;
			
		}else {
			
			return FALSE;
			
		}
		
	}
	

?>
