# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.29-log)
# Database: linden_tasks
# Generation Time: 2013-04-02 09:56:15 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table priorities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `priorities`;

CREATE TABLE `priorities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `priorities` WRITE;
/*!40000 ALTER TABLE `priorities` DISABLE KEYS */;

INSERT INTO `priorities` (`id`, `title`)
VALUES
	(1,'Urgent'),
	(2,'Emergency'),
	(3,'High'),
	(4,'Important'),
	(5,'Needed'),
	(6,'Someday');

/*!40000 ALTER TABLE `priorities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `priority_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `priority_id` (`priority_id`),
  CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`id`, `user_id`, `priority_id`, `name`, `due_date`, `created`, `updated`)
VALUES
	(2,6,1,'alejo2','2013-04-01 03:05:00','2013-04-01 03:05:22','2013-04-01 03:05:22'),
	(19,5,2,'My new task 56','2013-04-05 01:08:00','2013-04-02 00:34:32','2013-04-02 02:42:31'),
	(20,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:34:32','2013-04-02 00:34:32'),
	(21,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:34:56','2013-04-02 00:34:56'),
	(22,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:35:10','2013-04-02 00:35:10'),
	(23,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:35:10','2013-04-02 00:35:10'),
	(24,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:36:20','2013-04-02 00:36:20'),
	(25,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:36:21','2013-04-02 00:36:21'),
	(27,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:36:49','2013-04-02 00:36:49'),
	(28,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:37:36','2013-04-02 00:37:36'),
	(29,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:37:36','2013-04-02 00:37:36'),
	(31,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:38:26','2013-04-02 00:38:26'),
	(32,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:38:38','2013-04-02 02:49:11'),
	(35,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:38:39','2013-04-02 00:38:39'),
	(38,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 00:41:53','2013-04-02 02:54:58'),
	(40,5,1,'My ui first task','2013-04-02 01:45:00','2013-04-02 00:45:34','2013-04-02 00:45:34'),
	(42,5,1,'sdfsfsf','2013-04-02 01:03:00','2013-04-02 01:03:12','2013-04-02 02:43:55'),
	(43,5,6,'asdadad','2013-04-02 01:04:00','2013-04-02 01:05:21','2013-04-02 01:05:21'),
	(44,5,1,'xczczc','2013-04-02 01:05:00','2013-04-02 01:06:11','2013-04-02 01:06:11'),
	(45,5,4,'asdada','2013-04-02 01:08:00','2013-04-02 01:08:14','2013-04-02 01:08:14'),
	(46,5,2,'sddadad','2013-04-02 01:09:00','2013-04-02 01:09:29','2013-04-02 01:09:29'),
	(48,5,2,'My new task','2013-04-05 01:08:00','2013-04-02 01:32:51','2013-04-02 01:32:51'),
	(51,5,1,'45 new','2013-04-12 01:08:00','2013-04-02 01:59:10','2013-04-02 02:52:59');

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` char(36) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `uid`, `email`, `password`, `created`, `updated`)
VALUES
	(5,'515aa3ba-f05c-47ef-8cf9-2916cca207d6','alejo.jm@gmail.com','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2013-04-01 02:48:38','2013-04-02 04:24:10'),
	(6,'515a8f49-fe6c-4a20-a4a8-2848cca207d6','alejo.jm2@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','2013-04-01 03:03:27','2013-04-02 02:56:57');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
