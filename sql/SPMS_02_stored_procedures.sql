/**
*File: SPMS_02_stored_procedures.sql
*Author: Koro
*Date created: 04/July/2012
*Date last modified: 06/July/2012
*Version: 1.05
*Changelog: 
			1.01: Added delete_user, is_founder, is_webmaster, get_user_task_count
			1.02: Fixed and tested get_user_task_count and get_project_count. Others not working or untested.
			1.03: Altered get_user_task_count and get_project_count. Fixed others.
			1.04: Added tons of functions. Many are still empty shells for later. None of the new functions have been tested.
			1.05: More functions, first stored procedures
*/

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

--ScanGroupIO

/*
	groupID smallint unsigned not null AUTO_INCREMENT,
	groupName varchar(30) not null,
	URL varchar(50) null,
	PRIMARY KEY (groupID)
*/

--insert_scangroup

DELIMITER // 
DROP FUNCTION IF EXISTS insert_scangroup //
CREATE FUNCTION insert_scangroup(groupName varchar(30), URL varchar(50)) RETURNS boolean
BEGIN 
DECLARE totalGroups smallint unsigned;
SELECT COUNT(*) INTO totalGroups FROM ScanGroup;
IF totalGroups = 65535 THEN
RETURN false;
END IF;
INSERT INTO ScanGroup VALUES(groupName, URL);
RETURN true;
END // 
DELIMITER ;

--delete_scangroup

DELIMITER // 
DROP FUNCTION IF EXISTS delete_scangroup //
CREATE FUNCTION delete_scangroup(groupID smallint unsigned) RETURNS boolean
BEGIN 
DELETE FROM ScanGroup AS sg WHERE sg.groupID = groupID;
RETURN true;
END // 
DELIMITER ;

--modify_scangroup

DELIMITER // 
DROP FUNCTION IF EXISTS modify_scangroup //
CREATE FUNCTION modify_scangroup(groupID smallint unsigned, groupName varchar(30), groupURL varchar(50)) RETURNS boolean
BEGIN 
UPDATE ScanGroup AS sg SET sg.groupName = COALESCE(groupName, sg.groupName), sg.groupURL = COALESCE(groupURL, sg.URL) WHERE sg.groupID = groupID;
RETURN true;
END // 
DELIMITER ;

--SeriesIO

/*
	seriesID smallint unsigned not null AUTO_INCREMENT,
	seriesTitle varchar(50) not null,
	status character null,
	genrePrimary varchar(20) null,
	genreSecondary varchar(20) null,
	description varchar(255) null,
	thumbnailURL varchar(50) null,
	projectManagerID smallint unsigned null,
	visibleToPublic boolean not null,
	isAdult boolean not null,
	PRIMARY KEY (seriesID)
*/

--insert_series

DELIMITER // 
DROP FUNCTION IF EXISTS insert_series //
CREATE FUNCTION insert_series(seriesTitle varchar(50), status character, genrePrimary varchar(20), genreSecondary varchar(20), description varchar(255), thumbnailURL varchar(50), projectManagerID smallint unsigned, visibleToPublic boolean, isAdult boolean) RETURNS boolean
BEGIN 
DECLARE totalSeries smallint unsigned;
SELECT COUNT(*) INTO totalSeries FROM Series;
IF totalSeries = 65535 THEN
RETURN false;
END IF;
INSERT INTO Series VALUES(seriesTitle, character, genrePrimary, genreSecondary, description, thumbnailURL, projectManagerID, visibleToPublic, isAdult);
RETURN true;
END // 
DELIMITER ;

--delete_series
--If the series has any chapters associated with it, nothing is deleted and returns false.

