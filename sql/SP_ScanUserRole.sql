/*
	UserRoleIO

	userID smallint unsigned not null,
	name varchar(20) not null,
	PRIMARY KEY (userID, name),
	FOREIGN KEY (userID) REFERENCES ScanUser(userID),
	FOREIGN KEY (name) REFERENCES Role(name)

*/

/*user_add_role*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_add_role //
CREATE FUNCTION user_add_role(userID smallint unsigned, name varchar(20)) RETURNS boolean NOT DETERMINISTIC
BEGIN 
INSERT INTO UserRole VALUES(userID, name);
RETURN true;
END // 
DELIMITER ;

/*user_remove_role
Doesn't currently allow for deleting if any affected Tasks still exist
This method will remain completely viable ONLY if complete Tasks are "imprinted" 
into another static table and deleted upon chapter release*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_remove_role //
CREATE FUNCTION user_remove_role(userID smallint unsigned, name varchar(20)) RETURNS boolean NOT DETERMINISTIC
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

/*user_remove_role_all*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_remove_role_all //
CREATE FUNCTION user_remove_role_all(userID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
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