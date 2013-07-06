<?php
/**
*File: Util.php
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 06/July/2012
*Version: 1.02
*Changelog: 
*			1.01: Changed MySQL methods to MySQLi, implemented isWebMaster, isFounder, getUserTaskCount, etc.
*					Added support for multi-argument functions
*			1.02: Added getSeriesByLetter, methods for stored procedures/functions
*Purpose: Acts as an IO driver for interacting with the database. 
*/ 

	$mysql_host = 'localhost';
	$mysql_user = 'root';
	$mysql_password = 'toor';
	$mysql_database = 'SPMS';

	echo getProjectCount($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	echo "<br />";
	echo getUserTaskCount($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);
	echo "<br />";
	echo isWebMaster($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);
	echo "<br />";
	echo isFounder($mysql_host, $mysql_user, $mysql_password, $mysql_database, 1);
	echo "<br />";
	echo getSeriesByLetter($mysql_host, $mysql_user, $mysql_password, $mysql_database, 't');
	
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
		
		$row = connectAndExecuteSingleFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database);
		return $row[0];
		
	}
	
	function getUserTaskCount($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'get_user_task_count';
		
		$row = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
	
	function isWebMaster($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'is_webmaster';
		
		$row = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
	
	function isFounder($mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID){
		
		$procedure_name = 'is_founder';
		
		$row = connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $userID);
		return $row[0];
		
	}
	
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

	/**
	 * @return Returns an array of arrays in the form: array(Series1, Series2, Series3, ...)
	 **/
	function getSeriesByLetter($mysql_host, $mysql_user, $mysql_password, $mysql_database, $character){

		$connection = connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
		if ($connection === FALSE){
			die('Connection failed');
		}

		$query = "call get_series_by_letter('" . $character . "');";
		$result = mysqli_query($connection, $query);
		if ($result === FALSE){
			die('Failed');
		}

		$array = array();
		while ($row = mysqli_fetch_array($result)){
			array_push($array, $row);
		}

		return $array;

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
	function connectAndExecuteSingleFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database){
		
		return connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, null);
		
	}

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
	function connectAndExecuteFunction($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args){
	
		return connectAndExecute($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args, false);
	
	}

	function connectAndExecuteStoredProcedure($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args){
	
		return connectAndExecute($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args, true);
	
	}
	
	function connectAndExecute($procedure_name, $mysql_host, $mysql_user, $mysql_password, $mysql_database, $args, $boolStoredProcedure){

		$connection = connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	
		if ($connection === FALSE){
			echo "Connection failed<br />";
			return false;
		}
	
		$result = FALSE;
		if ($boolStoredProcedure){
			$result = executeStoredProcedure($connection, $procedure_name, $args);
		}else{
			$result = executeFunction($connection, $procedure_name, $args);
		}

		if ($result === FALSE) {
			mysqli_close($connection);
			echo "Failed<br />";
			return false;
		}

		if ($boolStoredProcedure){
			return $result;
		}else{
			$row = mysqli_fetch_array($result);
			mysqli_free_result($result);
			mysqli_close($connection);
			return $row;
		
		}

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
	function executeFunction($connection, $procedure_name, $arr){
		
		if ($connection === FALSE){
			echo 'Connection refused<br />';
			return FALSE;
		}
		
		$init = "select $procedure_name(";
		$query = buildQuery($init, $arr);
		echo "query: $query<br />";
		return mysqli_query($connection, $query);
		
	}

	function executeStoredProcedure($connection, $procedure_name, $arr){

		if ($connection === FALSE){
			echo 'Connection refused<br />';
			return FALSE;
		}

		$init = "call $procedure_name('";
		$query = buildQuery($init, $arr);
		$result = mysqli_query($connection, $query);

		$array = array();
		while ($row = mysqli_fetch_array($result)){
			array_push($array, $row);
		}
		mysqli_free_result($result);

		return $array;

	}

	function buildQuery($init, $arr){

		$query = $init;

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
		return $query;
	}
	

?>
