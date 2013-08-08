/**
*Author: Koro
*File: 01_initial_build.sql
*Date created: 04/July/2012
*Date last modified: 29/July/2012
*Changelog: 1.01: userID in Task can now be null; necessary for deallocation
			1.02: Added visible param to Chapter table.
			1.03: Removed genres from Series, added Genre and SeriesGenre tables
			1.04: Removed config table; such params are to be declared via user role instead
*/



CREATE DATABASE IF NOT EXISTS SPOTS CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE SPOTS;

CREATE TABLE IF NOT EXISTS ScanGroup(

	groupID smallint unsigned not null AUTO_INCREMENT,
	groupName varchar(30) not null,
	URL varchar(50) null,
	PRIMARY KEY (groupID)

);

--Status - I: Inactive, A: Active, S: Stalled, H: Hiatus, D: Dropped, C: Complete
CREATE TABLE IF NOT EXISTS Series(

	seriesID smallint unsigned not null AUTO_INCREMENT,
	seriesTitle varchar(50) not null,
	status character null,
	description varchar(255) null,
	thumbnailURL varchar(50) null,
	projectManagerID smallint unsigned null,
	visibleToPublic boolean not null,
	isAdult boolean not null,
	PRIMARY KEY (seriesID)

);

--May be phased out later and replaced by SeriesGenre
CREATE TABLE IF NOT EXISTS Genre(

	name varchar(20) not null unique,
	PRIMARY KEY (name)

);

--Associative entity, so only one row for each genre needs to exist
--Seemingly redundant, but the Genre table has explicit uses that make it useful
CREATE TABLE IF NOT EXISTS SeriesGenre(

	seriesID smallint unsigned not null,
	name varchar(20) not null,
	PRIMARY KEY (seriesID, name),
	FOREIGN KEY (seriesID) REFERENCES Series(seriesID),
	FOREIGN KEY (name) REFERENCES Genre(name)

);

CREATE TABLE IF NOT EXISTS Chapter(

	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null, /*eg. 5 if the chapter is 10.5*/
	chapterRevisionNumber tinyint unsigned not null, /*0 by default; only changes when chapter has been revised after release*/
	chapterName varchar(50) null,
	groupOne smallint unsigned not null, /*Home group, unless otherwise specified*/
	groupTwo smallint unsigned null,
	groupThree smallint unsigned null,
	visible boolean not null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (seriesID) REFERENCES Series(seriesID), 
	FOREIGN KEY (groupOne) REFERENCES ScanGroup(groupID), 
	FOREIGN KEY (groupTwo) REFERENCES ScanGroup(groupID), 
	FOREIGN KEY (groupThree) REFERENCES ScanGroup(groupID)

);

CREATE TABLE IF NOT EXISTS ScanUser(

	userID smallint unsigned not null AUTO_INCREMENT,
	userName varchar(30) not null,
	userPassword binary(20) not null,
	userRole character not null, /*guest by default*/
	email varchar(50) null,
	title character null,
	PRIMARY KEY (userID)

);

CREATE TABLE IF NOT EXISTS Task(

	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null,
	userID smallint unsigned not null,
	description varchar(100) null,
	status character null,
	userRole character not null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber, userID, userRole),
	FOREIGN KEY (seriesID, chapterNumber, chapterSubNumber) REFERENCES Chapter(seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (userID) REFERENCES ScanUser(userID)

);