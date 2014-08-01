/*
	SeriesIO
	
	seriesID smallint unsigned not null AUTO_INCREMENT,
	seriesTitle varchar(100) not null,
	status character null,
	description varchar(255) null,
	thumbnailURL varchar(255) null,
	projectManagerID smallint unsigned null,
	visibleToPublic boolean not null,
	isAdult boolean not null,
	author varchar(50) null,
	artist varchar(50) null,
	type varchar(50) null, --eg. manga, manhwa, etc.
	downloadURL varchar(255) null,
	readOnlineURL varchar(255) null,
	PRIMARY KEY (seriesID),
	FOREIGN KEY (projectManagerID) REFERENCES ScanUser(userID)
*/

/*insert_series*/

DELIMITER // 
DROP FUNCTION IF EXISTS insert_series //
CREATE FUNCTION insert_series(seriesTitle varchar(100), status character, description varchar(255), thumbnailURL varchar(255), projectManagerID smallint unsigned, visibleToPublic boolean, isAdult boolean) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DECLARE totalSeries smallint unsigned;
SELECT COUNT(*) INTO totalSeries FROM Series;
IF totalSeries = 65535 THEN
RETURN false;
END IF;
INSERT INTO Series(seriesTitle, status, description, thumbnailURL, projectManagerID, visibleToPublic, isAdult) VALUES(seriesTitle, status, description, thumbnailURL, projectManagerID, visibleToPublic, isAdult);
RETURN true;
END // 
DELIMITER ;

/*delete_series
If the series has any chapters associated with it, nothing is deleted and returns false.*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_series //
CREATE FUNCTION delete_series(seriesID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DECLARE totalChapters smallint unsigned;
SELECT COUNT(*) INTO totalChapters FROM Chapter AS c WHERE c.seriesID = seriesID;
IF totalChapters > 0 THEN
RETURN false;
END IF;
DELETE FROM Series WHERE Series.seriesID = seriesID;
END // 
DELIMITER ;

/*delete_series_force
Deletes a series and all associated chapters & tasks.*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_series_force //
CREATE FUNCTION delete_series_force(seriesID smallint unsigned) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM Task WHERE Task.seriesID = seriesID;
DELETE FROM Chapter WHERE Chapter.seriesID = seriesID;
DELETE FROM Series WHERE Series.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

/*series_set_status
I: Inactive, A: Active, S: Stalled, H: Hiatus, D: Dropped, C: Complete*/

DELIMITER // 
DROP FUNCTION IF EXISTS series_set_status //
CREATE FUNCTION series_set_status(seriesID smallint unsigned, status character) RETURNS boolean DETERMINISTIC
BEGIN 
IF NOT status = 'I' OR status = 'A' OR status = 'S' OR status = 'H' OR status = 'D' OR status = 'C' THEN
RETURN false;
END IF;
UPDATE Series AS s SET s.status = status WHERE s.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

/*series_set_project_manager*/

DELIMITER // 
DROP FUNCTION IF EXISTS series_set_project_manager //
CREATE FUNCTION series_set_project_manager(seriesID smallint unsigned, managerID smallint unsigned) RETURNS boolean DETERMINISTIC
BEGIN 
UPDATE Series AS s SET s.projectManagerID = managerID WHERE s.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

/*series_set_visible*/

DELIMITER // 
DROP FUNCTION IF EXISTS series_set_visible //
CREATE FUNCTION series_set_visible(seriesID smallint unsigned, visible boolean) RETURNS boolean DETERMINISTIC
BEGIN 
UPDATE Series AS s SET s.visibleToPublic = visible WHERE s.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

/*series_set_adult*/

DELIMITER // 
DROP FUNCTION IF EXISTS series_set_adult //
CREATE FUNCTION series_set_adult(seriesID smallint unsigned, adult boolean) RETURNS boolean DETERMINISTIC
BEGIN 
UPDATE Series AS s SET s.isAdult = adult WHERE s.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

/*is_visible_series*/

DELIMITER // 
DROP FUNCTION IF EXISTS is_visible_series //
CREATE FUNCTION is_visible_series(seriesID smallint unsigned) RETURNS boolean DETERMINISTIC
BEGIN 
DECLARE boolPublic boolean;
SELECT s.visibleToPublic INTO boolPublic FROM Series AS s WHERE s.seriesID = seriesID;
RETURN boolPublic;
END // 
DELIMITER ;

/*is_adult_series*/

DELIMITER // 
DROP FUNCTION IF EXISTS is_adult_series //
CREATE FUNCTION is_adult_series(seriesID smallint unsigned) RETURNS boolean DETERMINISTIC
BEGIN 
DECLARE boolAdult boolean;
SELECT s.isAdult INTO boolAdult FROM Series AS s WHERE s.seriesID = seriesID;
RETURN boolAdult;
END // 
DELIMITER ;

/*get_series_status*/

DELIMITER // 
DROP FUNCTION IF EXISTS get_series_status //
CREATE FUNCTION get_series_status(seriesID smallint unsigned) RETURNS character DETERMINISTIC
BEGIN 
DECLARE status character;
SELECT s.status INTO status FROM Series AS s WHERE s.seriesID = seriesID;
RETURN status;
END // 
DELIMITER ;