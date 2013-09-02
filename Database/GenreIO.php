<?php

	include_once('Connection.php');

	/**
	 * Creates a new series genre.
	 *
	 * @param $name Name of the genre to add.
	 *
	 * @return False if command failed, otherwise true.
	 */
	function addGenre($name){
		
		$procedure_name = 'insert_genre';
		$result = executeFunction($procedure_name, $name);
		return $result[0];
		
	}

?>