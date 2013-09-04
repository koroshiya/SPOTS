/*series_add_genre*/

DELIMITER // 
DROP FUNCTION IF EXISTS series_add_genre //
CREATE FUNCTION series_add_genre(seriesID smallint unsigned, name varchar(20)) RETURNS boolean
BEGIN 
INSERT INTO SeriesGenre VALUES(seriesID, name);
RETURN true;
END // 
DELIMITER ;

/*series_remove_genre*/

DELIMITER // 
DROP FUNCTION IF EXISTS series_remove_genre //
CREATE FUNCTION series_remove_genre(seriesID smallint unsigned, name varchar(20)) RETURNS boolean
BEGIN 
DELETE FROM SeriesGenre WHERE SeriesGenre.seriesID = seriesID AND SeriesGenre.name = name;
RETURN true;
END // 
DELIMITER ;

/*series_remove_genre_all*/

DELIMITER // 
DROP FUNCTION IF EXISTS series_remove_genre_all //
CREATE FUNCTION series_remove_genre_all(seriesID smallint unsigned) RETURNS boolean
BEGIN 
DELETE FROM SeriesGenre WHERE SeriesGenre.seriesID = seriesID;
RETURN true;
END // 
DELIMITER ;

/*series_get_genres*/

DELIMITER // 
DROP PROCEDURE IF EXISTS series_get_genres //
CREATE PROCEDURE series_get_genres(IN seriesID smallint unsigned)
BEGIN 
SELECT sg.name FROM SeriesGenre AS sg WHERE sg.seriesID = seriesID;
END // 
DELIMITER ;

/*series_get_by_genre*/

DELIMITER // 
DROP PROCEDURE IF EXISTS series_get_by_genre //
CREATE PROCEDURE series_get_by_genre(IN name varchar(20))
BEGIN 
SELECT * FROM SeriesGenre AS sg WHERE sg.name = name;
END // 
DELIMITER ;