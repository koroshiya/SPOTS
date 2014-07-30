CREATE DATABASE IF NOT EXISTS SPOTS CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE SPOTS;

CREATE TABLE IF NOT EXISTS ScanGroup(

	groupID smallint unsigned not null AUTO_INCREMENT,
	groupName varchar(50) not null unique,
	URL varchar(255) null,
	PRIMARY KEY (groupID)

);

/*May be phased out later and replaced by SeriesGenre*/
CREATE TABLE IF NOT EXISTS Genre(

	name varchar(20) not null unique,
	PRIMARY KEY (name)

);

CREATE TABLE IF NOT EXISTS Role(

	name varchar(20) not null unique,
	PRIMARY KEY (name)

);

CREATE TABLE IF NOT EXISTS ScanUser(

	userID smallint unsigned not null AUTO_INCREMENT,
	userName varchar(30) not null unique,
	userPassword char(40) not null,
	email varchar(100) not null,
	title character not null,
	status character not null,
	PRIMARY KEY (userID)

);

/*Status - I: Inactive, A: Active, S: Stalled, H: Hiatus, D: Dropped, C: Complete*/
CREATE TABLE IF NOT EXISTS Series(

	seriesID smallint unsigned not null AUTO_INCREMENT,
	seriesTitle varchar(100) not null unique,
	status character null,
	description varchar(255) null,
	thumbnailURL varchar(255) null,
	projectManagerID smallint unsigned null,
	visibleToPublic boolean not null,
	isAdult boolean not null,
	author varchar(50) null,
	artist varchar(50) null,
	type varchar(50) null,
	downloadURL varchar(255) null,
	readOnlineURL varchar(255) null,
	PRIMARY KEY (seriesID),
	FOREIGN KEY (projectManagerID) REFERENCES ScanUser(userID)

);

/*Associative entity, so only one row for each genre needs to exist
Seemingly redundant, but the Genre table has explicit uses that make it useful*/
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
	chapterName varchar(100) null,
	visible boolean not null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (seriesID) REFERENCES Series(seriesID)

);

CREATE TABLE IF NOT EXISTS ChapterGroup(

	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null,
	groupID smallint unsigned not null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber, groupID),
	FOREIGN KEY (seriesID, chapterNumber, chapterSubNumber) REFERENCES Chapter(seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (groupID) REFERENCES ScanGroup(groupID)

);

CREATE TABLE IF NOT EXISTS UserRole(

	userID smallint unsigned not null,
	name varchar(20) not null,
	PRIMARY KEY (userID, name),
	FOREIGN KEY (userID) REFERENCES ScanUser(userID),
	FOREIGN KEY (name) REFERENCES Role(name)

);

CREATE TABLE IF NOT EXISTS Task(

	seriesID smallint unsigned not null,
	chapterNumber smallint unsigned not null,
	chapterSubNumber tinyint unsigned not null,
	userID smallint unsigned not null,
	description varchar(255) null,
	status character not null,
	userRole varchar(20) not null,
	PRIMARY KEY (seriesID, chapterNumber, chapterSubNumber, userID, userRole),
	FOREIGN KEY (seriesID, chapterNumber, chapterSubNumber) REFERENCES Chapter(seriesID, chapterNumber, chapterSubNumber),
	FOREIGN KEY (userID) REFERENCES ScanUser(userID),
	FOREIGN KEY (userRole) REFERENCES Role(name)

);