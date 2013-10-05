/*ScanUserIO
	userID smallint unsigned not null AUTO_INCREMENT,
	userName varchar(30) not null,
	userPassword char(40) not null,
	email varchar(100) not null,
	title character not null,
	PRIMARY KEY (userID)
*/

/*insert_user(userName, userPassword, userRole[, email, title])*/

DELIMITER // 
DROP FUNCTION IF EXISTS insert_user //
CREATE FUNCTION insert_user(userName varchar(30), userPassword varchar(20), email varchar(100), title character) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DECLARE totalUsers smallint unsigned;
DECLARE sha1Password binary(20);
SELECT COUNT(*) INTO totalUsers FROM ScanUser;
IF totalUsers = 65535 THEN
RETURN false;
END IF;
SET sha1Password = UNHEX(SHA1(CONCAT(userName, userPassword, 'myEpicSalt', email)));
INSERT INTO ScanUser(userName, userPassword, email, title) VALUES(userName, sha1Password, email, title);
RETURN true;
END // 
DELIMITER ;

/*delete_user(userID)
If a user is the founder, webmaster, has tasks still assigned to them, 
or is the project manager of at least one series, this function fails and returns false.*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_user //
CREATE FUNCTION delete_user(userID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
IF is_founder(userID) OR is_webmaster(userID) OR get_user_task_count(userID) > 0 OR is_project_manager(userID) THEN
RETURN false;
END IF;
DELETE FROM ScanUser WHERE ScanUser.userID = userID;
RETURN true;
END // 
DELIMITER ;

/*delete_user_force(userID)
If a user is the founder or webmaster, fails and returns false.
All associated Tasks are deallocated. Same with Series for which the user is the project manager.*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_user_force //
CREATE FUNCTION delete_user_force(userID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
IF is_founder(userID) OR is_webmaster(userID) THEN
RETURN false;
END IF;
DELETE FROM Task WHERE Task.userID = userID;
DELETE FROM UserRole WHERE UserRole.userID = userID;
UPDATE Series AS s SET s.projectManagerID = NULL WHERE s.projectManagerID = userID;
DELETE FROM ScanUser WHERE ScanUser.userID = userID;
RETURN true;
END // 
DELIMITER ;

/*user_set_password*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_set_password //
CREATE FUNCTION user_set_password(userID smallint unsigned, newPassword varchar(20)) RETURNS boolean DETERMINISTIC
BEGIN 
DECLARE sha1Password char(40);
DECLARE userName varchar(30);
DECLARE userEmail varchar(100);
DECLARE userExists boolean;
DECLARE userPass char(40);
SET userExists = EXISTS(SELECT 1 FROM ScanUser WHERE ScanUser.userID = userID);
IF NOT userExists THEN
RETURN false;
END IF;
SELECT su.userName, su.email, su.userPass INTO userName, userEmail, userPass FROM ScanUser AS su WHERE su.userID = userID;
SET sha1Password = UNHEX(SHA1(CONCAT(userName, newPassword, 'myEpicSalt', userEmail)));
Update ScanUser SET ScanUser.userPassword = sha1Password;
RETURN true;
END // 
DELIMITER ;

/*user_get_password_valid*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_get_password_valid //
CREATE FUNCTION user_get_password_valid(userID smallint unsigned, password varchar(20)) RETURNS boolean DETERMINISTIC
BEGIN 
DECLARE sha1Password char(40);
DECLARE userName varchar(30);
DECLARE userEmail varchar(100);
DECLARE userExists boolean;
DECLARE userPass char(40);
SET userExists = EXISTS(SELECT 1 FROM ScanUser WHERE ScanUser.userID = userID);
IF NOT userExists THEN
RETURN false;
END IF;
SELECT su.userName, su.email, su.userPassword INTO userName, userEmail, userPass FROM ScanUser AS su WHERE su.userID = userID;
SET sha1Password = (SHA1(CONCAT(userName, password, 'myEpicSalt', userEmail)));
RETURN STRCMP(userPass, sha1Password) = 0;
END // 
DELIMITER ;

/*user_get_password_valid*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_get_password_valid_by_name //
CREATE FUNCTION user_get_password_valid_by_name(userName varchar(30), password varchar(20)) RETURNS boolean DETERMINISTIC
BEGIN 
DECLARE sha1Password char(40);
DECLARE userEmail varchar(100);
DECLARE userExists boolean;
DECLARE userPass char(40);
SET userExists = EXISTS(SELECT 1 FROM ScanUser WHERE ScanUser.userName = userName);
IF NOT userExists THEN
RETURN false;
END IF;
SELECT su.email, su.userPassword INTO userEmail, userPass FROM ScanUser AS su WHERE su.userName = userName;
SET sha1Password = (SHA1(CONCAT(userName, password, 'myEpicSalt', userEmail)));
RETURN STRCMP(userPass, sha1Password) = 0;
END // 
DELIMITER ;

/*user_set_email*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_set_email //
CREATE FUNCTION user_set_email(userID smallint unsigned, newEmail varchar(100)) RETURNS boolean DETERMINISTIC
BEGIN 
DECLARE sha1Password char(40);
DECLARE userName varchar(30);
DECLARE userExists boolean;
DECLARE userPass char(40);
SET userExists = EXISTS(SELECT 1 FROM ScanUser WHERE ScanUser.userID = userID);
IF NOT userExists THEN
RETURN false;
END IF;
SELECT su.userName, su.userPass INTO userName, userPass FROM ScanUser AS su WHERE su.userID = userID;
SET sha1Password = UNHEX(SHA1(CONCAT(userName, newPassword, 'myEpicSalt', newEmail)));
Update ScanUser SET ScanUser.userPassword = sha1Password, ScanUser.email = newEmail;
RETURN true;
END // 
DELIMITER ;

/*user_get_email*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_get_email //
CREATE FUNCTION user_get_email(userID smallint unsigned) RETURNS varchar(100) DETERMINISTIC
BEGIN 
DECLARE email varchar(100);
SELECT s.email INTO email FROM ScanUser AS s WHERE s.userID = userID;
RETURN email;
END // 
DELIMITER ;

/*user_set_permission*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_set_permission //
CREATE FUNCTION user_set_permission(userID smallint unsigned, newRole character) RETURNS boolean DETERMINISTIC
BEGIN 
IF NOT(newRole = 'S' OR newRole = 'A' OR newRole = 'M') THEN /*s = staff, a = admin, m = mod*/
RETURN false;
END IF;
UPDATE ScanUser AS su SET su.title = newRole;
RETURN true;
END // 
DELIMITER ;

