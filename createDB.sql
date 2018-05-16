/**
This step might be skipped!
 */
CREATE DATABASE `boilerplate_cms` /*!40100 COLLATE 'utf8_general_ci' */;

/*
User Table
*/
CREATE TABLE `user` (
	`userId` VARCHAR(100) NOT NULL,
	`email` VARCHAR(100) NOT NULL,
	`passwordHash` VARCHAR(100) NOT NULL
)
COLLATE='utf8_general_ci';

ALTER TABLE `user` ADD PRIMARY KEY(userId);

/**
Adding test user
 */
 INSERT INTO `user` (`userId`, `email`, `passwordHash`) VALUES ('12343452436346', 'info@testuser.de', 'ifh8nwqz8fwem9u98wauwa');
