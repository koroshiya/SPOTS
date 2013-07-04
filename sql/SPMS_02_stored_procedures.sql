/**
*File: SPMS_02_stored_procedures.sql
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 04/July/2012
*Changelog: 
*/

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

DELIMITER // 
CREATE PROCEDURE IF NOT EXISTS get_project_count() AS smallint unsigned
BEGIN
RETURN COUNT(*) FROM Series;
END // 
DELIMITER ;
