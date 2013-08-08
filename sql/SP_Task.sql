--TaskIO

/*
	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null,
	userID smallint unsigned not null,
	description varchar(100) null,
	status character null,
	userRole character not null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber, userID, userRole),
	FOREIGN KEY (seriesID, chapterNumber, chapterSubNumber) REFERENCES Chapter(seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (userID) REFERENCES ScanUser(userID)
*/

--insert_task

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********(seriesID, chapterNumber, chapterSubNumber, userID, userRole) RETURNS ********
BEGIN 
END // 
DELIMITER ;

--delete_task

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********(seriesID, chapterNumber, chapterSubNumber, userID, userRole) RETURNS ********
BEGIN 

DELETE FROM Task As t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber AND t.userID = userID AND t.userRole = userRole;

END // 
DELIMITER ;

--modify_task

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********(seriesID, chapterNumber, chapterSubNumber, userID, userRole) RETURNS ********
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

--get_user_task_count

DELIMITER // 
DROP FUNCTION IF EXISTS get_user_task_count //
CREATE FUNCTION get_user_task_count(userID smallint unsigned) RETURNS smallint unsigned
BEGIN
	DECLARE total smallint unsigned;
	SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID;
	RETURN total;
END // 
DELIMITER ;

--get_user_task_count_active

DELIMITER // 
DROP FUNCTION IF EXISTS get_user_task_count_active //
CREATE FUNCTION get_user_task_count_active(userID smallint unsigned) RETURNS smallint unsigned
BEGIN
	DECLARE total smallint unsigned;
	SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID AND NOT t.status = 'C';
	RETURN total;
END // 
DELIMITER ;

--get_user_task_count_complete

DELIMITER // 
DROP FUNCTION IF EXISTS get_user_task_count_complete //
CREATE FUNCTION get_user_task_count_complete(userID smallint unsigned) RETURNS smallint unsigned
BEGIN
	DECLARE total smallint unsigned;
	SELECT COUNT(*) INTO total FROM Task AS t WHERE t.userID = userID AND t.status = 'C';
	RETURN total;
END // 
DELIMITER ;

--get_user_tasks

DELIMITER // 
DROP PROCEDURE IF EXISTS get_user_tasks //
CREATE PROCEDURE get_user_tasks(IN userID smallint unsigned)
BEGIN 
SELECT * FROM Task AS t WHERE t.userID = userID;
END // 
DELIMITER ;

--get_user_tasks_active

DELIMITER // 
DROP PROCEDURE IF EXISTS get_user_tasks_active //
CREATE PROCEDURE get_user_tasks_active(IN userID smallint unsigned)
BEGIN 
SELECT * FROM Task AS t WHERE t.userID = userID AND NOT t.status = 'C';
END // 
DELIMITER ;

--get_user_tasks_complete

DELIMITER // 
DROP PROCEDURE IF EXISTS get_user_tasks_complete //
CREATE PROCEDURE get_user_tasks_complete(IN userID smallint unsigned)
BEGIN 
SELECT * FROM Task AS t WHERE t.userID = userID AND t.status = 'C';
END // 
DELIMITER ;