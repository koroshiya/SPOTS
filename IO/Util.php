<?php
/**
*File: Util.php
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 05/July/2012
*Version: 1.01
*Changelog: 
*			1.01: Changed MySQL methods to MySQLi, implemented isWebMaster, isFounder, getUserTaskCount, etc.
*					Added support for multi-argument stored procedures
*Purpose: Acts as an IO driver for interacting with the database.
*/ 

	$mysql_host = 'localhost';
	$mysql_user = '';
	$mysql_password = '';
	$mysql_database = 'SPMS';

	echo getProjectCount($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	echo "<br />";
	echo getUserTaskCount($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);
	echo "<br />";
	echo isWebMaster($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);
	echo "<br />";
	echo isFounder($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);
	echo "<br />";
	
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
		
		$row =  connectAndExecuteSingleStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database);
		return $row[0];
		
	}
	
	function getUserTaskCount($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'get_user_task_count';
		
		$row = connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
	
	function isWebMaster($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'is_webmaster';
		
		$row = connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
	
	function isFounder($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'is_founder';
		
		$row = connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
	
	function deleteUser($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'delete_user';
		
		$row = connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
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
		$row = connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $array);
		return $row[0];
		
	}
		
	/**
	 * Executes a stored procedure with no arguments.
	 *  
	 * @param $procedure_name Name of the stored procedure to run WITHOUT the brackets. eg. function, not function() or function(integer)
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @param $mysql_database Password of the database for which to create a connection
	 * @return Result of the executed procedure
	 * */
	function connectAndExecuteSingleStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database){
		
		return connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, null);
		
	}
	
	/**
	 * Executes a stored procedure.
	 *  
	 * @param $procedure_name Name of the stored procedure to run WITHOUT the brackets. eg. function, not function() or function(integer)
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @param $mysql_database Password of the database for which to create a connection
	 * @param $args Array of arguments, or single argument, to pass into the stored procedure
	 * @return Result of the executed procedure
	 * */
	function connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args){
	
		$connection = connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	
		if ($connection === FALSE){
			echo "Connection failed<br />";
			return false;
		}
	
		$result = executeResultProcedure($connection, $procedure_name, $args);
		
		if ($result === FALSE) {
			mysqli_close($connection);
			echo "Failed<br />";
			return false;
		}
		$row = mysqli_fetch_array($result);
		mysqli_free_result($result);
		mysqli_close($connection);
		return $row;
	
	}
	
	
	/**
	 * Attempts to connect to MySQL on the target machine with the credentials supplied
	 * 
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @param $mysql_database Password of the database for which to create a connection
	 * @return False if the connection failed, otherwise returns the established connection
	 * */
	function connect($mysql_host, $mysql_user, $mysql_password, $mysql_database){
		
		$connection = @mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
		return $connection;
		
	}
	
	/**
	 * Executes a stored procedure, passing in a list of arguments (or single argument).
	 *  
	 * @param $connection Established database connection through which the procedure will be invoked
	 * @param $procedure_name Name of the stored procedure to run WITHOUT the brackets. eg. function, not function() or function(integer)
	 * @param $arr Array of arguments, or single argument, to pass into the stored procedure
	 * @return False if the connection failed, otherwise the resultset of the procedure is returned.
	 * */
	function executeResultProcedure($connection, $procedure_name, $arr){
		
		if ($connection){
				
			echo "Connected<br />";
			
			$query = "select $procedure_name(";
			if (is_array($arr)){
				$arrSize = count($arr);
				for ($i = 1; $i <= $arrSize; $i++) {
					$query .= $i;
					if ($i != $arrSize){
						$query .= ', ';
					}
				}
			}else if ($arr != null){
				$query .= $arr;
			}
			$query .= ");";
			echo "query: $query<br />";
			return mysqli_query($connection, $query);
			
		}else {
			
			echo 'Connection refused<br />';
			return FALSE;
			
		}
		
	}
	

?>
