/**
	name varchar(20) not null
*/

--insert_role

DELIMITER // 
DROP FUNCTION IF EXISTS insert_role //
CREATE FUNCTION insert_role(name varchar(20)) RETURNS boolean
BEGIN 
INSERT INTO Role VALUES(name);
RETURN true;
END // 
DELIMITER ;