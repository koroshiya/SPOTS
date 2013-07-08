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