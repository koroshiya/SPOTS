<?php

	include 'Connection.php';

	function addGenre($name){
		
		global $connection;
		$procedure_name = 'insert_genre';
		$result = executeFunction($procedure_name, $name, $connection);

		return $result;
	}

?>