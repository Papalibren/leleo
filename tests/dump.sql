-- --------------------------------------------------------
-- Хост:                         MySQL-8.0
-- Версия сервера:               8.0.35 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных base
CREATE DATABASE IF NOT EXISTS `base` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `base`;

-- Дамп структуры для таблица base.site_info
CREATE TABLE IF NOT EXISTS `site_info` (
  `id` int unsigned NOT NULL,
  `site_name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slogan` mediumtext COLLATE utf8mb4_general_ci,
  `email` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone1` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone2` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vk` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tg` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дамп данных таблицы base.site_info: ~0 rows (приблизительно)

-- Дамп структуры для таблица base.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_hash` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `middle_name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role_id` int unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_user_user_role` (`role_id`),
  CONSTRAINT `FK_user_user_role` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дамп данных таблицы base.user: ~1 rows (приблизительно)
INSERT INTO `user` (`id`, `login`, `password_hash`, `first_name`, `last_name`, `middle_name`, `phone`, `email`, `role_id`) VALUES
	(5, 'admin', '$2y$13$X3hc7pSBEReq6DuL3hs26.iXv236tZR6JOMqf0WhpVQ4TxKp7eh1W', NULL, NULL, NULL, NULL, 'admin@mail.ru', 1);

-- Дамп структуры для таблица base.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дамп данных таблицы base.user_role: ~7 rows (приблизительно)
INSERT INTO `user_role` (`id`, `title`, `description`) VALUES
	(1, 'admin', 'Администратор'),
	(2, 'user', 'Пользователь'),
	(3, 'teacher', 'Учитель'),
	(4, 'student', 'Ученик'),
	(5, 'manager', 'Менеджер'),
	(6, 'master', 'Мастер'),
	(7, 'worker', 'Работник');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
