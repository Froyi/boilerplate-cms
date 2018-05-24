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
	`passwordHash` VARCHAR(100) NOT NULL,
	`role` ENUM('Admin','Member') NOT NULL,
	PRIMARY KEY (`userId`)
)
COLLATE='utf8_general_ci';

/**
Adding test user

PW: Test1234
 */
 INSERT INTO `user` (`userId`, `email`, `passwordHash`, `role`) VALUES ('518b6e46-0144-4d84-adde-936fa80ca7e6', 'info@testuser.de', '$2y$10$O9NVUyV1KuDMlSHXGASFnuHYCsD0MM0sduuz0UiLoKNDJJ2EBaH0e', 'Admin');
