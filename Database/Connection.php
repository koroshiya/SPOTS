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
 *			1.05: Fix to BuildAndRun function. Comment refactoring/completion.
 *			1.06: Failed functions now return false in an array so calling classes process the result properly.
 *			1.07: Restructured $connection calls and centralized them to this file.
 *Purpose: Establishes database connections and provides methods for interacting with the database. 
*/ 
	
	/**
	 * Attempts to connect to MySQL on the target machine with the credentials supplied.
	 * 
	 * @param $mysql_host Host on which the database resides. Can be 'localhost'.
	 * @param $mysql_user MySQL username of the user through whom a database connection will be established.
	 * @param $mysql_password Password of the user through whom a database connection will be established.
	 * @param $mysql_database Name of the database for which to create a connection.
	 *
	 * @return False if the connection failed, otherwise returns the established connection.
	 * */
	function connect($mysql_host, $mysql_user, $mysql_password, $mysql_database){
		
		global $connection;
		$connection = @mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
		
	}

	/**
	 * Severs an existing MySQL database connection.
	 */
	function disconnect(){
		global $connection;
		mysqli_close($connection);
	}
	
	/**
	 * Executes a function, passing in a list of arguments (or single argument).
	 *  
	 * @param $procedure_name Name of the function to run WITHOUT the brackets. 
	 * 					eg. function, not function() or function(integer)
	 * @param $arr Array of arguments, or single argument, to pass into the function.
	 *
	 * @return False if the connection failed, otherwise the output of the function is returned.
	 * */
	function executeFunction($procedure_name, $arr){
		
		$init = "select $procedure_name(";
		$result = buildAndRunQuery($init, $arr);

		if ($result === FALSE) {
			echo "Func Failed<br />";
			return array(false);
		}

		$row = mysqli_fetch_array($result);
		mysqli_free_result($result);
		return $row;
		
	}

	/**
	 * Executes a stored procedure, passing in a list of arguments (or single argument).
	 *
	 * @param $procedure_name Name of the stored procedure to run WITHOUT the brackets. 
	 * 					eg. function, not function() or function(integer)
	 * @param $arr Array of arguments to pass into the function.
	 *			Can also be a single argument or null, depending on the procedure to run.
	 * @param $connection Connection through which to execute the command.
	 *
	 * @return False if the command failed, otherwise returns the output of the command.
	 */
	function executeStoredProcedure($procedure_name, $arr){

		$init = "call $procedure_name(";
		$result = buildAndRunQuery($init, $arr);

		if ($result === FALSE) {
			echo "SP Failed<br />";
			return array(false);
		}

		$array = array();
		while ($row = mysqli_fetch_array($result)){
			array_push($array, $row);
		}
		mysqli_free_result($result);

		return $array;

	}

	/**
	 * Builds a query based on the $init argument passed in, then runs the query 
	 * through $connection and passes in $arr arguments.
	 *
	 * @param $init Initialization text with which to preface the query.
	 *			eg. "call $procedure_name(" for a stored procedure.
	 * @param $arr Array of arguments to pass into the function.
	 *			Can also be a single argument or null, depending on the procedure to run.
	 * @param $connection Connection through which to execute the command.
	 *
	 * @return False if the command failed, otherwise returns the output of the command.
	 */
	function buildAndRunQuery($init, $arr){

		global $connection;
		if ($connection === FALSE || $connection === NULL){
			echo 'Connection refused<br />';
			return FALSE;
		}

		if (is_array($arr)){
			$arrSize = count($arr);
			if ($arrSize > 0){
				foreach ($arr as $value) {
					if ($value != null){
						$init .= getEscapedSQLParam($value) . ', ';
					}
				}
				$init = substr($init, 0, -2);
			}
		}else if ($arr != null){
			$init .= getEscapedSQLParam($arr);
		}

		$init .= ");";
		//echo $init;
		$result = mysqli_query($connection, $init);
		return $result;
	}

	function getEscapedSQLParam($param){
		global $connection;
		if (gettype($param) === "string"){
			$escaped = mysqli_real_escape_string($connection, $param);
			return "'" . $escaped . "'";
		}else{
			return $param;
		}
	}

?>