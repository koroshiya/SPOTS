/*
 File: SP_Authentication.sql
 Author: Koro
 Date created: 08/July/2012
 Date last modified: 08/July/2012
 Version: 1.0
 Changelog: 
*/

--Authentication

--is_founder

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

--is_webmaster

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