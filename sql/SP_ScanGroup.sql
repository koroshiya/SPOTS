--ScanGroupIO

/*
	groupID smallint unsigned not null AUTO_INCREMENT,
	groupName varchar(50) not null,
	URL varchar(255) null,
	PRIMARY KEY (groupID)
*/

--insert_scangroup

DELIMITER // 
DROP FUNCTION IF EXISTS insert_scangroup //
CREATE FUNCTION insert_scangroup(groupName varchar(50), URL varchar(255)) RETURNS boolean
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

--delete_scangroup --TODO: check if group is home group

DELIMITER // 
DROP FUNCTION IF EXISTS delete_scangroup //
CREATE FUNCTION delete_scangroup(groupID smallint unsigned) RETURNS boolean
BEGIN 
DECLARE totalChapters smallint unsigned;
SELECT COUNT(*) INTO totalChapters FROM ChapterGroup AS cg WHERE cg.groupID = groupID;
IF totalChapters > 0 THEN
RETURN false;
END IF;
DELETE FROM ScanGroup AS sg WHERE sg.groupID = groupID;
RETURN true;
END // 
DELIMITER ;

--delete_scangroup_force --TODO: check if group is home group

DELIMITER // 
DROP FUNCTION IF EXISTS delete_scangroup_force //
CREATE FUNCTION delete_scangroup_force(groupID smallint unsigned) RETURNS boolean
BEGIN 
DELETE FROM ChapterGroup AS cg WHERE cg.groupID = groupID
DELETE FROM ScanGroup AS sg WHERE sg.groupID = groupID;
RETURN true;
END // 
DELIMITER ;

--modify_scangroup

DELIMITER // 
DROP FUNCTION IF EXISTS modify_scangroup //
CREATE FUNCTION modify_scangroup(groupID smallint unsigned, groupName varchar(50), groupURL varchar(255)) RETURNS boolean
BEGIN 
UPDATE ScanGroup AS sg SET sg.groupName = COALESCE(groupName, sg.groupName), sg.groupURL = COALESCE(groupURL, sg.URL) WHERE sg.groupID = groupID;
RETURN true;
END // 
DELIMITER ;