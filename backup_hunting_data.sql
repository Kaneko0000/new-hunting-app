-- MySQL dump 10.13  Distrib 8.0.41, for macos14.7 (x86_64)
--
-- Host: localhost    Database: hunting_data
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hunter_license`
--

DROP TABLE IF EXISTS `hunter_license`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hunter_license` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `hunter_id` bigint unsigned NOT NULL,
  `license_id` bigint unsigned NOT NULL,
  `license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_expiry` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hunter_license_hunter_id_foreign` (`hunter_id`),
  KEY `hunter_license_license_id_foreign` (`license_id`),
  CONSTRAINT `hunter_license_hunter_id_foreign` FOREIGN KEY (`hunter_id`) REFERENCES `hunters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hunter_license_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hunter_license`
--

LOCK TABLES `hunter_license` WRITE;
/*!40000 ALTER TABLE `hunter_license` DISABLE KEYS */;
INSERT INTO `hunter_license` VALUES (1,1,1,NULL,'2025-02-14','2025-02-07 03:20:26','2025-02-07 03:20:26'),(2,1,3,NULL,'2025-02-14','2025-02-07 03:20:26','2025-02-07 03:20:26'),(3,1,4,NULL,'2025-02-14','2025-02-07 03:20:26','2025-02-07 03:20:26'),(4,2,2,NULL,'2025-02-18','2025-02-11 02:49:14','2025-02-11 02:49:14'),(5,7,1,NULL,'2025-02-28','2025-02-14 03:06:41','2025-02-14 03:06:41'),(6,8,2,NULL,'2025-02-23','2025-02-14 03:38:59','2025-02-14 03:38:59'),(7,8,3,NULL,'2025-02-23','2025-02-14 03:38:59','2025-02-14 03:38:59'),(8,9,2,NULL,'2025-02-10','2025-02-14 03:51:43','2025-02-14 03:51:43'),(9,10,4,NULL,'2025-02-20','2025-02-14 04:00:09','2025-02-14 04:00:09'),(10,11,2,NULL,'2025-02-06','2025-02-14 04:04:43','2025-02-14 04:04:43'),(11,12,2,NULL,'2025-02-22','2025-02-14 04:07:49','2025-02-14 04:07:49'),(12,13,2,NULL,'2025-02-07','2025-02-14 04:12:59','2025-02-14 04:12:59'),(13,14,2,NULL,'2025-02-07','2025-02-14 17:05:24','2025-02-14 17:05:24'),(14,15,3,NULL,'2025-02-14','2025-02-14 17:07:11','2025-02-14 17:07:11'),(15,16,4,NULL,'2025-02-28','2025-02-17 02:31:39','2025-02-17 02:31:39'),(16,17,4,'licenses/RckMbnyuB8FylJe3tSoxXZvyxAlWkRA36DwyLXVi.jpg','2025-03-01','2025-02-17 03:01:06','2025-02-17 03:01:06');
/*!40000 ALTER TABLE `hunter_license` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hunters`
--

DROP TABLE IF EXISTS `hunters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hunters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_expiry` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hunter',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hunters_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hunters`
--

