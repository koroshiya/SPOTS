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