<?php

	include 'Connection.php';

	function addRole($name){
		
		global $connection;
		$procedure_name = 'insert_role';
		$result = executeFunction($procedure_name, $name, $connection);

		return $result;
	}

?>