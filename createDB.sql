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


 /**
 News Table
  */
  CREATE TABLE `news` (
	`newsId` VARCHAR(200) NOT NULL,
	`title` VARCHAR(100) NOT NULL,
	`text` TEXT NOT NULL,
	`created` DATETIME NOT NULL,
	`userId` VARCHAR(200) NOT NULL,
	PRIMARY KEY (`newsId`)
)
COLLATE='utf8_general_ci';


/**
Adding test news
 */
INSERT INTO `boilerplate_cms`.`news` (`newsId`, `title`, `text`, `created`, `userId`) VALUES ('518b6e46-0144-4d84-adde-936fa80ca7e4', 'TitelNews1', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec', '2018-05-30 11:34:26', '518b6e46-0144-4d84-adde-936fa80ca7e6');
