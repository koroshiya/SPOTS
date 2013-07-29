--SeriesIO

/*
	seriesID smallint unsigned not null AUTO_INCREMENT,
	seriesTitle varchar(50) not null,
	status character null,
	description varchar(255) null,
	thumbnailURL varchar(50) null,
	projectManagerID smallint unsigned null,
	visibleToPublic boolean not null,
	isAdult boolean not null,
	PRIMARY KEY (seriesID)
*/

/*
Changelog:	1.01: Implemented series_set_adult, series_set_visible, series_set_project_manager
			1.02: Removed genre instances to reflect changes to DB, implemented get_series_by_genre
*/

--insert_series

DELIMITER // 
DROP FUNCTION IF EXISTS insert_series //
CREATE FUNCTION insert_series(seriesTitle varchar(50), status character, description varchar(255), thumbnailURL varchar(50), projectManagerID smallint unsigned, visibleToPublic boolean, isAdult boolean) RETURNS boolean
BEGIN 
DECLARE totalSeries smallint unsigned;
SELECT COUNT(*) INTO totalSeries FROM Series;
IF totalSeries = 65535 THEN
RETURN false;
END IF;
INSERT INTO Series VALUES(seriesTitle, character, description, thumbnailURL, projectManagerID, visibleToPublic, isAdult);
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
DROP FUNCTION IF EXISTS delete_series_force //
CREATE FUNCTION delete_series_force(seriesID smallint unsigned) RETURNS boolean
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

--series_set_project_manager

DELIMITER // 
DROP FUNCTION IF EXISTS series_set_project_manager //
CREATE FUNCTION series_set_project_manager(seriesID smallint unsigned, managerID smallint unsigned) RETURNS boolean
BEGIN 
UPDATE Series AS s SET s.projectManagerID = managerID WHERE s.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

--series_set_visible

DELIMITER // 
DROP FUNCTION IF EXISTS series_set_visible //
CREATE FUNCTION series_set_visible(seriesID smallint unsigned, visible boolean) RETURNS boolean
BEGIN 
UPDATE Series AS s SET s.visibleToPublic = visible WHERE s.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

--series_set_adult

DELIMITER // 
DROP FUNCTION IF EXISTS series_set_adult //
CREATE FUNCTION series_set_adult(seriesID smallint unsigned, adult boolean) RETURNS boolean
BEGIN 
UPDATE Series AS s SET s.isAdult = adult WHERE s.seriesID = seriesID;
RETURN true;
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

--get_project_count

DELIMITER // 
DROP FUNCTION IF EXISTS get_project_count //
CREATE FUNCTION get_project_count() RETURNS smallint unsigned
BEGIN
	DECLARE total smallint unsigned;
	SELECT COUNT(*) INTO total FROM Series;
	RETURN total;
END // 
DELIMITER ;

--get_series_status

DELIMITER // 
DROP FUNCTION IF EXISTS get_series_status //
CREATE FUNCTION get_series_status(seriesID smallint unsigned) RETURNS character
BEGIN 
DECLARE status character;
SELECT s.status INTO status FROM Series AS s WHERE s.seriesID = seriesID;
RETURN status;
END // 
DELIMITER ;

--get_series_by_id

DELIMITER // 
DROP PROCEDURE IF EXISTS get_series_by_id //
CREATE PROCEDURE get_series_by_id(IN seriesID smallint unsigned)
BEGIN 
SELECT * FROM Series AS s WHERE s.seriesID = seriesID;
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

--get_series_by_status

DELIMITER // 
DROP PROCEDURE IF EXISTS get_series_by_status //
CREATE PROCEDURE get_series_by_status(IN status character)
BEGIN 
SELECT * FROM Series AS s WHERE s.status = status;
END // 
DELIMITER ;

--get_series_by_genre

DELIMITER // 
DROP PROCEDURE IF EXISTS get_series_by_genre //
CREATE PROCEDURE get_series_by_genre(IN genre text)
BEGIN 
SELECT * FROM SERIES AS s WHERE s.seriesID = sg.seriesID
INNER JOIN SeriesGenre AS sg
ON sg.name = genre;
END // 
DELIMITER ;

--get_series_all

DELIMITER // 
DROP PROCEDURE IF EXISTS get_series_all //
CREATE PROCEDURE get_series_all()
BEGIN 
SELECT * FROM Series AS s;
END // 
DELIMITER ;