/**
*File: SPMS_02_stored_procedures.sql
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 04/July/2012
*Version: 1.01
*Changelog: 
			1.01: Added delete_user, is_founder, is_webmaster, get_user_task_count
			1.02: Fixed and tested get_user_task_count and get_project_count. Others not working or untested.
*/

--UserIO

--insert_user(userName, userPassword, userRole[, email, title])

DELIMITER // 
DROP PROCEDURE IF EXISTS insert_user //
CREATE PROCEDURE insert_user(IN userName varchar(30), IN userPassword varchar(20), IN userRole character, IN email varchar(50), IN title character, OUT boolResult boolean)
BEGIN 
DECLARE totalUsers smallint unsigned;
SELECT COUNT(*) INTO totalUsers FROM ScanUser;
IF totalUsers = 65535
	boolResult = FALSE;
ELSE
	boolResult = TRUE;
END IF;

DECLARE sha1Password binary(20);
sha1Password = UNHEX( SHA1 (CONCAT (userName, userpassword, 'myEpicSalt', email), 256));

INSERT INTO ScanUser Values(userName, sha1Password, userRole, COALESCE(email, NULL), COALESCE(title, NULL));
END // 
DELIMITER ;

--delete_user(userID)

DELIMITER // 
DROP PROCEDURE IF EXISTS delete_user //
CREATE PROCEDURE delete_user(IN userID smallint unsigned) RETURNS boolean
BEGIN 
IF is_founder(userID) OR is_webmaster(userID) OR get_user_task_count(userID) > 0
	RETURN false;
ELSE 
	DELETE FROM ScanUser AS su WHERE su.userID = userID;
	RETURN true;
END IF;
END // 
DELIMITER ;



--Authentication

DELIMITER // 
DROP PROCEDURE IF EXISTS is_founder //
CREATE PROCEDURE is_founder(IN userID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE suUserID smallint unsigned;
SELECT founderID INTO suUserID FROM Config;
RETURN SELECT suUserID = userID;
END // 
DELIMITER ;

DELIMITER // 
DROP PROCEDURE IF EXISTS is_webmaster //
CREATE PROCEDURE is_webmaster(IN userID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE suUserID smallint unsigned;
SELECT webmasterID INTO suUserID FROM Config;
RETURN SELECT suUserID = userID;
END // 
DELIMITER ;



--Getters

DELIMITER // 
DROP PROCEDURE IF EXISTS get_project_count //
CREATE PROCEDURE get_project_count(OUT total smallint)
BEGIN
SELECT COUNT(*) INTO total FROM Series;
END // 
DELIMITER ;

DELIMITER // 
DROP PROCEDURE IF EXISTS get_user_task_count //
CREATE PROCEDURE get_user_task_count(IN userID smallint unsigned, OUT total smallint)
BEGIN
SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID;
END // 
DELIMITER ;

