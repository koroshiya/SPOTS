<?php

/** 
  * @param host Host on which the database resides. Can be 'localhost'.
  * @param dbUser MySQL username of the user through whom a database connection will be established.
  * @param dbPass Password of the user through whom a database connection will be established.
  * @param dbName Name of the database for which to create a connection.
  *
  * @param homeGroup ID of the group running this software. The group with this ID cannot be deleted.
  */
if (!fromIndex){die();}
DEFINE('host', 'localhost');
DEFINE('dbUser', 'root');
DEFINE('dbPass', 'toor');
DEFINE('dbName', 'SPOTS');

DEFINE('homeGroup', 0);

?>