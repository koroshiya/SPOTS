<?php

	include 'Connection.php';

	/**
	 * Creates a new user role.
	 *
	 * @param $name Name of the role to add.
	 *
	 * @return False if command failed, otherwise true.
	 */
	function addRole($name){
		
		global $connection;
		$procedure_name = 'insert_role';
		return executeFunction($procedure_name, $name, $connection);
		
	}

?>