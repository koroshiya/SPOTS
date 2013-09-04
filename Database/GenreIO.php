<?php

	require_once('Connection.php');

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

	/**
	 * Removes an existing genre from the DB.
	 * Fails if any SeriesGenre objects rely on this genre.
	 *
	 * @param $name Name of the genre to remove.
	 *
	 * @return False if command failed, otherwise true.
	 */
	function removeGenre($name){
		
		$procedure_name = 'delete_genre';
		$result = executeFunction($procedure_name, $name);
		return $result[0];
		
	}

	/**
	 * Removes an existing genre from the DB.
	 *
	 * @param $name Name of the genre to add.
	 *
	 * @return False if command failed, otherwise true.
	 */
	function removeGenreForce($name){
		
		$procedure_name = 'delete_genre_force';
		$result = executeFunction($procedure_name, $name);
		return $result[0];
		
	}

?>