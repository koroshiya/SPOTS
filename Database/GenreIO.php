<?php

	require_once('Connection.php');

	/**
	 * Creates a new series genre.
	 *
	 * @param $name Name of the genre to add.
	 */
	function addGenre($name){
		$names = array('name');
		$params = array($name);
		return insertIntoTable('Genre', $names, $params);
	}

	/**
	 * Removes an existing genre from the DB.
	 * Fails if any SeriesGenre objects rely on this genre.
	 *
	 * @param $name Name of the genre to remove.
	 */
	function removeGenre($name){
		return deleteFromTableSingle('Genre', 'name', $name);
	}

	/**
	 * Removes an existing genre from the DB.
	 *
	 * @param $name Name of the genre to add.
	 */
	function removeGenreForce($name){
		connectToMeekro();
		$result = DB::query("SELECT delete_genre_force(%s);", $name);
		return $result;
	}

	/**
	 * Gets all available genres from the DB.
	 */
	function getGenresAll(){
		connectToMeekro();
		$result = DB::query("SELECT * FROM Genre;");
		return $result;
	}

?>