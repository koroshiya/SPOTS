<?php

	require_once('Connection.php');

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

	/**
	 * Removes an existing Role from the DB.
	 * Fails if any Task or UserRole objects rely on this Role.
	 *
	 * @param $name Name of the Role to remove.
	 *
	 * @return False if command failed, otherwise true.
	 */
	function removeRole($name){
		
		$procedure_name = 'delete_role';
		$result = executeFunction($procedure_name, $name);
		return $result[0];
		
	}

	/**
	 * Removes an existing Role from the DB.
	 *
	 * @param $name Name of the Role to add.
	 *
	 * @return False if command failed, otherwise true.
	 */
	function removeRoleForce($name){
		
		$procedure_name = 'delete_role_force';
		$result = executeFunction($procedure_name, $name);
		return $result[0];
		
	}

	/**
	 * Gets all available roles from the DB.
	 *
	 * @return All roles in the DB in the format array(role1, role2, role3, ...),
	 *			where each role is an array of params.
	 *
	 */
	function getRolesAll(){

		$procedure_name = "SELECT r.name FROM Role AS r;";
		return executeStoredProcedure($procedure_name);
	}

?>