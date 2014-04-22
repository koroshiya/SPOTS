/**
	name varchar(20) not null
*/

/*delete_role_force*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_role_force //
CREATE FUNCTION delete_role_force(name varchar(20)) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM UserRole WHERE UserRole.name = name;
DELETE FROM Task WHERE Task.userRole = name;
DELETE FROM Role WHERE Role.name = name;
RETURN true;
END // 
DELIMITER ;