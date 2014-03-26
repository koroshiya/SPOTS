<?php
	
	/**
	 * Attempts to connect to MySQL on the target machine with the credentials supplied.
	 *
	 * @return False if the connection failed, otherwise returns the established connection.
	 * */
	function connect(){
    	require_once(databaseDir.'Settings.php');
		global $connection;
		$connection = @mysqli_connect('p:'.host, dbUser, dbPass, dbName);
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
	 * @param $procedure Statement to run, params and all included.
	 *
	 * @return False if the command failed, otherwise returns the output of the command.
	 */
	function executeStoredProcedure($procedure){
		
		global $connection;
		if ($connection === null || !mysqli_ping($connection)){
			connect();
		}
		$result = mysqli_query($connection, $procedure);

		if ($result === FALSE) {
			echo "SP Failed: $procedure<br />"; //TODO: remove when moving to production
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
	 *
	 * @return False if the command failed, otherwise returns the output of the command.
	 */
	function buildAndRunQuery($init, $arr){

		global $connection;
		if ($connection === null || !mysqli_ping($connection)){
			connect();
		}
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
		if ($connection === null || !mysqli_ping($connection)){
			connect();
		}
		if (gettype($param) === "string"){
			$escaped = mysqli_real_escape_string($connection, $param);
			//$escaped = addcslashes($escaped, '%_'); //currently unnecessary; LIKE is only used for searching series
			return "'" . $escaped . "'";
		}else{
			return $param; //Only strings can contain misc characters AFAIK, so integers and such don't need escaping
		}
	}

?>