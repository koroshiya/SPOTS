/**
*File: SPMS_02_stored_procedures.sql
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 04/July/2012
*Version: 1.01
*Changelog: 
			1.01: Added delete_user, is_founder, is_webmaster, get_user_task_count
*/

--UserIO

--insert_user(userName, userPassword, userRole[, email, title])

DELIMITER // 
CREATE PROCEDURE IF NOT EXISTS insert_user(IN userName varchar(30), IN userPassword varchar(20), IN userRole character, IN email varchar(50), IN title character) RETURNS boolean
BEGIN 
IF SELECT(*) FROM ScanUser = 65535
	RETURN false;
END IF;

DECLARE sha1Password binary(20);
sha1Password = UNHEX( SHA1 (CONCAT (userName, userpassword, 'myEpicSalt', email), 256));

INSERT INTO ScanUser Values(userName, sha1Password, userRole, COALESCE(email, NULL), COALESCE(title, NULL));
RETURN true;
END // 
DELIMITER ;

--delete_user(userID)

DELIMITER // 
CREATE PROCEDURE IF NOT EXISTS delete_user(IN userID smallint unsigned) RETURNS boolean
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
CREATE PROCEDURE IF NOT EXISTS is_founder(IN userID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE suUserID smallint unsigned;
SELECT founderID INTO suUserID FROM Config;
RETURN SELECT suUserID = userID;
END // 
DELIMITER ;

DELIMITER // 
CREATE PROCEDURE IF NOT EXISTS is_webmaster(IN userID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE suUserID smallint unsigned;
SELECT webmasterID INTO suUserID FROM Config;
RETURN SELECT suUserID = userID;
END // 
DELIMITER ;



--Getters

DELIMITER // 
CREATE PROCEDURE IF NOT EXISTS get_project_count() AS smallint unsigned
BEGIN
RETURN COUNT(*) FROM Series;
END // 
DELIMITER ;

DELIMITER // 
CREATE PROCEDURE IF NOT EXISTS get_user_task_count(IN userID smallint unsigned) AS smallint unsigned
BEGIN
RETURN COUNT(*) FROM Task AS t WHERE t.userID = userID;
END // 
DELIMITER ;

