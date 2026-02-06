-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: caffe
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Makanan','makanan',1,1,'2026-01-16 03:29:41','2026-01-16 03:29:41'),(2,'Minuman','minuman',2,1,'2026-01-16 03:29:41','2026-01-16 03:29:41');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_01_16_101036_create_settings_table',2),(5,'2026_01_16_102041_create_categories_table',3),(6,'2026_01_16_102129_create_products_table',3),(7,'2026_01_16_103436_create_orders_table',4),(8,'2026_01_16_105844_add_role_to_users_table',5),(9,'2026_01_16_112739_add_payment_method_to_orders_table',6),(10,'2026_02_02_044112_add_midtrans_fields_to_orders_table',7),(11,'2026_02_02_061509_change_status_column_in_orders_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `table_number` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `discount` decimal(10,0) NOT NULL DEFAULT 0,
  `total` decimal(10,0) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `midtrans_order_id` varchar(255) DEFAULT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `transaction_status` varchar(255) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  UNIQUE KEY `orders_midtrans_order_id_unique` (`midtrans_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (14,'202601170001','agung','4','0821319891',17000,0,17000,'completed','QR Code',NULL,NULL,NULL,NULL,'{\"2\":{\"name\":\"No Limit Toast\",\"price\":\"17000\",\"image\":\"1768565464_no-limit-toast.jpeg\",\"quantity\":1}}','2026-01-17 08:22:51','2026-01-17 08:24:26'),(15,'202601170002','dave','5','0821319891',37000,0,37000,'completed','Tunai',NULL,NULL,NULL,NULL,'{\"1\":{\"name\":\"French Toast\",\"price\":\"17000\",\"image\":\"1768565455_french-toast.jpeg\",\"quantity\":1},\"5\":{\"name\":\"No Limit Coffee\",\"price\":\"20000\",\"image\":\"1768565643_no-limit-coffee.jpeg\",\"quantity\":1}}','2026-01-17 08:24:11','2026-01-17 08:24:37'),(16,'202601170003','riski','9','0821391921',37000,0,37000,'completed','Tunai',NULL,NULL,NULL,NULL,'{\"5\":{\"name\":\"No Limit Coffee\",\"price\":\"20000\",\"image\":\"1768565643_no-limit-coffee.jpeg\",\"quantity\":1},\"1\":{\"name\":\"French Toast\",\"price\":\"17000\",\"image\":\"1768565455_french-toast.jpeg\",\"quantity\":1}}','2026-01-17 12:04:36','2026-01-17 12:07:44'),(17,'202601170004','Varrel','6','0891239212',15000,0,15000,'pending','Tunai',NULL,NULL,NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"15000\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-01-17 12:34:28','2026-01-17 12:34:28'),(18,'202601260001','adalah','123','081199228833',47000,0,47000,'completed','QR Code',NULL,NULL,NULL,NULL,'{\"1\":{\"name\":\"French Toast\",\"price\":\"17000\",\"image\":\"1768565455_french-toast.jpeg\",\"quantity\":1},\"3\":{\"name\":\"French Fries\",\"price\":\"15000\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1},\"4\":{\"name\":\"Indomie Goreng \\/ Rebus\",\"price\":\"15000\",\"image\":\"1768565483_indomie-goreng-rebus.jpeg\",\"quantity\":1}}','2026-01-26 04:11:54','2026-01-26 04:12:41'),(19,'202602020001','12','12','08911228827',15000,0,15000,'pending','QR Code',NULL,NULL,NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"15000\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-02-01 22:10:50','2026-02-01 22:10:50'),(20,'202602020002','123','123','123',15000,0,15000,'pending','QR Code',NULL,NULL,NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"15000\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-02-01 22:19:02','2026-02-01 22:19:02'),(21,'202602020003','123','123','123',15000,0,15000,'pending','QR Code',NULL,NULL,NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"15000\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-02-01 22:25:48','2026-02-01 22:25:48'),(22,'202602020004','123','123','123',15000,0,15000,'pending','QR Code',NULL,NULL,NULL,NULL,'{\"4\":{\"name\":\"Indomie Goreng \\/ Rebus\",\"price\":\"15000\",\"image\":\"1768565483_indomie-goreng-rebus.jpeg\",\"quantity\":1}}','2026-02-01 22:30:30','2026-02-01 22:30:30'),(23,'202602020005','123','123','123',15000,0,15000,'pending','QR Code',NULL,NULL,NULL,NULL,'{\"4\":{\"name\":\"Indomie Goreng \\/ Rebus\",\"price\":\"15000\",\"image\":\"1768565483_indomie-goreng-rebus.jpeg\",\"quantity\":1}}','2026-02-01 22:36:44','2026-02-01 22:36:44'),(24,'202602020006','123','123','123',15000,0,15000,'pending','QR Code',NULL,NULL,NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"15000\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-02-01 22:46:59','2026-02-01 22:46:59'),(25,'202602020007','123','123','123',15000,0,15000,'pending','QR Code',NULL,NULL,NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"15000\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-02-01 22:49:52','2026-02-01 22:49:52'),(26,'202602020008','123','123','123',17000,0,17000,'cancelled','QR Code',NULL,NULL,NULL,NULL,'{\"1\":{\"name\":\"French Toast\",\"price\":\"17000\",\"image\":\"1768565455_french-toast.jpeg\",\"quantity\":1}}','2026-02-01 23:00:14','2026-02-01 23:20:15'),(27,'202602020009','123','123','123',15000,0,15000,'cancelled','QR Code',NULL,'f5c0dedd-6ee7-48f4-b153-d55d82b415f0',NULL,NULL,'{\"4\":{\"name\":\"Indomie Goreng \\/ Rebus\",\"price\":\"15000\",\"image\":\"1768565483_indomie-goreng-rebus.jpeg\",\"quantity\":1}}','2026-02-01 23:09:34','2026-02-01 23:19:58'),(28,'202602020010','123','123','123',1,0,1,'pending','QR Code',NULL,'b368ace1-214e-41c0-a779-83a9e9f876fc',NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"1\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-02-01 23:18:35','2026-02-01 23:18:36'),(29,'202602020011','123','123','123',1,0,1,'pending','QR Code',NULL,'02387397-8659-49f8-a0f3-8642a96c38a1',NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"1\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-02-01 23:21:05','2026-02-01 23:21:05'),(30,'202602020012','123','123','123',1,0,1,'pending','QR Code',NULL,'5fa03b38-9e2c-45ed-8ddf-facb2e9bb29f',NULL,NULL,'{\"4\":{\"name\":\"Indomie Goreng \\/ Rebus\",\"price\":\"1\",\"image\":\"1768565483_indomie-goreng-rebus.jpeg\",\"quantity\":1}}','2026-02-02 02:10:06','2026-02-02 02:10:08'),(31,'202602020013','123','123','123',1,0,1,'completed','QR Code',NULL,'81c29778-1f6b-451e-bed0-b2027b1643e5',NULL,NULL,'{\"3\":{\"name\":\"French Fries\",\"price\":\"1\",\"image\":\"1768565473_french-fries.jpeg\",\"quantity\":1}}','2026-02-02 02:10:38','2026-02-02 02:11:56');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'French Toast','french-toast','enak',1,'1768565455_french-toast.jpeg',1,1,'2026-01-16 03:29:41','2026-02-01 23:16:06'),(2,1,'No Limit Toast','no-limit-toast',NULL,1,'1768565464_no-limit-toast.jpeg',1,2,'2026-01-16 03:29:41','2026-02-01 23:16:06'),(3,1,'French Fries','french-fries',NULL,1,'1768565473_french-fries.jpeg',1,3,'2026-01-16 03:29:41','2026-02-01 23:16:06'),(4,1,'Indomie Goreng / Rebus','indomie-goreng-rebus',NULL,1,'1768565483_indomie-goreng-rebus.jpeg',1,4,'2026-01-16 03:29:41','2026-02-01 23:16:06'),(5,2,'No Limit Coffee','no-limit-coffee',NULL,1,'1768565643_no-limit-coffee.jpeg',1,1,'2026-01-16 03:29:41','2026-02-01 23:16:06'),(6,2,'Cappuccino','cappuccino',NULL,1,'1768565653_cappuccino.jpeg',1,2,'2026-01-16 03:29:41','2026-02-01 23:16:06'),(7,2,'Red Velvet','red-velvet',NULL,1,'1768565663_red-velvet.jpeg',1,3,'2026-01-16 03:29:41','2026-02-01 23:16:06'),(8,2,'Caramel Machiato','caramel-machiato',NULL,1,'1768565670_caramel-machiato.jpeg',1,4,'2026-01-16 03:29:41','2026-02-01 23:16:06');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('99uysmCUhebasqZJExtmHDDqbqb2xKYBmGDxBymf',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYTlnOUF2UzBZNnpmWjI5MFMzZVd5alRMT0gxU2hQOVhCWTZYMWIyeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51IjtzOjU6InJvdXRlIjtzOjQ6Im1lbnUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiY2FydCI7YToyOntpOjM7YTo0OntzOjQ6Im5hbWUiO3M6MTI6IkZyZW5jaCBGcmllcyI7czo1OiJwcmljZSI7czoxOiIxIjtzOjU6ImltYWdlIjtzOjI4OiIxNzY4NTY1NDczX2ZyZW5jaC1mcmllcy5qcGVnIjtzOjg6InF1YW50aXR5IjtpOjE7fWk6NDthOjQ6e3M6NDoibmFtZSI7czoyMjoiSW5kb21pZSBHb3JlbmcgLyBSZWJ1cyI7czo1OiJwcmljZSI7czoxOiIxIjtzOjU6ImltYWdlIjtzOjM2OiIxNzY4NTY1NDgzX2luZG9taWUtZ29yZW5nLXJlYnVzLmpwZWciO3M6ODoicXVhbnRpdHkiO2k6MTt9fX0=',1770007625);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
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
INSERT INTO `users` VALUES (1,'Admin Cafe','admin@gmail.com','admin',NULL,'$2y$12$I5QLZYWgpsLHPy4xBZXcxeCN2Cc1.Np3C6ItYSyGWmjwllSNrtWlW',NULL,'2026-01-16 03:59:43','2026-01-16 03:59:43');
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

-- Dump completed on 2026-02-06 13:36:00
