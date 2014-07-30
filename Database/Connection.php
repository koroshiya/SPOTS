<?php

    require_once(databaseDir.'Settings.php');

	function connectToMeekro(){
    	require_once(databaseDir.'meekrodb.2.3.class.php');

    	if (DB::$user === ''){
			DB::$user = dbUser;
			DB::$password = dbPass;
			DB::$dbName = dbName;
			DB::$host = host;
			DB::$error_handler = 'DBError';
    	}
	}

	function insertIntoTable($table, $names, $params){
		connectToMeekro();
		if (count($names) != count($params) || !is_array($names) || !is_array($params)){
			die("Name/Param arrays don't match");
		}

		$args = array();
		for ($count=0; $count < count($names); $count++) { 
			$args[$names[$count]] = $params[$count];
		}

		$return = DB::insert($table, $args);
		return $return;
	}

	function deleteFromTableSingle($table, $name, $param){
		connectToMeekro();
		$result = DB::delete($table, $name."=%s", $param);
		return $result;
	}

	function DBError($params){
		die("-1Database operation failed");
	}

?>