LOCK TABLES `hunters` WRITE;
/*!40000 ALTER TABLE `hunters` DISABLE KEYS */;
INSERT INTO `hunters` VALUES (1,'テスト','test@gmail.com','800-3000-3333','岩手県',NULL,NULL,NULL,NULL,'2025-02-07 03:20:26','2025-02-07 03:20:26','$2y$12$1E7EBbjtRImj.LjrpWKZs.aWAi56BRT0E9Vaox8HSb4KZ9vKUK8Sq','pending','hunter'),(2,'金子里沙','1vs.aaa@gmail.com','080-1111-1234','福島県',NULL,NULL,NULL,NULL,'2025-02-11 02:49:14','2025-02-11 02:49:14','$2y$12$p1ncm3L7w7BJEIPYTPYlZO8aR7kXJoM4mPF4JX6RLjMU1u1bLgLku','pending','hunter'),(3,'hana','hana@gmail.com','08088888888','宮城県',NULL,NULL,NULL,NULL,'2025-02-13 12:29:25','2025-02-13 12:29:25','$2y$12$XA04YfgDmeG5AjHJR6nhRe43hrDedOTfYm4gBSgXzWWbMypSInzFS','pending','hunter'),(6,'gaa','gaa@gmail.com','33333333333','岩手県',NULL,NULL,NULL,NULL,'2025-02-14 02:57:11','2025-02-14 02:57:11','$2y$12$v.4OmMahheHPj0QZUdwdseWR.rpkLhBbHAfpIFzAHDc59ZG21rnQO','pending','hunter'),(7,'sss','sss@gmail.com','44444444444','宮城県',NULL,NULL,NULL,NULL,'2025-02-14 03:06:41','2025-02-14 03:06:41','$2y$12$ubhJG1jqCtAk/rfpzuh9fOGhnPw.Ygr3ZDVMEmc59hyiR81YWUO/2','pending','hunter'),(8,'1234','1234@gmail.com','77712341111','群馬県',NULL,NULL,NULL,NULL,'2025-02-14 03:38:59','2025-02-14 03:38:59','$2y$12$3pqiUpqQm277JR/UXfmwYemZ074qe9rFxsKGFJ/FlvNDU3Zymw/qy','pending','hunter'),(9,'mi','mi@gmail.com','33311111111','山形県',NULL,NULL,NULL,NULL,'2025-02-14 03:51:43','2025-02-14 03:51:43','$2y$12$kFUqjh3omRIWY/TAnxGKhuMnkHgOQG7jB7lHbiH5XFz2uaZqul5Hq','pending','hunter'),(10,'cchii','cchii@gmail.com','56782222222','秋田県',NULL,NULL,NULL,NULL,'2025-02-14 04:00:09','2025-02-14 04:00:09','$2y$12$GgSS0./b5w.Tt3O/VWj/pefQ5hWFgsfFveaFGV4MOf3LwIGUEodny','pending','hunter'),(11,'hanata','hanata@gmail.com','45612341234','東京都',NULL,NULL,NULL,NULL,'2025-02-14 04:04:43','2025-02-14 04:04:43','$2y$12$N9JmmO517B1cBtWs2cUTgOy9VKRbWRmT0lKHAkV/BP1cHC1r9Ekuu','pending','hunter'),(12,'kana','kana@gmail.com','45622222222','福島県',NULL,NULL,NULL,NULL,'2025-02-14 04:07:49','2025-02-14 04:07:49','$2y$12$5P1s27Nbmcws8/AlRtPm/OgSQOZqs2t8GUe4STR5N/Sg3Yxdct8G.','pending','hunter'),(13,'vava','vava@gmail.com','44411111111','宮城県',NULL,NULL,NULL,NULL,'2025-02-14 04:12:59','2025-02-14 04:12:59','$2y$12$lJRA9S0GNdA2yxMuGGO6iOw.PYlf/hlxNUIcd1B2cJ47/qsVabfCy','pending','hunter'),(14,'take','take@gmail.com','12333331234','山形県',NULL,NULL,NULL,NULL,'2025-02-14 17:05:24','2025-02-14 17:05:24','$2y$12$atbw7dFCf9hmPBUc7g9z6eR5pU1uQ/DknnkFHo8BpzrrgHBAUYq0O','pending','hunter'),(15,'fafa','fafa@gmail.com','23452222222','秋田県',NULL,NULL,NULL,NULL,'2025-02-14 17:07:11','2025-02-14 17:07:11','$2y$12$r7HXdNzngWdJ1EMIYNcB9ehjGPacXXwg36nBHhQpG7iMH3GCiHHh.','pending','hunter'),(16,'tttt','ttttttttt@gmail.com','44453331111','秋田県',NULL,NULL,NULL,NULL,'2025-02-17 02:31:38','2025-02-17 02:31:38','$2y$12$HBhqFmZaZEUl6z8hYHwnG.SeD9J053IPMoxkIbIn4QzKXi1lozEme','pending','hunter'),(17,'abc','abc@gmail.com','99911111111','沖縄県',NULL,'licenses/RckMbnyuB8FylJe3tSoxXZvyxAlWkRA36DwyLXVi.jpg',NULL,NULL,'2025-02-17 03:01:06','2025-02-17 03:01:06','$2y$12$dX2BEB4KOjlIpIxZ8FO8aekiDGHuaz6Utq3dBq1yOTIYM4.By6DQS','pending','hunter'),(18,'uuuu','uuuu@gmail.com','12344441111','神奈川県',NULL,'licenses/DAYnPRXR4eBVqRg6XMPJ3M2oVqqyVyjlDptFXnDV.jpg','2025-02-28',NULL,'2025-02-17 03:35:45','2025-02-17 03:35:45','$2y$12$X.Bml15vw8vHKTxUrmpLWOpn3T/FVBQAF5Q6wOWbqbiV9dmX2uJMu','pending','hunter'),(19,'bbbb','bbbb@gmail.com','44444441243','新潟県',NULL,'licenses/RBImGFeQWutkfeBGVx0yXMSZZDoPKNAOsN8BYVf0.jpg','2025-02-27',NULL,'2025-02-17 12:59:01','2025-02-17 12:59:01','$2y$12$8Ma1YezYloqBAMT28DtUMeJi3qrKLkXdTdL08fS.IyMl6OsAH4wTi','pending','hunter'),(20,'testuser','test@example.com','09012345678','東京都',NULL,NULL,NULL,NULL,'2025-02-17 13:26:02','2025-02-17 13:26:02','$2y$12$rSgO7pAMKkFSpObMrQrAhuef7Vg5rUJnvvYpv2dkL28ttE84G3CCm','pending','hunter'),(21,'母は母ｈ','vseeee@gmail.com','45677773333','山形県',NULL,'licenses/50V717RCEo69gllncWySk78iyQlUuOJgcmQWsAX3.jpg','2025-02-22',NULL,'2025-02-18 01:19:54','2025-02-18 01:19:54','$2y$12$tXxkULhtNczdbDBoTvg0jO2gOIH//EjcZyxalmacQr58MGVzD86im','pending','hunter');
/*!40000 ALTER TABLE `hunters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licenses`
--

DROP TABLE IF EXISTS `licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `licenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licenses`
--

LOCK TABLES `licenses` WRITE;
/*!40000 ALTER TABLE `licenses` DISABLE KEYS */;
INSERT INTO `licenses` VALUES (1,'わな猟',NULL,NULL),(2,'網猟',NULL,NULL),(3,'第一種',NULL,NULL),(4,'第二種',NULL,NULL);
/*!40000 ALTER TABLE `licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2025_02_03_113000_create_hunters_table',1),(6,'2025_02_04_114520_add_password_to_hunters_table',1),(7,'2025_02_05_122314_add_hunting_license_fields_to_hunters_table',1),(8,'2025_02_05_122840_create_licenses_table',1),(9,'2025_02_05_122921_create_hunter_license_table',1),(10,'2025_02_12_142229_add_status_to_hunters_table',2),(11,'2025_02_13_103738_add_role_to_hunters_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'管理者','vs.noo.moo@gmail.com',NULL,'$2y$12$zIP.biGE11zOYlN4rb8VZeQrLirzdhz.bTmkYKP6DeZmZOquI62eK',NULL,'2025-02-13 03:27:13','2025-02-13 03:27:13');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-18 20:43:52
