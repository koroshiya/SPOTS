<?php

	require_once('Connection.php');

	/**
	 * Creates a new user role.
	 *
	 * @param $name Name of the role to add.
	 */
	function addRole($name){
		$names = array('name');
		$params = array($name);
		return insertIntoTable('Role', $names, $params);
	}

	/**
	 * Removes an existing Role from the DB.
	 * Fails if any Task or UserRole objects rely on this Role.
	 *
	 * @param $name Name of the Role to remove.
	 */
	function removeRole($name){
		return deleteFromTableSingle('Role', 'name', $name);
	}

	/**
	 * Removes an existing Role from the DB.
	 *
	 * @param $name Name of the Role to add.
	 */
	function removeRoleForce($name){

		connectToMeekro();
		$result = DB::query("SELECT delete_role_force(%s);", $name);
		return $result[0];
		
	}

	/**
	 * Gets all available roles from the DB.
	 */
	function getRolesAll(){

		connectToMeekro();
		$result = DB::query("SELECT * FROM Role;");
		return $result;

	}

?>