/**
	name varchar(20) not null
*/

/*insert_genre*/

DELIMITER // 
DROP FUNCTION IF EXISTS insert_genre //
CREATE FUNCTION insert_genre(name varchar(20)) RETURNS boolean NOT DETERMINISTIC
BEGIN 
INSERT INTO Genre VALUES(name);
RETURN true;
END // 
DELIMITER ;

/*delete_genre*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_genre //
CREATE FUNCTION delete_genre(name varchar(20)) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM Genre WHERE Genre.name = name;
RETURN true;
END // 
DELIMITER ;

/*delete_genre_force*/

DELIMITER // 
DROP FUNCTION IF EXISTS delete_genre_force //
CREATE FUNCTION delete_genre_force(name varchar(20)) RETURNS boolean NOT DETERMINISTIC
BEGIN 
DELETE FROM SeriesGenre WHERE SeriesGenre.name = name;
DELETE FROM Genre WHERE Genre.name = name;
RETURN true;
END // 
DELIMITER ;