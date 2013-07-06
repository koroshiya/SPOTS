<?php
/**
*File: Connection.php
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 06/July/2012
*Version: 1.03
*Changelog: 
*			1.01: Changed MySQL methods to MySQLi, implemented isWebMaster, isFounder, getUserTaskCount, etc.
*					Added support for multi-argument functions
*			1.02: Added getSeriesByLetter, methods for stored procedures/functions
*			1.03: Moved non-connection functions into separate files
*Purpose: Establishes database connections and provides methods for interacting with the database. 
**/ 

	//When implemented, remove these four fields
	$mysql_host = 'localhost';
	$mysql_user = '';
	$mysql_password = '';
	$mysql_database = 'SPMS';	
	
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