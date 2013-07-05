/**
*File: SPMS_02_stored_procedures.sql
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 05/July/2012
*Version: 1.03
*Changelog: 
			1.01: Added delete_user, is_founder, is_webmaster, get_user_task_count
			1.02: Fixed and tested get_user_task_count and get_project_count. Others not working or untested.
			1.03: Altered get_user_task_count and get_project_count. Fixed others.
*/

--UserIO

--insert_user(userName, userPassword, userRole[, email, title])

DELIMITER // 
DROP FUNCTION IF EXISTS insert_user //
CREATE FUNCTION insert_user(userName varchar(30), userPassword varchar(20), userRole character, email varchar(50), title character) RETURNS boolean
BEGIN 
DECLARE totalUsers smallint unsigned;
DECLARE sha1Password binary(20);
SELECT COUNT(*) INTO totalUsers FROM ScanUser;
IF totalUsers = 65535 THEN
	RETURN false;
ELSE
	SET sha1Password = UNHEX(SHA1(CONCAT(userName, userPassword, 'myEpicSalt', email)));
	INSERT INTO ScanUser VALUES(userName, sha1Password, userRole, COALESCE(email, NULL), COALESCE(title, NULL));
	RETURN true;
END IF;
END // 
DELIMITER ;

--delete_user(userID)

DELIMITER // 
DROP FUNCTION IF EXISTS delete_user //
CREATE FUNCTION delete_user(userID smallint unsigned) RETURNS boolean
BEGIN 
IF is_founder(userID) OR is_webmaster(userID) OR get_user_task_count(userID) > 0 THEN
	RETURN false;
ELSE 
	DELETE FROM ScanUser WHERE ScanUser.userID = userID;
	RETURN true;
END IF;
END // 
DELIMITER ;



--Authentication

DELIMITER // 
DROP FUNCTION IF EXISTS is_founder //
CREATE FUNCTION is_founder(userID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE suUserID smallint unsigned;
DECLARE boolResult boolean;
SELECT founderID INTO suUserID FROM Config;
SELECT suUserID = userID INTO boolResult;
RETURN boolResult;
END // 
DELIMITER ;

DELIMITER // 
DROP FUNCTION IF EXISTS is_webmaster //
CREATE FUNCTION is_webmaster(userID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE suUserID smallint unsigned;
DECLARE boolResult boolean;
SELECT webmasterID INTO suUserID FROM Config;
SELECT suUserID = userID INTO boolResult;
RETURN boolResult;
END // 
DELIMITER ;



--Getters

DELIMITER // 
DROP FUNCTION IF EXISTS get_project_count //
CREATE FUNCTION get_project_count() RETURNS smallint unsigned
BEGIN
DECLARE total smallint unsigned;
SELECT COUNT(*) INTO total FROM Series;
RETURN total;
END // 
DELIMITER ;

DELIMITER // 
DROP FUNCTION IF EXISTS get_user_task_count //
CREATE FUNCTION get_user_task_count(userID smallint unsigned) RETURNS smallint unsigned
BEGIN
DECLARE total smallint unsigned;
SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID;
RETURN total;
END // 
DELIMITER ;

