/*
	TaskIO

	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null,
	userID smallint unsigned not null,
	description varchar(255) null,
	status character not null,
	userRole varchar(20) not null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber, userID, userRole),
	FOREIGN KEY (seriesID, chapterNumber, chapterSubNumber) REFERENCES Chapter(seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (userID) REFERENCES ScanUser(userID),
	FOREIGN KEY (userRole) REFERENCES Role(name)
*/

/*insert_task*/

DELIMITER // 
DROP FUNCTION IF EXISTS insert_task //
CREATE FUNCTION insert_task(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, userID smallint unsigned, userRole varchar(20)) RETURNS boolean NOT DETERMINISTIC
BEGIN 
INSERT INTO Task VALUES(seriesID, chapterNumber, chapterSubNumber, userID, null, 'A', userRole);
RETURN true;
END // 
DELIMITER ;

/*delete_task*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_task //
CREATE FUNCTION delete_task(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, userID smallint unsigned, userRole varchar(20)) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM Task WHERE Task.seriesID = seriesID AND Task.chapterNumber = chapterNumber AND Task.chapterSubNumber = chapterSubNumber AND Task.userID = userID AND Task.userRole = userRole;
RETURN true;
END // 
DELIMITER ;

/*task_set_status*/

DELIMITER // 
DROP FUNCTION IF EXISTS task_set_status //
CREATE FUNCTION task_set_status(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, userID smallint unsigned, userRole varchar(20), status character) RETURNS boolean DETERMINISTIC
BEGIN 
IF status = 'A' OR status = 'I' OR status = 'S' OR status = 'C' THEN
UPDATE Task AS t SET t.status = status WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber AND t.userID = userID AND t.userRole = userRole;
RETURN true;
END IF;
RETURN false;
END // 
DELIMITER ;

/*task_set_description*/

DELIMITER // 
DROP FUNCTION IF EXISTS task_set_description //
CREATE FUNCTION task_set_description(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, userID smallint unsigned, userRole varchar(20), description varchar(255)) RETURNS boolean DETERMINISTIC
BEGIN 
UPDATE Task AS t SET t.description = description WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber AND t.userID = userID AND t.userRole = userRole;
RETURN true;
END // 
DELIMITER ;

/*get_user_task_count*/

DELIMITER // 
DROP FUNCTION IF EXISTS get_user_task_count //
CREATE FUNCTION get_user_task_count(userID smallint unsigned) RETURNS smallint unsigned DETERMINISTIC
BEGIN
DECLARE total smallint unsigned;
SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID;
RETURN total;
END // 
DELIMITER ;

/*get_user_task_count_active*/

DELIMITER // 
DROP FUNCTION IF EXISTS get_user_task_count_active //
CREATE FUNCTION get_user_task_count_active(userID smallint unsigned) RETURNS smallint unsigned DETERMINISTIC
BEGIN
DECLARE total smallint unsigned;
SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID AND NOT t.status = 'C';
RETURN total;
END // 
DELIMITER ;

/*get_user_task_count_complete*/

DELIMITER // 
DROP FUNCTION IF EXISTS get_user_task_count_complete //
CREATE FUNCTION get_user_task_count_complete(userID smallint unsigned) RETURNS smallint unsigned DETERMINISTIC
BEGIN
DECLARE total smallint unsigned;
SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID AND t.status = 'C';
RETURN total;
END // 
DELIMITER ;

/*get_task_status*/

DELIMITER // 
DROP FUNCTION IF EXISTS get_task_status //
CREATE FUNCTION get_task_status(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, userID smallint unsigned, userRole varchar(20)) RETURNS character DETERMINISTIC
BEGIN 
DECLARE status smallint unsigned;
SELECT t.status INTO status FROM Task AS t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber AND t.userID = userID AND t.userRole = userRole;
RETURN status;
END // 
DELIMITER ;

/*get_chapter_task_count*/

DELIMITER // 
DROP FUNCTION IF EXISTS get_chapter_task_count //
CREATE FUNCTION get_chapter_task_count(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned) RETURNS smallint unsigned DETERMINISTIC
BEGIN
DECLARE total smallint unsigned;
SELECT COUNT(*) INTO total FROM Task AS t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber;
RETURN total;
END // 
DELIMITER ;

/*get_chapter_task_count_active*/

DELIMITER // 
DROP FUNCTION IF EXISTS get_chapter_task_count_active //
CREATE FUNCTION get_chapter_task_count_active(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned) RETURNS smallint unsigned DETERMINISTIC
BEGIN
DECLARE total smallint unsigned;
SELECT COUNT(*) INTO total FROM Task AS t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber;
RETURN total;
END // 
DELIMITER ;

/*get_chapter_task_count_complete*/

DELIMITER // 
DROP FUNCTION IF EXISTS get_chapter_task_count_complete //
CREATE FUNCTION get_chapter_task_count_complete(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned) RETURNS smallint unsigned DETERMINISTIC
BEGIN
DECLARE total smallint unsigned;
SELECT COUNT(*) INTO total FROM Task AS t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber;
RETURN total;
END // 
DELIMITER ;