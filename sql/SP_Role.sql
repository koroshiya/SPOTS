/**
	name varchar(20) not null
*/

/*insert_role*/

DELIMITER // 
DROP FUNCTION IF EXISTS insert_role //
CREATE FUNCTION insert_role(name varchar(20)) RETURNS boolean
BEGIN 
INSERT INTO Role VALUES(name);
RETURN true;
END // 
DELIMITER ;

/*delete_role*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_role //
CREATE FUNCTION delete_role(name varchar(20)) RETURNS boolean
BEGIN 
DELETE FROM Role WHERE Role.name = name;
RETURN true;
END // 
DELIMITER ;

/*delete_role_force*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_role_force //
CREATE FUNCTION delete_role_force(name varchar(20)) RETURNS boolean
BEGIN 
DELETE FROM UserRole WHERE UserRole.name = name;
DELETE FROM Task WHERE Task.userRole = name;
DELETE FROM Role WHERE Role.name = name;
RETURN true;
END // 
DELIMITER ;

/*get_roles*/

DELIMITER // 
DROP PROCEDURE IF EXISTS get_roles //
CREATE PROCEDURE get_roles()
BEGIN 
SELECT ur.name FROM Role AS ur;
END // 
DELIMITER ;