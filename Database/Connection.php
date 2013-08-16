<?php
/**
*File: Connection.php
*Author: Koro
*Date created: 04/July/2012
*Changelog: 
*			1.01: Changed MySQL methods to MySQLi, implemented isWebMaster, isFounder, getUserTaskCount, etc.
*					Added support for multi-argument functions
*			1.02: Added getSeriesByLetter, methods for stored procedures/functions
*			1.03: Moved non-connection functions into separate files
*			1.04: Removed global connection details, replaced with $connection variable.
*					Single connection now remains across function calls.
*Purpose: Establishes database connections and provides methods for interacting with the database. 
**/ 

	//global $connection;
	//global $connection;
	//$connection = connect('localhost', 'root', 'toor', 'SPMS');

	/**
	 * Common parameters.
	 * 
	 * @param $procedure_name Name of the stored procedure to run WITHOUT the brackets. eg. function, not function() or function(integer)
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established
	 * @param $mysql_password Password of the user through whom a database connection will be established
	 * @param $mysql_database Password of the database for which to create a connection
	 */
	
	/*
	 * $mysql_host = 'localhost';
	 * $mysql_user = '';
	 * $mysql_password = '';
	 * $mysql_database = 'SPOTS';
	 *
	 */
	/**
	 * Attempts to connect to MySQL on the target machine with the credentials supplied
	 * 
	 * @return False if the connection failed, otherwise returns the established connection
	 * */
	function connect($mysql_host, $mysql_user, $mysql_password, $mysql_database){
		
		return @mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
		
	}

	function disconnect(){
		mysqli_close($connection);
	}
	
	/**
	 * Executes a stored procedure, passing in a list of arguments (or single argument).
	 *  
	 * @param $arr Array of arguments, or single argument, to pass into the stored procedure
	 * @return False if the connection failed, otherwise the resultset of the procedure is returned.
	 * */
	function executeFunction($procedure_name, $arr, $connection){
		
		$init = "select $procedure_name(";
		$result = buildAndRunQuery($init, $arr, $connection);

		if ($result === FALSE) {
			//mysqli_close($connection);
			echo "Func Failed<br />";
			return false;
		}

		$row = mysqli_fetch_array($result);
		mysqli_free_result($result);
		//mysqli_close($connection);
		return $row;
		
	}

	function executeStoredProcedure($procedure_name, $arr, $connection){

		$init = "call $procedure_name(";
		$result = buildAndRunQuery($init, $arr, $connection);

		if ($result === FALSE) {
			//mysqli_close($connection);
			echo "SP Failed<br />";
			return false;
		}

		$array = array();
		while ($row = mysqli_fetch_array($result)){
			array_push($array, $row);
		}
		mysqli_free_result($result);

		return $array;

	}

	function buildAndRunQuery($init, $arr, $connection){

		if ($connection === FALSE){
			echo 'Connection refused<br />';
			return FALSE;
		}

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
		//echo "$query";
		$result = mysqli_query($connection, $query);
		return $result;
	}

	function validID($seriesID){
		
		return (is_int($seriesID) && $seriesID >= 0 && $seriesID <= 65535);

	}
	
	function validChar($character){

		return (strlen($character) === 1 && ctype_alpha($character));

	}


?>