/*user_get_permission*/

DELIMITER // 
DROP FUNCTION IF EXISTS user_get_permission //
CREATE FUNCTION user_get_permission(userID smallint unsigned) RETURNS character DETERMINISTIC
BEGIN
DECLARE title character;
SELECT u.title INTO title FROM ScanUser AS u WHERE u.userID = userID;
RETURN title;
END // 
DELIMITER ;

/*is_project_manager
Tests if the user is a project manager for ANY series, not one in particular.*/

DELIMITER // 
DROP FUNCTION IF EXISTS is_project_manager //
CREATE FUNCTION is_project_manager(userID smallint unsigned) RETURNS boolean DETERMINISTIC
BEGIN
	DECLARE total smallint unsigned;
	SELECT COUNT(*) INTO total FROM Series AS s WHERE s.projectManagerID = userID;
	RETURN total != 0;
END // 
DELIMITER ;

/*is_project_manager_of_series
Tests if the user is a project manager of a particular series*/

DELIMITER // 
DROP FUNCTION IF EXISTS is_project_manager_of_series //
CREATE FUNCTION is_project_manager_of_series(userID smallint unsigned, seriesID smallint unsigned) RETURNS boolean DETERMINISTIC
BEGIN
	DECLARE pmID smallint unsigned;
	SELECT s.projectManagerID INTO pmID FROM Series AS s WHERE s.seriesID = seriesID;
	RETURN pmID = userID;
END // 
DELIMITER ;