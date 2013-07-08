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










--is_visible_chapter

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
END // 
DELIMITER ;