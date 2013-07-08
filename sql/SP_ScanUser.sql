--ScanUserIO

/*
	userID smallint unsigned not null AUTO_INCREMENT,
	userName varchar(30) not null,
	userPassword binary(20) not null,
	userRole character not null,
	email varchar(50) null,
	title character null,
	PRIMARY KEY (userID)
*/

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
END IF;
SET sha1Password = UNHEX(SHA1(CONCAT(userName, userPassword, 'myEpicSalt', email)));
INSERT INTO ScanUser VALUES(userName, sha1Password, userRole, COALESCE(email, NULL), COALESCE(title, NULL));
RETURN true;
END // 
DELIMITER ;

--delete_user(userID)
--If a user is the founder, webmaster, has tasks still assigned to them, or is the project manager of at least one series, fails and returns false.

DELIMITER // 
DROP FUNCTION IF EXISTS delete_user //
CREATE FUNCTION delete_user(userID smallint unsigned) RETURNS boolean
BEGIN 
IF is_founder(userID) OR is_webmaster(userID) OR get_user_task_count(userID) > 0 OR is_project_manager(userID) THEN
RETURN false;
END IF;
DELETE FROM ScanUser WHERE ScanUser.userID = userID;
RETURN true;
END // 
DELIMITER ;

--delete_user_force(userID)
--If a user is the founder or webmaster, fails and returns false.
--All associated Tasks are deallocated. Same with Series for which the user is the project manager.

DELIMITER // 
DROP FUNCTION IF EXISTS delete_user_force //
CREATE FUNCTION delete_user_force(userID smallint unsigned) RETURNS boolean
BEGIN 
IF is_founder(userID) OR is_webmaster(userID) THEN
RETURN false;
END IF;
UPDATE Task AS t SET t.userID = NULL WHERE t.userID = userID;
UPDATE Series AS s SET s.projectManagerID = NULL WHERE s.projectManagerID = userID;
DELETE FROM ScanUser WHERE ScanUser.userID = userID;
RETURN true;
END // 
DELIMITER ;

--modify_user(userID, userPassword, email)

DELIMITER // 
DROP FUNCTION IF EXISTS modify_user //
CREATE FUNCTION modify_user(userID smallint unsigned, newPassword varchar(20), newEmail varchar(50)) RETURNS boolean
BEGIN 
DECLARE sha1Password binary(20);
DECLARE userName varchar(30);
DECLARE userExists boolean;
SET userExists = EXISTS(SELECT 1 FROM ScanUser WHERE ScanUser.userID = userID);
IF NOT userExists THEN
RETURN false;
END IF;
SELECT ScanUser.userName INTO userName FROM ScanUser WHERE ScanUser.userID = userID;
SET sha1Password = UNHEX(SHA1(CONCAT(userName, newPassword, 'myEpicSalt', newEmail)));
Update ScanUser SET ScanUser.userPassword = newPassword, ScanUser.email = newEmail;
RETURN true;
END // 
DELIMITER ;

--user_set_role

DELIMITER // 
DROP FUNCTION IF EXISTS user_set_role //
CREATE FUNCTION user_set_role(userID smallint unsigned, newRole character) RETURNS boolean
BEGIN 
IF NOT(newRole = 's' OR newRole = 'a') THEN --s = staff, a = admin
RETURN false;
END IF;
UPDATE ScanUser SET ScanUser.userRole = newRole;
RETURN true;
END // 
DELIMITER ;

--user_set_title

DELIMITER // 
DROP FUNCTION IF EXISTS user_set_title //
CREATE FUNCTION user_set_title() RETURNS boolean
BEGIN --TODO: Decide on user titles
END // 
DELIMITER ;













--is_project_manager

DELIMITER // 
DROP FUNCTION IF EXISTS is_project_manager //
CREATE FUNCTION is_project_manager(userID smallint unsigned) RETURNS boolean
BEGIN
	DECLARE total smallint unsigned;
	SELECT COUNT(*) INTO total FROM Series AS s WHERE s.projectManagerID = userID;
	RETURN total != 0;
END // 
DELIMITER ;