<?php

	include_once('Connection.php');

	/**
	 * Creates a new user role.
	 *
	 * @param $name Name of the role to add.
	 *
	 * @return False if command failed, otherwise true.
	 */
	function addRole($name){
		
		$procedure_name = 'insert_role';
		$result = executeFunction($procedure_name, $name);
		return $result[0];
		
	}

	function getRolesAll(){

		$procedure_name = 'get_roles';
		return executeStoredProcedure($procedure_name, null);
	}

?>