DELIMITER // 
DROP FUNCTION IF EXISTS delete_series //
CREATE FUNCTION delete_series(seriesID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE totalChapters smallint unsigned;
SELECT COUNT(*) INTO totalChapters FROM Chapter AS c WHERE c.seriesID = seriesID;
IF totalChapters > 0 THEN
RETURN false;
END IF;
DELETE FROM Series As s WHERE s.seriesID = seriesID;
END // 
DELIMITER ;

--delete_series_force
--Deletes a series and all associated chapters & tasks.

DELIMITER // 
DROP FUNCTION IF EXISTS delete_series //
CREATE FUNCTION delete_series(seriesID smallint unsigned) RETURNS boolean
BEGIN 
DELETE FROM Task AS t WHERE t.seriesID = seriesID;
DELETE FROM Chapter AS c WHERE c.seriesID = seriesID;
DELETE FROM Series As s WHERE s.seriesID = seriesID;
END // 
DELIMITER ;

--modify_series

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--series_modify_status
--I: Inactive, A: Active, S: Stalled, H: Hiatus, D: Dropped, C: Complete


DROP FUNCTION IF EXISTS series_modify_status //
CREATE FUNCTION series_modify_status(seriesID smallint unsigned, status character) RETURNS boolean
BEGIN 
IF NOT (character = 'I' OR character = 'A' OR character = 'S' OR character = 'H' OR character = 'D' OR character = 'C') THEN
RETURN false;
END IF;
UPDATE Series AS s SET s.status = character WHERE s.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

--series_modify_thumbnail

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--series_modify_project_manager

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--series_modify_visible

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--series_modify_adult

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--ChapterIO

/*
	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null,
	chapterRevisionNumber tinyint unsigned not null, --0 by default; only changes when chapter has been revised after release
	chapterName varchar(50) null,
	groupOne smallint unsigned not null, --Home group, unless otherwise specified
	groupTwo smallint unsigned null,
	groupThree smallint unsigned null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (seriesID) REFERENCES Series(seriesID), 
	FOREIGN KEY (groupOne) REFERENCES ScanGroup(groupID), 
	FOREIGN KEY (groupTwo) REFERENCES ScanGroup(groupID), 
	FOREIGN KEY (groupThree) REFERENCES ScanGroup(groupID)
*/

--insert_chapter

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--delete_chapter
--If the chapter has any tasks associated with it, nothing is deleted and returns false.

DELIMITER // 
DROP FUNCTION IF EXISTS delete_chapter //
CREATE FUNCTION delete_chapter(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber smallint unsigned) RETURNS boolean
BEGIN 
DECLARE totalTasks smallint unsigned;
SELECT COUNT(*) INTO totalTasks FROM Task AS t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber;
IF totalTasks > 0 THEN
RETURN false;
END IF;
DELETE FROM Task As t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber;
END // 
DELIMITER ;

--delete_chapter_force
--Deletes a chapter and all associated tasks

DELIMITER // 
DROP FUNCTION IF EXISTS delete_chapter_force //
CREATE FUNCTION delete_chapter_force(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber smallint unsigned) RETURNS boolean
BEGIN 
DELETE FROM Task AS t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber;
DELETE FROM Chapter As c WHERE c.seriesID = seriesID AND c.chapterNumber = chapterNumber AND c.chapterSubNumber = chapterSubNumber;
END // 
DELIMITER ;

--modify_chapter

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--chapter_revision_increment

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--chapter_revision_decrement

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--chapter_add_group --If all three are full, return false

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;



--TaskIO

/*
	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null,
	userID smallint unsigned null,
	description varchar(100) null,
	status character null,
	UTCTimeCreated timestamp not null unique,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber, UTCTimeCreated),
	FOREIGN KEY (seriesID, chapterNumber, chapterSubNumber) REFERENCES Chapter(seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (userID) REFERENCES ScanUser(userID)
*/

--insert_task

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--delete_task

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 

DELETE FROM Task As t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber;

END // 
DELIMITER ;

--modify_task

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--task_assign_user

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--task_update_status

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;




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

--is_visible_series

DELIMITER // 
DROP FUNCTION IF EXISTS is_visible_series //
CREATE FUNCTION is_visible_series() RETURNS boolean
BEGIN 
DECLARE boolAdult boolean;
SELECT s.visibleToPublic FROM Series AS s INTO boolAdult WHERE s.seriesID = seriesID;
RETURN boolAdult;
END // 
DELIMITER ;

--is_visible_chapter

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--is_adult_series

DELIMITER // 
DROP FUNCTION IF EXISTS is_adult_series //
CREATE FUNCTION is_adult_series(seriesID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE boolAdult boolean;
SELECT s.isAdult FROM Series AS s INTO boolAdult WHERE s.seriesID = seriesID;
RETURN boolAdult;
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





--Getters

--

DELIMITER // 
DROP FUNCTION IF EXISTS get_project_count //
CREATE FUNCTION get_project_count() RETURNS smallint unsigned
BEGIN
	DECLARE total smallint unsigned;
	SELECT COUNT(*) INTO total FROM Series;
	RETURN total;
END // 
DELIMITER ;

--

DELIMITER // 
DROP FUNCTION IF EXISTS get_user_task_count //
CREATE FUNCTION get_user_task_count(userID smallint unsigned) RETURNS smallint unsigned
BEGIN
	DECLARE total smallint unsigned;
	SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID;
	RETURN total;
END // 
DELIMITER ;

--get_series_status
--I: Inactive, A: Active, S: Stalled, H: Hiatus, D: Dropped, C: Complete
--TODO: Consider returning character and force the assignment on the PHP

DELIMITER // 
DROP FUNCTION IF EXISTS get_series_status //
CREATE FUNCTION get_series_status(seriesID smallint unsigned) RETURNS varchar(8)
BEGIN 
DECLARE status character;
SELECT s.status INTO status FROM Series AS s WHERE s.seriesID = seriesID;
IF (status = 'I') THEN
RETURN "Inactive";
ELSE IF (status = 'A') THEN
RETURN "Active";
ELSE IF (status = 'S') THEN
RETURN "Stalled";
ELSE IF (status = 'H') THEN
RETURN "Hiatus";
ELSE IF (status = 'D') THEN
RETURN "Dropped";
ELSE IF (status = 'C') THEN
RETURN "Complete";
ELSE
RETURN "N/A";
END IF;
END // 
DELIMITER ;

--get_series_by_letter

DELIMITER // 
DROP PROCEDURE IF EXISTS get_series_by_letter //
CREATE PROCEDURE get_series_by_letter(IN startLetter character)
BEGIN 
SELECT * FROM Series AS s WHERE s.seriesTitle LIKE CONCAT(startLetter, '%');
END // 
DELIMITER ;

--get_series_by_genre

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

--get_series_by_status

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;

