/*
	ScanGroupIO

	groupID smallint unsigned not null AUTO_INCREMENT,
	groupName varchar(50) not null,
	URL varchar(255) null,
	PRIMARY KEY (groupID)
*/

/*delete_scangroup*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_scangroup //
CREATE FUNCTION delete_scangroup(groupID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DECLARE totalChapters smallint unsigned;
SELECT COUNT(*) INTO totalChapters FROM ChapterGroup AS cg WHERE cg.groupID = groupID;
IF totalChapters > 0 THEN
RETURN false;
END IF;
DELETE FROM ScanGroup WHERE ScanGroup.groupID = groupID;
RETURN true;
END // 
DELIMITER ;

/*delete_scangroup_force*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_scangroup_force //
CREATE FUNCTION delete_scangroup_force(groupID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM ChapterGroup WHERE ChapterGroup.groupID = groupID;
DELETE FROM ScanGroup WHERE ScanGroup.groupID = groupID;
RETURN true;
END // 
DELIMITER ;

/*modify_scangroup*/

DELIMITER // 
DROP FUNCTION IF EXISTS modify_scangroup //
CREATE FUNCTION modify_scangroup(groupID smallint unsigned, groupName varchar(50), groupURL varchar(255)) RETURNS boolean NOT DETERMINISTIC
BEGIN 
UPDATE ScanGroup AS sg SET sg.groupName = COALESCE(groupName, sg.groupName), sg.groupURL = COALESCE(groupURL, sg.URL) WHERE sg.groupID = groupID;
RETURN true;
END // 
DELIMITER ;