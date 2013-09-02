--user_add_role

DELIMITER // 
DROP FUNCTION IF EXISTS user_add_role //
CREATE FUNCTION user_add_role(userID smallint unsigned, name varchar(20)) RETURNS boolean
BEGIN 
INSERT INTO UserRole VALUES(userID, name);
RETURN true;
END // 
DELIMITER ;

--user_remove_role
--Doesn't currently allow for deleting if any affected Tasks still exist
--This method will remain completely viable ONLY if complete Tasks are "imprinted" into another static table and deleted upon chapter release

DELIMITER // 
DROP FUNCTION IF EXISTS user_remove_role //
CREATE FUNCTION user_remove_role(userID smallint unsigned, name varchar(20)) RETURNS boolean
BEGIN 
DECLARE total smallint unsigned;
SELECT Count(*) INTO total FROM Task AS t WHERE t.userID = userID AND t.userRole = name;
IF total > 0 THEN
RETURN false;
END IF;
DELETE FROM UserRole WHERE UserRole.userID = userID AND UserRole.name = name;
RETURN true;
END // 
DELIMITER ;

--user_remove_role_all

DELIMITER // 
DROP FUNCTION IF EXISTS user_remove_role_all //
CREATE FUNCTION user_remove_role(userID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE total smallint unsigned;
SELECT Count(*) INTO total FROM Task AS t WHERE t.userID = userID;
IF total > 0 THEN
RETURN false;
END IF;
DELETE FROM UserRole WHERE UserRole.userID = userID;
RETURN true;
END // 
DELIMITER ;

--user_get_roles

DELIMITER // 
DROP PROCEDURE IF EXISTS user_get_roles //
CREATE PROCEDURE user_get_roles(IN userID smallint unsigned)
BEGIN 
SELECT ur.name FROM UserRole AS ur WHERE ur.userID = userID;
END // 
DELIMITER ;

--user_get_by_role

DELIMITER // 
DROP PROCEDURE IF EXISTS user_get_by_role //
CREATE PROCEDURE user_get_by_role(IN name varchar(20))
BEGIN 
SELECT * FROM ScanUser AS su 
INNER JOIN UserRole AS ur ON su.userID = ur.userID
WHERE ur.name = name;
END // 
DELIMITER ;