/*
	ChapterIO

	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null,
	chapterRevisionNumber tinyint unsigned not null, --0 by default; only changes when chapter has been revised after release
	chapterName varchar(50) null,
	visible boolean not null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (seriesID) REFERENCES Series(seriesID)
*/

/*insert_chapter*/

DELIMITER // 
DROP FUNCTION IF EXISTS insert_chapter //
CREATE FUNCTION insert_chapter(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DECLARE totalChapters smallint unsigned;
SELECT COUNT(*) INTO totalChapters FROM Chapter WHERE Chapter.seriesID = seriesID AND Chapter.chapterNumber = chapterNumber AND Chapter.chapterSubNumber = chapterSubNumber;
IF totalChapters > 0 THEN
RETURN false;
END IF;
INSERT INTO Chapter Values(seriesID, chapterNumber, chapterSubNumber, 0, '', false);
INSERT INTO ChapterGroup Values(seriesID, chapterNumber, chapterSubNumber, 1);
RETURN true;
END // 
DELIMITER ;

/*delete_chapter
If the chapter has any tasks associated with it, nothing is deleted and returns false.*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_chapter //
CREATE FUNCTION delete_chapter(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DECLARE totalTasks smallint unsigned;
SELECT COUNT(*) INTO totalTasks FROM Task AS t WHERE t.seriesID = seriesID AND t.chapterNumber = chapterNumber AND t.chapterSubNumber = chapterSubNumber;
IF totalTasks > 0 THEN
RETURN false;
END IF;
DELETE FROM ChapterGroup WHERE ChapterGroup.seriesID = seriesID AND ChapterGroup.chapterNumber = chapterNumber AND ChapterGroup.chapterSubNumber = chapterSubNumber;
DELETE FROM Chapter WHERE Chapter.seriesID = seriesID AND Chapter.chapterNumber = chapterNumber AND Chapter.chapterSubNumber = chapterSubNumber;
RETURN true;
END // 
DELIMITER ;

/*delete_chapter_force
Deletes a chapter and all associated tasks*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_chapter_force //
CREATE FUNCTION delete_chapter_force(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM Task WHERE Task.seriesID = seriesID AND Task.chapterNumber = chapterNumber AND Task.chapterSubNumber = chapterSubNumber;
DELETE FROM ChapterGroup WHERE ChapterGroup.seriesID = seriesID AND ChapterGroup.chapterNumber = chapterNumber AND ChapterGroup.chapterSubNumber = chapterSubNumber;
DELETE FROM Chapter WHERE Chapter.seriesID = seriesID AND Chapter.chapterNumber = chapterNumber AND Chapter.chapterSubNumber = chapterSubNumber;
RETURN true;
END // 
DELIMITER ;

/*chapter_revision_modify*/

DELIMITER // 
DROP FUNCTION IF EXISTS chapter_revision_modify //
CREATE FUNCTION chapter_revision_modify(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, revision tinyint unsigned) RETURNS boolean DETERMINISTIC
BEGIN 
UPDATE Chapter AS c SET c.chapterRevisionNumber = revision WHERE c.seriesID = seriesID AND c.chapterNumber = chapterNumber AND c.chapterSubNumber = chapterSubNumber;
RETURN true;
END // 
DELIMITER ;

/*chapter_add_group*/

DELIMITER // 
DROP FUNCTION IF EXISTS chapter_add_group //
CREATE FUNCTION chapter_add_group(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, newGroupID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
INSERT INTO ChapterGroup Values(seriesID, chapterNumber, chapterSubNumber, newGroupID);
RETURN true;
END // 
DELIMITER ;

/*chapter_remove_group*/

DELIMITER // 
DROP FUNCTION IF EXISTS chapter_remove_group //
CREATE FUNCTION chapter_remove_group(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, groupID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM ChapterGroup WHERE ChapterGroup.seriesID = seriesID AND ChapterGroup.chapterNumber = chapterNumber AND ChapterGroup.chapterSubNumber = chapterSubNumber AND ChapterGroup.groupID = groupID;
RETURN true;
END // 
DELIMITER ;

/*chapter_remove_group_all*/

DELIMITER // 
DROP FUNCTION IF EXISTS chapter_remove_group_all //
CREATE FUNCTION chapter_remove_group_all(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM ChapterGroup WHERE ChapterGroup.seriesID = seriesID AND ChapterGroup.chapterNumber = chapterNumber AND ChapterGroup.chapterSubNumber = chapterSubNumber;
RETURN true;
END // 
DELIMITER ;

/*chapter_set_visible*/

DELIMITER // 
DROP FUNCTION IF EXISTS chapter_set_visible //
CREATE FUNCTION chapter_set_visible(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned, visible boolean) RETURNS boolean DETERMINISTIC
BEGIN 
UPDATE Chapter AS c SET c.visible = visible;
RETURN true;
END // 
DELIMITER ;


/*is_visible_chapter*/

DELIMITER // 
DROP FUNCTION IF EXISTS is_visible_chapter //
CREATE FUNCTION is_visible_chapter(seriesID smallint unsigned, chapterNumber smallint unsigned, chapterSubNumber tinyint unsigned) RETURNS boolean DETERMINISTIC
BEGIN 
DECLARE visible boolean;
SELECT c.visible INTO visible FROM Series AS c WHERE c.seriesID = seriesID AND c.chapterNumber = chapterNumber AND c.chapterSubNumber = chapterSubNumber;
RETURN visible;
END // 
DELIMITER ;