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

--get_series_by_genre

DELIMITER // 
DROP FUNCTION IF EXISTS ******** //
CREATE FUNCTION ********() RETURNS ********
BEGIN 
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