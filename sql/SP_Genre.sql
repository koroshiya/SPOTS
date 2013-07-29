/**
	name varchar(20) not null
*/

--insert_genre
--Insert check, or let DB throw an error?
DELIMITER // 
DROP FUNCTION IF EXISTS insert_genre //
CREATE FUNCTION insert_genre(name varchar(20)) RETURNS boolean
BEGIN 
INSERT INTO Genre VALUES(name);
RETURN true;
END // 
DELIMITER ;