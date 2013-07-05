<?php

/**
* Executes a stored procedure that accepts a single OUT argument.
*
* @param $procedure_name Name of the stored procedure to run WITHOUT the brackets. eg. function, not function() or function(integer)
* */
function executeSingleResultProcedure($dbconnect, $procedure_name){
	
	$total = 0;
	$result = mysqli_query($dbconnect, "call $procedure_name(@total)");
	$result = mysqli_query('SELECT @total');
	return $result;

}

/**
* Example method for the use of this class.
* If the database has been set up properly, returns the number of Series currently in the DB.
*
* @return Number of projects ("Series" in the DB).
* */
function getProjectCount($dbconnect){
	
	return executeSingleResultProcedure($dbconnect, 'get_project_count');
	
}

?>
