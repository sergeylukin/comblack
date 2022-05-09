-- MySQL dump 10.14  Distrib 5.5.60-MariaDB, for Linux (x86_64)
--
-- Host: localdb    Database: mastersu_sdbjwk
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `plk_commentmeta`
--

DROP TABLE IF EXISTS `plk_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_commentmeta`
--

LOCK TABLES `plk_commentmeta` WRITE;
/*!40000 ALTER TABLE `plk_commentmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_commentmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_comments`
--

DROP TABLE IF EXISTS `plk_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_comments`
--

LOCK TABLES `plk_comments` WRITE;
/*!40000 ALTER TABLE `plk_comments` DISABLE KEYS */;
INSERT INTO `plk_comments` VALUES (1,1,'מגיב וורדפרס','wapuu@wordpress.example','https://wordpress.org/','','2018-11-26 15:56:31','2018-11-26 13:56:31','היי, זו תגובה.\nכדי לשנות, לערוך, או למחוק תגובות, יש לגשת למסך התגובות בלוח הבקרה.\nצלמית המשתמש של המגיב מגיעה מתוך <a href=\"https://gravatar.com\">גראווטר</a>.',0,'1','','',0,0);
/*!40000 ALTER TABLE `plk_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_layerslider`
--

DROP TABLE IF EXISTS `plk_layerslider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_layerslider` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `author` int(10) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `data` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_c` int(10) NOT NULL,
  `date_m` int(10) NOT NULL,
  `schedule_start` int(10) NOT NULL DEFAULT '0',
  `schedule_end` int(10) NOT NULL DEFAULT '0',
  `flag_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `flag_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `flag_popup` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_layerslider`
--

LOCK TABLES `plk_layerslider` WRITE;
/*!40000 ALTER TABLE `plk_layerslider` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_layerslider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_layerslider_revisions`
--

DROP TABLE IF EXISTS `plk_layerslider_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_layerslider_revisions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `slider_id` int(10) NOT NULL,
  `author` int(10) NOT NULL DEFAULT '0',
  `data` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_c` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_layerslider_revisions`
--

LOCK TABLES `plk_layerslider_revisions` WRITE;
/*!40000 ALTER TABLE `plk_layerslider_revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_layerslider_revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_links`
--

DROP TABLE IF EXISTS `plk_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_links`
--

LOCK TABLES `plk_links` WRITE;
/*!40000 ALTER TABLE `plk_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_options`
--

DROP TABLE IF EXISTS `plk_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1543 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_options`
--

LOCK TABLES `plk_options` WRITE;
/*!40000 ALTER TABLE `plk_options` DISABLE KEYS */;
INSERT INTO `plk_options` VALUES (1,'siteurl','http://master.s485.upress.link','yes'),(2,'home','http://master.s485.upress.link','yes'),(3,'blogname','אתר וורדפרס חדש','yes'),(4,'blogdescription','אתר וורדפרס חדש','yes'),(5,'users_can_register','0','yes'),(6,'admin_email','yotamizakov@gmail.com','yes'),(7,'start_of_week','0','yes'),(8,'use_balanceTags','0','yes'),(9,'use_smilies','1','yes'),(10,'require_name_email','1','yes'),(11,'comments_notify','1','yes'),(12,'posts_per_rss','10','yes'),(13,'rss_use_excerpt','0','yes'),(14,'mailserver_url','mail.example.com','yes'),(15,'mailserver_login','login@example.com','yes'),(16,'mailserver_pass','password','yes'),(17,'mailserver_port','110','yes'),(18,'default_category','1','yes'),(19,'default_comment_status','open','yes'),(20,'default_ping_status','open','yes'),(21,'default_pingback_flag','1','yes'),(22,'posts_per_page','10','yes'),(23,'date_format','j בF Y','yes'),(24,'time_format','G:i','yes'),(25,'links_updated_date_format','j בF Y G:i','yes'),(26,'comment_moderation','0','yes'),(27,'moderation_notify','1','yes'),(28,'permalink_structure','/%year%/%monthnum%/%day%/%postname%/','yes'),(30,'hack_file','0','yes'),(31,'blog_charset','UTF-8','yes'),(32,'moderation_keys','','no'),(33,'active_plugins','a:7:{i:0;s:36:\"contact-form-7/wp-contact-form-7.php\";i:1;s:38:\"post-duplicator/m4c-postduplicator.php\";i:2;s:27:\"redirection/redirection.php\";i:3;s:53:\"simple-custom-post-order/simple-custom-post-order.php\";i:4;s:37:\"tinymce-advanced/tinymce-advanced.php\";i:5;s:17:\"wesafe/wesafe.php\";i:6;s:24:\"wordpress-seo/wp-seo.php\";}','yes'),(34,'category_base','','yes'),(35,'ping_sites','http://rpc.pingomatic.com/','yes'),(36,'comment_max_links','2','yes'),(37,'gmt_offset','0','yes'),(38,'default_email_category','1','yes'),(39,'recently_edited','','no'),(40,'template','enfold','yes'),(41,'stylesheet','enfold-child','yes'),(42,'comment_whitelist','1','yes'),(43,'blacklist_keys','','no'),(44,'comment_registration','0','yes'),(45,'html_type','text/html','yes'),(46,'use_trackback','0','yes'),(47,'default_role','subscriber','yes'),(48,'db_version','38590','yes'),(49,'uploads_use_yearmonth_folders','1','yes'),(50,'upload_path','','yes'),(51,'blog_public','1','yes'),(52,'default_link_category','2','yes'),(53,'show_on_front','posts','yes'),(54,'tag_base','','yes'),(55,'show_avatars','1','yes'),(56,'avatar_rating','G','yes'),(57,'upload_url_path','','yes'),(58,'thumbnail_size_w','80','yes'),(59,'thumbnail_size_h','80','yes'),(60,'thumbnail_crop','1','yes'),(61,'medium_size_w','300','yes'),(62,'medium_size_h','300','yes'),(63,'avatar_default','mystery','yes'),(64,'large_size_w','1030','yes'),(65,'large_size_h','1030','yes'),(66,'image_default_link_type','none','yes'),(67,'image_default_size','','yes'),(68,'image_default_align','','yes'),(69,'close_comments_for_old_posts','0','yes'),(70,'close_comments_days_old','14','yes'),(71,'thread_comments','1','yes'),(72,'thread_comments_depth','5','yes'),(73,'page_comments','0','yes'),(74,'comments_per_page','50','yes'),(75,'default_comments_page','newest','yes'),(76,'comment_order','asc','yes'),(77,'sticky_posts','a:0:{}','yes'),(78,'widget_categories','a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),(79,'widget_text','a:0:{}','yes'),(80,'widget_rss','a:0:{}','yes'),(81,'uninstall_plugins','a:4:{s:126:\"home/miasupre/domains/mia.s485.upress.link/public_html/wp-content/themes/enfold/config-layerslider/LayerSlider/layerslider.php\";s:29:\"layerslider_uninstall_scripts\";s:53:\"simple-custom-post-order/simple-custom-post-order.php\";s:18:\"scporder_uninstall\";s:27:\"redirection/redirection.php\";a:2:{i:0;s:17:\"Redirection_Admin\";i:1;s:16:\"plugin_uninstall\";}s:17:\"wesafe/wesafe.php\";s:24:\"wesafe_deactivate_plugin\";}','no'),(82,'timezone_string','Asia/Jerusalem','yes'),(83,'page_for_posts','0','yes'),(84,'page_on_front','0','yes'),(85,'default_post_format','0','yes'),(86,'link_manager_enabled','0','yes'),(87,'finished_splitting_shared_terms','1','yes'),(88,'site_icon','0','yes'),(89,'medium_large_size_w','768','yes'),(90,'medium_large_size_h','0','yes'),(91,'wp_page_for_privacy_policy','3','yes'),(92,'show_comments_cookies_opt_in','0','yes'),(93,'initial_db_version','38590','yes'),(94,'plk_user_roles','a:7:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:62:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:20:\"wpseo_manage_options\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:35:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:15:\"wpseo_bulk_edit\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}s:13:\"wpseo_manager\";a:2:{s:4:\"name\";s:11:\"SEO Manager\";s:12:\"capabilities\";a:37:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:15:\"wpseo_bulk_edit\";b:1;s:28:\"wpseo_edit_advanced_metadata\";b:1;s:20:\"wpseo_manage_options\";b:1;}}s:12:\"wpseo_editor\";a:2:{s:4:\"name\";s:10:\"SEO Editor\";s:12:\"capabilities\";a:36:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:15:\"wpseo_bulk_edit\";b:1;s:28:\"wpseo_edit_advanced_metadata\";b:1;}}}','yes'),(95,'fresh_site','1','yes'),(96,'widget_search','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),(97,'widget_recent-posts','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),(98,'widget_recent-comments','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),(99,'widget_archives','a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),(100,'widget_meta','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),(101,'sidebars_widgets','a:9:{s:19:\"wp_inactive_widgets\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"av_everywhere\";a:0:{}s:7:\"av_blog\";a:0:{}s:8:\"av_pages\";a:0:{}s:11:\"av_footer_1\";a:0:{}s:11:\"av_footer_2\";a:0:{}s:11:\"av_footer_3\";a:0:{}s:11:\"av_footer_4\";a:0:{}s:13:\"array_version\";i:3;}','yes'),(102,'widget_pages','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(103,'widget_calendar','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(104,'widget_media_audio','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(105,'widget_media_image','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(106,'widget_media_gallery','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(107,'widget_media_video','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(108,'widget_tag_cloud','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(109,'widget_nav_menu','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(110,'widget_custom_html','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(111,'cron','a:5:{i:1552287391;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1552312591;a:3:{s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1552314672;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1552314752;a:2:{s:22:\"redirection_log_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:19:\"wpseo-reindex-links\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}s:7:\"version\";i:2;}','yes'),(112,'theme_mods_twentyseventeen','a:2:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1543242683;s:4:\"data\";a:4:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";a:0:{}}}}','yes'),(127,'can_compress_scripts','0','no'),(138,'current_theme','Enfold Child','yes'),(139,'theme_mods_enfold-child','a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;}','yes'),(140,'theme_switched','','yes'),(141,'widget_newsbox','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(142,'widget_portfoliobox','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(143,'widget_avia_socialcount','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(144,'widget_avia_combo_widget','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(145,'widget_avia_partner_widget','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(146,'widget_avia_google_maps','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(147,'widget_avia_fb_likebox','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(148,'widget_avia-instagram-feed','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(149,'widget_avia_mailchimp_widget','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),(150,'ls-plugin-version','6.5.1','yes'),(151,'ls-db-version','6.5.0','yes'),(152,'ls-installed','1','yes'),(153,'ls-google-fonts','a:0:{}','yes'),(154,'ls-date-installed','1543242683','yes'),(155,'enfold_child_layerslider_activated','1','yes'),(156,'ls-show-support-notice','0','yes'),(157,'enfoldchild_initial_version','4.1.2','yes'),(158,'enfoldchild_fixed_random','9','yes'),(159,'shop_catalog_image_size','a:3:{s:5:\"width\";i:450;s:6:\"height\";i:450;s:4:\"crop\";b:1;}','yes'),(160,'shop_single_image_size','a:3:{s:5:\"width\";i:450;s:6:\"height\";i:999;s:4:\"crop\";b:0;}','yes'),(161,'shop_thumbnail_image_size','a:3:{s:5:\"width\";i:120;s:6:\"height\";i:120;s:4:\"crop\";b:1;}','yes'),(162,'avia_woocommerce_column_count','3','yes'),(163,'avia_woocommerce_product_count','15','yes'),(164,'woocommerce_single_image_crop','no','yes'),(165,'avia_permalink_settings','a:0:{}','yes'),(166,'avia_options_enfold_child','a:1:{s:4:\"avia\";a:167:{s:9:\"frontpage\";s:0:\"\";s:9:\"undefined\";s:16:\"lock_alb::{true}\";s:8:\"blogpage\";s:0:\"\";s:4:\"logo\";s:0:\"\";s:7:\"favicon\";s:0:\"\";s:9:\"preloader\";s:8:\"disabled\";s:21:\"preloader_transitions\";s:21:\"preloader_transitions\";s:14:\"preloader_logo\";s:0:\"\";s:15:\"lightbox_active\";s:15:\"lightbox_active\";s:16:\"color-body_style\";s:9:\"stretched\";s:17:\"color-frame_width\";s:2:\"20\";s:15:\"header_position\";s:10:\"header_top\";s:20:\"layout_align_content\";s:20:\"content_align_center\";s:18:\"sidebarmenu_sticky\";s:18:\"conditional_sticky\";s:19:\"sidebarmenu_widgets\";s:0:\"\";s:18:\"sidebarmenu_social\";s:8:\"disabled\";s:17:\"responsive_active\";s:17:\"responsive_active\";s:15:\"responsive_size\";s:6:\"1310px\";s:13:\"content_width\";s:2:\"73\";s:14:\"combined_width\";s:3:\"100\";s:12:\"color_scheme\";s:4:\"Blue\";s:24:\"colorset-header_color-bg\";s:7:\"#ffffff\";s:25:\"colorset-header_color-bg2\";s:7:\"#f8f8f8\";s:29:\"colorset-header_color-primary\";s:7:\"#719430\";s:31:\"colorset-header_color-secondary\";s:7:\"#8bbd2d\";s:27:\"colorset-header_color-color\";s:7:\"#719430\";s:26:\"colorset-header_color-meta\";s:7:\"#719430\";s:29:\"colorset-header_color-heading\";s:7:\"#666666\";s:28:\"colorset-header_color-border\";s:7:\"#e1e1e1\";s:25:\"colorset-header_color-img\";s:0:\"\";s:33:\"colorset-header_color-customimage\";s:0:\"\";s:25:\"colorset-header_color-pos\";s:8:\"top left\";s:28:\"colorset-header_color-repeat\";s:9:\"no-repeat\";s:28:\"colorset-header_color-attach\";s:6:\"scroll\";s:22:\"colorset-main_color-bg\";s:7:\"#ffffff\";s:23:\"colorset-main_color-bg2\";s:7:\"#f8f8f8\";s:27:\"colorset-main_color-primary\";s:7:\"#719430\";s:29:\"colorset-main_color-secondary\";s:7:\"#8bba34\";s:25:\"colorset-main_color-color\";s:7:\"#719430\";s:24:\"colorset-main_color-meta\";s:7:\"#719430\";s:27:\"colorset-main_color-heading\";s:7:\"#666666\";s:26:\"colorset-main_color-border\";s:7:\"#e1e1e1\";s:23:\"colorset-main_color-img\";s:0:\"\";s:31:\"colorset-main_color-customimage\";s:0:\"\";s:23:\"colorset-main_color-pos\";s:8:\"top left\";s:26:\"colorset-main_color-repeat\";s:9:\"no-repeat\";s:26:\"colorset-main_color-attach\";s:6:\"scroll\";s:27:\"colorset-alternate_color-bg\";s:7:\"#ffffff\";s:28:\"colorset-alternate_color-bg2\";s:7:\"#f8f8f8\";s:32:\"colorset-alternate_color-primary\";s:7:\"#719430\";s:34:\"colorset-alternate_color-secondary\";s:7:\"#8bba34\";s:30:\"colorset-alternate_color-color\";s:7:\"#719430\";s:29:\"colorset-alternate_color-meta\";s:7:\"#719430\";s:32:\"colorset-alternate_color-heading\";s:7:\"#666666\";s:31:\"colorset-alternate_color-border\";s:7:\"#e1e1e1\";s:28:\"colorset-alternate_color-img\";s:0:\"\";s:36:\"colorset-alternate_color-customimage\";s:0:\"\";s:28:\"colorset-alternate_color-pos\";s:8:\"top left\";s:31:\"colorset-alternate_color-repeat\";s:9:\"no-repeat\";s:31:\"colorset-alternate_color-attach\";s:6:\"scroll\";s:24:\"colorset-footer_color-bg\";s:7:\"#ffffff\";s:25:\"colorset-footer_color-bg2\";s:7:\"#f8f8f8\";s:29:\"colorset-footer_color-primary\";s:7:\"#719430\";s:31:\"colorset-footer_color-secondary\";s:7:\"#8bba34\";s:27:\"colorset-footer_color-color\";s:7:\"#719430\";s:26:\"colorset-footer_color-meta\";s:7:\"#719430\";s:29:\"colorset-footer_color-heading\";s:7:\"#719430\";s:28:\"colorset-footer_color-border\";s:7:\"#e1e1e1\";s:25:\"colorset-footer_color-img\";s:0:\"\";s:33:\"colorset-footer_color-customimage\";s:0:\"\";s:25:\"colorset-footer_color-pos\";s:8:\"top left\";s:28:\"colorset-footer_color-repeat\";s:9:\"no-repeat\";s:28:\"colorset-footer_color-attach\";s:6:\"scroll\";s:24:\"colorset-socket_color-bg\";s:7:\"#ffffff\";s:25:\"colorset-socket_color-bg2\";s:7:\"#f8f8f8\";s:29:\"colorset-socket_color-primary\";s:7:\"#719430\";s:31:\"colorset-socket_color-secondary\";s:7:\"#8bba34\";s:27:\"colorset-socket_color-color\";s:7:\"#719430\";s:26:\"colorset-socket_color-meta\";s:7:\"#719430\";s:29:\"colorset-socket_color-heading\";s:7:\"#666666\";s:28:\"colorset-socket_color-border\";s:7:\"#e1e1e1\";s:25:\"colorset-socket_color-img\";s:0:\"\";s:33:\"colorset-socket_color-customimage\";s:0:\"\";s:25:\"colorset-socket_color-pos\";s:8:\"top left\";s:28:\"colorset-socket_color-repeat\";s:9:\"no-repeat\";s:28:\"colorset-socket_color-attach\";s:6:\"scroll\";s:16:\"color-body_color\";s:7:\"#eeeeee\";s:14:\"color-body_img\";s:0:\"\";s:22:\"color-body_customimage\";s:0:\"\";s:14:\"color-body_pos\";s:8:\"top left\";s:17:\"color-body_repeat\";s:9:\"no-repeat\";s:17:\"color-body_attach\";s:6:\"scroll\";s:14:\"google_webfont\";s:0:\"\";s:12:\"default_font\";s:32:\"Helvetica-Neue,Helvetica-websave\";s:23:\"color-default_font_size\";s:0:\"\";s:9:\"quick_css\";s:0:\"\";s:12:\"menu_display\";s:0:\"\";s:24:\"header_mobile_activation\";s:17:\"mobile_menu_phone\";s:18:\"header_menu_border\";s:0:\"\";s:17:\"header_searchicon\";s:17:\"header_searchicon\";s:18:\"submenu_visibility\";s:0:\"\";s:13:\"submenu_clone\";s:18:\"av-submenu-noclone\";s:11:\"burger_size\";s:0:\"\";s:13:\"overlay_style\";s:39:\"av-overlay-side av-overlay-side-classic\";s:12:\"burger_color\";s:0:\"\";s:19:\"burger_flyout_width\";s:5:\"350px\";s:13:\"header_layout\";s:36:\"logo_left main_nav_header menu_right\";s:11:\"header_size\";s:4:\"slim\";s:18:\"header_custom_size\";s:3:\"150\";s:12:\"header_style\";s:0:\"\";s:16:\"header_title_bar\";s:20:\"title_bar_breadcrumb\";s:13:\"header_sticky\";s:13:\"header_sticky\";s:16:\"header_shrinking\";s:16:\"header_shrinking\";s:18:\"header_unstick_top\";s:8:\"disabled\";s:14:\"header_stretch\";s:8:\"disabled\";s:13:\"header_social\";s:0:\"\";s:21:\"header_secondary_menu\";s:0:\"\";s:19:\"header_phone_active\";s:0:\"\";s:5:\"phone\";s:0:\"\";s:23:\"header_replacement_logo\";s:0:\"\";s:23:\"header_replacement_menu\";s:0:\"\";s:14:\"archive_layout\";s:13:\"sidebar_right\";s:11:\"blog_layout\";s:13:\"sidebar_right\";s:13:\"single_layout\";s:13:\"sidebar_right\";s:11:\"page_layout\";s:13:\"sidebar_right\";s:19:\"smartphones_sidebar\";s:8:\"disabled\";s:16:\"page_nesting_nav\";s:16:\"page_nesting_nav\";s:15:\"sidebar_styling\";s:0:\"\";s:22:\"display_widgets_socket\";s:3:\"all\";s:14:\"footer_columns\";s:1:\"4\";s:9:\"copyright\";s:0:\"\";s:13:\"footer_social\";s:8:\"disabled\";s:15:\"preview_disable\";s:8:\"disabled\";s:17:\"developer_options\";s:8:\"disabled\";s:8:\"lock_alb\";s:8:\"disabled\";s:19:\"lock_alb_for_admins\";s:8:\"disabled\";s:6:\"markup\";s:0:\"\";s:17:\"blog_global_style\";s:0:\"\";s:10:\"blog_style\";s:12:\"single-small\";s:16:\"disable_post_nav\";s:8:\"disabled\";s:17:\"single_post_style\";s:10:\"single-big\";s:27:\"single_post_related_entries\";s:24:\"av-related-style-tooltip\";s:16:\"blog-meta-author\";s:16:\"blog-meta-author\";s:18:\"blog-meta-comments\";s:18:\"blog-meta-comments\";s:18:\"blog-meta-category\";s:18:\"blog-meta-category\";s:14:\"blog-meta-date\";s:14:\"blog-meta-date\";s:19:\"blog-meta-html-info\";s:19:\"blog-meta-html-info\";s:13:\"blog-meta-tag\";s:13:\"blog-meta-tag\";s:14:\"share_facebook\";s:14:\"share_facebook\";s:13:\"share_twitter\";s:13:\"share_twitter\";s:15:\"share_pinterest\";s:15:\"share_pinterest\";s:11:\"share_gplus\";s:11:\"share_gplus\";s:12:\"share_reddit\";s:12:\"share_reddit\";s:14:\"share_linkedin\";s:14:\"share_linkedin\";s:12:\"share_tumblr\";s:12:\"share_tumblr\";s:8:\"share_vk\";s:8:\"share_vk\";s:10:\"share_mail\";s:10:\"share_mail\";s:12:\"social_icons\";a:2:{i:0;a:2:{s:11:\"social_icon\";s:7:\"twitter\";s:16:\"social_icon_link\";s:25:\"http://twitter.com/kriesi\";}i:1;a:2:{s:11:\"social_icon\";s:8:\"dribbble\";s:16:\"social_icon_link\";s:26:\"http://dribbble.com/kriesi\";}}s:13:\"mailchimp_api\";s:0:\"\";s:9:\"analytics\";s:0:\"\";s:8:\"gmap_api\";s:0:\"\";s:17:\"avia-nonce-import\";s:10:\"7ab041e50c\";s:24:\"avia-nonce-import-parent\";s:10:\"ae3c047c13\";s:18:\"config_file_upload\";s:0:\"\";s:15:\"iconfont_upload\";s:0:\"\";s:16:\"updates_username\";s:0:\"\";s:15:\"updates_api_key\";s:0:\"\";}}','yes'),(167,'Enfold_version','4.1.2','yes'),(168,'avia_stylesheet_dir_writableenfold_child','true','yes'),(169,'avia_stylesheet_existsenfold_child','true','yes'),(170,'avia_stylesheet_dynamic_versionenfold_child','5bfc03cf7e68a','yes'),(171,'enfold_child_woo_settings_enabled','1','yes'),(172,'avia_rewrite_flush','1','yes'),(173,'layerslider_update_info','O:8:\"stdClass\":1:{s:7:\"checked\";i:1543242710;}','yes'),(176,'recently_activated','a:0:{}','yes'),(177,'wpcf7','a:1:{s:7:\"version\";s:3:\"3.2\";}','yes'),(178,'redirection_version','2.4','yes'),(179,'redirection_options','a:16:{s:7:\"support\";b:0;s:5:\"token\";s:32:\"1129509b2ab454f23b407abbc3a06ac9\";s:12:\"monitor_post\";i:0;s:13:\"monitor_types\";a:0:{}s:19:\"associated_redirect\";s:0:\"\";s:11:\"auto_target\";s:0:\"\";s:15:\"expire_redirect\";i:7;s:10:\"expire_404\";i:7;s:7:\"modules\";a:0:{}s:10:\"newsletter\";b:0;s:14:\"redirect_cache\";i:1;s:10:\"ip_logging\";i:1;s:13:\"last_group_id\";i:1;s:8:\"rest_api\";b:0;s:5:\"https\";b:0;s:7:\"version\";s:5:\"3.6.3\";}','yes'),(180,'scporder_install','1','yes'),(181,'tadv_settings','a:6:{s:7:\"options\";s:15:\"menubar,advlist\";s:9:\"toolbar_1\";s:106:\"formatselect,bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,link,unlink,undo,redo\";s:9:\"toolbar_2\";s:103:\"fontselect,fontsizeselect,outdent,indent,pastetext,removeformat,charmap,wp_more,forecolor,table,wp_help\";s:9:\"toolbar_3\";s:0:\"\";s:9:\"toolbar_4\";s:0:\"\";s:7:\"plugins\";s:104:\"anchor,code,insertdatetime,nonbreaking,print,searchreplace,table,visualblocks,visualchars,advlist,wptadv\";}','yes'),(182,'tadv_admin_settings','a:1:{s:7:\"options\";a:0:{}}','yes'),(183,'tadv_version','4000','yes'),(184,'wpseo','a:19:{s:15:\"ms_defaults_set\";b:0;s:7:\"version\";s:3:\"9.2\";s:20:\"disableadvanced_meta\";b:1;s:19:\"onpage_indexability\";b:1;s:11:\"baiduverify\";s:0:\"\";s:12:\"googleverify\";s:0:\"\";s:8:\"msverify\";s:0:\"\";s:12:\"yandexverify\";s:0:\"\";s:9:\"site_type\";s:0:\"\";s:20:\"has_multiple_authors\";s:0:\"\";s:16:\"environment_type\";s:0:\"\";s:23:\"content_analysis_active\";b:1;s:23:\"keyword_analysis_active\";b:1;s:21:\"enable_admin_bar_menu\";b:1;s:26:\"enable_cornerstone_content\";b:1;s:18:\"enable_xml_sitemap\";b:1;s:24:\"enable_text_link_counter\";b:1;s:22:\"show_onboarding_notice\";b:1;s:18:\"first_activated_on\";i:1543242752;}','yes'),(185,'wpseo_titles','a:84:{s:10:\"title_test\";i:0;s:17:\"forcerewritetitle\";b:0;s:9:\"separator\";s:7:\"sc-dash\";s:16:\"title-home-wpseo\";s:42:\"%%sitename%% %%page%% %%sep%% %%sitedesc%%\";s:18:\"title-author-wpseo\";s:41:\"%%name%%, Author at %%sitename%% %%page%%\";s:19:\"title-archive-wpseo\";s:38:\"%%date%% %%page%% %%sep%% %%sitename%%\";s:18:\"title-search-wpseo\";s:63:\"You searched for %%searchphrase%% %%page%% %%sep%% %%sitename%%\";s:15:\"title-404-wpseo\";s:35:\"Page not found %%sep%% %%sitename%%\";s:19:\"metadesc-home-wpseo\";s:0:\"\";s:21:\"metadesc-author-wpseo\";s:0:\"\";s:22:\"metadesc-archive-wpseo\";s:0:\"\";s:9:\"rssbefore\";s:0:\"\";s:8:\"rssafter\";s:53:\"The post %%POSTLINK%% appeared first on %%BLOGLINK%%.\";s:20:\"noindex-author-wpseo\";b:0;s:28:\"noindex-author-noposts-wpseo\";b:1;s:21:\"noindex-archive-wpseo\";b:1;s:14:\"disable-author\";b:0;s:12:\"disable-date\";b:0;s:19:\"disable-post_format\";b:0;s:18:\"disable-attachment\";b:1;s:23:\"is-media-purge-relevant\";b:0;s:20:\"breadcrumbs-404crumb\";s:25:\"Error 404: Page not found\";s:29:\"breadcrumbs-display-blog-page\";b:1;s:20:\"breadcrumbs-boldlast\";b:0;s:25:\"breadcrumbs-archiveprefix\";s:12:\"Archives for\";s:18:\"breadcrumbs-enable\";b:0;s:16:\"breadcrumbs-home\";s:4:\"Home\";s:18:\"breadcrumbs-prefix\";s:0:\"\";s:24:\"breadcrumbs-searchprefix\";s:16:\"You searched for\";s:15:\"breadcrumbs-sep\";s:7:\"&raquo;\";s:12:\"website_name\";s:0:\"\";s:11:\"person_name\";s:0:\"\";s:22:\"alternate_website_name\";s:0:\"\";s:12:\"company_logo\";s:0:\"\";s:12:\"company_name\";s:0:\"\";s:17:\"company_or_person\";s:0:\"\";s:17:\"stripcategorybase\";b:0;s:10:\"title-post\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:13:\"metadesc-post\";s:0:\"\";s:12:\"noindex-post\";b:0;s:13:\"showdate-post\";b:0;s:23:\"display-metabox-pt-post\";b:1;s:23:\"post_types-post-maintax\";i:0;s:10:\"title-page\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:13:\"metadesc-page\";s:0:\"\";s:12:\"noindex-page\";b:0;s:13:\"showdate-page\";b:0;s:23:\"display-metabox-pt-page\";b:1;s:23:\"post_types-page-maintax\";i:0;s:16:\"title-attachment\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:19:\"metadesc-attachment\";s:0:\"\";s:18:\"noindex-attachment\";b:0;s:19:\"showdate-attachment\";b:0;s:29:\"display-metabox-pt-attachment\";b:1;s:29:\"post_types-attachment-maintax\";i:0;s:25:\"title-avia_framework_post\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:28:\"metadesc-avia_framework_post\";s:0:\"\";s:27:\"noindex-avia_framework_post\";b:0;s:28:\"showdate-avia_framework_post\";b:0;s:38:\"display-metabox-pt-avia_framework_post\";b:1;s:38:\"post_types-avia_framework_post-maintax\";i:0;s:15:\"title-portfolio\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:18:\"metadesc-portfolio\";s:0:\"\";s:17:\"noindex-portfolio\";b:0;s:18:\"showdate-portfolio\";b:0;s:28:\"display-metabox-pt-portfolio\";b:1;s:28:\"post_types-portfolio-maintax\";i:0;s:18:\"title-tax-category\";s:53:\"%%term_title%% Archives %%page%% %%sep%% %%sitename%%\";s:21:\"metadesc-tax-category\";s:0:\"\";s:28:\"display-metabox-tax-category\";b:1;s:20:\"noindex-tax-category\";b:0;s:18:\"title-tax-post_tag\";s:53:\"%%term_title%% Archives %%page%% %%sep%% %%sitename%%\";s:21:\"metadesc-tax-post_tag\";s:0:\"\";s:28:\"display-metabox-tax-post_tag\";b:1;s:20:\"noindex-tax-post_tag\";b:0;s:21:\"title-tax-post_format\";s:53:\"%%term_title%% Archives %%page%% %%sep%% %%sitename%%\";s:24:\"metadesc-tax-post_format\";s:0:\"\";s:31:\"display-metabox-tax-post_format\";b:1;s:23:\"noindex-tax-post_format\";b:1;s:27:\"title-tax-portfolio_entries\";s:53:\"%%term_title%% Archives %%page%% %%sep%% %%sitename%%\";s:30:\"metadesc-tax-portfolio_entries\";s:0:\"\";s:37:\"display-metabox-tax-portfolio_entries\";b:1;s:29:\"noindex-tax-portfolio_entries\";b:0;s:35:\"taxonomy-portfolio_entries-ptparent\";i:0;}','yes'),(186,'wpseo_social','a:20:{s:13:\"facebook_site\";s:0:\"\";s:13:\"instagram_url\";s:0:\"\";s:12:\"linkedin_url\";s:0:\"\";s:11:\"myspace_url\";s:0:\"\";s:16:\"og_default_image\";s:0:\"\";s:19:\"og_default_image_id\";s:0:\"\";s:18:\"og_frontpage_title\";s:0:\"\";s:17:\"og_frontpage_desc\";s:0:\"\";s:18:\"og_frontpage_image\";s:0:\"\";s:21:\"og_frontpage_image_id\";s:0:\"\";s:9:\"opengraph\";b:1;s:13:\"pinterest_url\";s:0:\"\";s:15:\"pinterestverify\";s:0:\"\";s:14:\"plus-publisher\";s:0:\"\";s:7:\"twitter\";b:1;s:12:\"twitter_site\";s:0:\"\";s:17:\"twitter_card_type\";s:19:\"summary_large_image\";s:11:\"youtube_url\";s:0:\"\";s:15:\"google_plus_url\";s:0:\"\";s:10:\"fbadminapp\";s:0:\"\";}','yes'),(187,'wpseo_flush_rewrite','1','yes'),(188,'_transient_timeout_wpseo_link_table_inaccessible','1574778752','no'),(189,'_transient_wpseo_link_table_inaccessible','0','no'),(190,'_transient_timeout_wpseo_meta_table_inaccessible','1574778752','no'),(191,'_transient_wpseo_meta_table_inaccessible','0','no'),(193,'mtphr_post_duplicator_settings','','yes'),(194,'rewrite_rules','a:132:{s:19:\"sitemap_index\\.xml$\";s:19:\"index.php?sitemap=1\";s:31:\"([^/]+?)-sitemap([0-9]+)?\\.xml$\";s:51:\"index.php?sitemap=$matches[1]&sitemap_n=$matches[2]\";s:24:\"([a-z]+)?-?sitemap\\.xsl$\";s:25:\"index.php?xsl=$matches[1]\";s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:46:\"wpcf7_contact_form/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:56:\"wpcf7_contact_form/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:76:\"wpcf7_contact_form/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:71:\"wpcf7_contact_form/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:71:\"wpcf7_contact_form/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:52:\"wpcf7_contact_form/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:35:\"wpcf7_contact_form/([^/]+)/embed/?$\";s:51:\"index.php?wpcf7_contact_form=$matches[1]&embed=true\";s:39:\"wpcf7_contact_form/([^/]+)/trackback/?$\";s:45:\"index.php?wpcf7_contact_form=$matches[1]&tb=1\";s:47:\"wpcf7_contact_form/([^/]+)/page/?([0-9]{1,})/?$\";s:58:\"index.php?wpcf7_contact_form=$matches[1]&paged=$matches[2]\";s:54:\"wpcf7_contact_form/([^/]+)/comment-page-([0-9]{1,})/?$\";s:58:\"index.php?wpcf7_contact_form=$matches[1]&cpage=$matches[2]\";s:43:\"wpcf7_contact_form/([^/]+)(?:/([0-9]+))?/?$\";s:57:\"index.php?wpcf7_contact_form=$matches[1]&page=$matches[2]\";s:35:\"wpcf7_contact_form/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:45:\"wpcf7_contact_form/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:65:\"wpcf7_contact_form/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:60:\"wpcf7_contact_form/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:60:\"wpcf7_contact_form/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:41:\"wpcf7_contact_form/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:42:\"portfolio-item/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:52:\"portfolio-item/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:72:\"portfolio-item/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:67:\"portfolio-item/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:67:\"portfolio-item/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:48:\"portfolio-item/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:31:\"portfolio-item/([^/]+)/embed/?$\";s:42:\"index.php?portfolio=$matches[1]&embed=true\";s:35:\"portfolio-item/([^/]+)/trackback/?$\";s:36:\"index.php?portfolio=$matches[1]&tb=1\";s:43:\"portfolio-item/([^/]+)/page/?([0-9]{1,})/?$\";s:49:\"index.php?portfolio=$matches[1]&paged=$matches[2]\";s:50:\"portfolio-item/([^/]+)/comment-page-([0-9]{1,})/?$\";s:49:\"index.php?portfolio=$matches[1]&cpage=$matches[2]\";s:39:\"portfolio-item/([^/]+)(?:/([0-9]+))?/?$\";s:48:\"index.php?portfolio=$matches[1]&page=$matches[2]\";s:31:\"portfolio-item/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:41:\"portfolio-item/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:61:\"portfolio-item/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:56:\"portfolio-item/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:56:\"portfolio-item/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:37:\"portfolio-item/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:58:\"portfolio_entries/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:56:\"index.php?portfolio_entries=$matches[1]&feed=$matches[2]\";s:53:\"portfolio_entries/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:56:\"index.php?portfolio_entries=$matches[1]&feed=$matches[2]\";s:34:\"portfolio_entries/([^/]+)/embed/?$\";s:50:\"index.php?portfolio_entries=$matches[1]&embed=true\";s:46:\"portfolio_entries/([^/]+)/page/?([0-9]{1,})/?$\";s:57:\"index.php?portfolio_entries=$matches[1]&paged=$matches[2]\";s:28:\"portfolio_entries/([^/]+)/?$\";s:39:\"index.php?portfolio_entries=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:58:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:68:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:88:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:83:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:64:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:53:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$\";s:91:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$\";s:85:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1\";s:77:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]\";s:65:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]\";s:72:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$\";s:98:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]\";s:61:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$\";s:97:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]\";s:47:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:57:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:77:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:72:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:53:\"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]\";s:51:\"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]\";s:38:\"([0-9]{4})/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&cpage=$matches[2]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";}','yes'),(409,'auto_core_update_notified','a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:21:\"yotamizakov@gmail.com\";s:7:\"version\";s:5:\"4.9.9\";s:9:\"timestamp\";i:1544708257;}','no'),(1127,'_site_transient_update_core','O:8:\"stdClass\":4:{s:7:\"updates\";a:4:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:7:\"upgrade\";s:8:\"download\";s:57:\"https://downloads.wordpress.org/release/wordpress-5.1.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:57:\"https://downloads.wordpress.org/release/wordpress-5.1.zip\";s:10:\"no_content\";s:68:\"https://downloads.wordpress.org/release/wordpress-5.1-no-content.zip\";s:11:\"new_bundled\";s:69:\"https://downloads.wordpress.org/release/wordpress-5.1-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:3:\"5.1\";s:7:\"version\";s:3:\"5.1\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.0\";s:15:\"partial_version\";s:0:\"\";}i:1;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:57:\"https://downloads.wordpress.org/release/wordpress-5.1.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:57:\"https://downloads.wordpress.org/release/wordpress-5.1.zip\";s:10:\"no_content\";s:68:\"https://downloads.wordpress.org/release/wordpress-5.1-no-content.zip\";s:11:\"new_bundled\";s:69:\"https://downloads.wordpress.org/release/wordpress-5.1-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:3:\"5.1\";s:7:\"version\";s:3:\"5.1\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.0\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:2;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.0.3.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.0.3.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.0.3-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.0.3-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.0.3\";s:7:\"version\";s:5:\"5.0.3\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.0\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}i:3;O:8:\"stdClass\":11:{s:8:\"response\";s:10:\"autoupdate\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.0.2.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-5.0.2.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-5.0.2-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-5.0.2-new-bundled.zip\";s:7:\"partial\";b:0;s:8:\"rollback\";b:0;}s:7:\"current\";s:5:\"5.0.2\";s:7:\"version\";s:5:\"5.0.2\";s:11:\"php_version\";s:5:\"5.2.4\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.0\";s:15:\"partial_version\";s:0:\"\";s:9:\"new_files\";s:1:\"1\";}}s:12:\"last_checked\";i:1552287156;s:15:\"version_checked\";s:5:\"4.9.9\";s:12:\"translations\";a:0:{}}','no'),(1538,'_site_transient_timeout_theme_roots','1552288954','no'),(1539,'_site_transient_theme_roots','a:5:{s:12:\"enfold-child\";s:7:\"/themes\";s:6:\"enfold\";s:7:\"/themes\";s:13:\"twentyfifteen\";s:7:\"/themes\";s:15:\"twentyseventeen\";s:7:\"/themes\";s:13:\"twentysixteen\";s:7:\"/themes\";}','no'),(1541,'_site_transient_update_themes','O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1552287158;s:7:\"checked\";a:5:{s:12:\"enfold-child\";s:3:\"1.0\";s:6:\"enfold\";s:5:\"4.1.2\";s:13:\"twentyfifteen\";s:3:\"2.0\";s:15:\"twentyseventeen\";s:3:\"1.7\";s:13:\"twentysixteen\";s:3:\"1.5\";}s:8:\"response\";a:3:{s:13:\"twentyfifteen\";a:4:{s:5:\"theme\";s:13:\"twentyfifteen\";s:11:\"new_version\";s:3:\"2.4\";s:3:\"url\";s:43:\"https://wordpress.org/themes/twentyfifteen/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/theme/twentyfifteen.2.4.zip\";}s:15:\"twentyseventeen\";a:4:{s:5:\"theme\";s:15:\"twentyseventeen\";s:11:\"new_version\";s:3:\"2.1\";s:3:\"url\";s:45:\"https://wordpress.org/themes/twentyseventeen/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/theme/twentyseventeen.2.1.zip\";}s:13:\"twentysixteen\";a:4:{s:5:\"theme\";s:13:\"twentysixteen\";s:11:\"new_version\";s:3:\"1.9\";s:3:\"url\";s:43:\"https://wordpress.org/themes/twentysixteen/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/theme/twentysixteen.1.9.zip\";}}s:12:\"translations\";a:0:{}}','no'),(1542,'_site_transient_update_plugins','O:8:\"stdClass\":4:{s:12:\"last_checked\";i:1552287158;s:8:\"response\";a:5:{s:19:\"akismet/akismet.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:5:\"4.1.1\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:56:\"https://downloads.wordpress.org/plugin/akismet.4.1.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:59:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=969272\";s:2:\"1x\";s:59:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=969272\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/akismet/assets/banner-772x250.jpg?rev=479904\";}s:11:\"banners_rtl\";a:0:{}s:6:\"tested\";s:3:\"5.1\";s:12:\"requires_php\";b:0;s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:27:\"redirection/redirection.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:25:\"w.org/plugins/redirection\";s:4:\"slug\";s:11:\"redirection\";s:6:\"plugin\";s:27:\"redirection/redirection.php\";s:11:\"new_version\";s:5:\"3.7.3\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/redirection/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/redirection.3.7.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/redirection/assets/icon-256x256.jpg?rev=983639\";s:2:\"1x\";s:63:\"https://ps.w.org/redirection/assets/icon-128x128.jpg?rev=983640\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/redirection/assets/banner-1544x500.jpg?rev=983641\";s:2:\"1x\";s:65:\"https://ps.w.org/redirection/assets/banner-772x250.jpg?rev=983642\";}s:11:\"banners_rtl\";a:0:{}s:6:\"tested\";s:5:\"5.0.3\";s:12:\"requires_php\";s:3:\"5.4\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:53:\"simple-custom-post-order/simple-custom-post-order.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:38:\"w.org/plugins/simple-custom-post-order\";s:4:\"slug\";s:24:\"simple-custom-post-order\";s:6:\"plugin\";s:53:\"simple-custom-post-order/simple-custom-post-order.php\";s:11:\"new_version\";s:5:\"2.4.1\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/simple-custom-post-order/\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/plugin/simple-custom-post-order.2.4.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:77:\"https://ps.w.org/simple-custom-post-order/assets/icon-256x256.jpg?rev=1859717\";s:2:\"1x\";s:77:\"https://ps.w.org/simple-custom-post-order/assets/icon-256x256.jpg?rev=1859717\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:79:\"https://ps.w.org/simple-custom-post-order/assets/banner-772x250.jpg?rev=1859717\";}s:11:\"banners_rtl\";a:0:{}s:6:\"tested\";s:3:\"5.1\";s:12:\"requires_php\";s:3:\"5.6\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:51:\"wp-accessibility-helper/wp-accessibility-helper.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:37:\"w.org/plugins/wp-accessibility-helper\";s:4:\"slug\";s:23:\"wp-accessibility-helper\";s:6:\"plugin\";s:51:\"wp-accessibility-helper/wp-accessibility-helper.php\";s:11:\"new_version\";s:7:\"0.5.9.2\";s:3:\"url\";s:54:\"https://wordpress.org/plugins/wp-accessibility-helper/\";s:7:\"package\";s:66:\"https://downloads.wordpress.org/plugin/wp-accessibility-helper.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:76:\"https://ps.w.org/wp-accessibility-helper/assets/icon-256x256.jpg?rev=1421202\";s:2:\"1x\";s:76:\"https://ps.w.org/wp-accessibility-helper/assets/icon-128x128.jpg?rev=1478069\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:78:\"https://ps.w.org/wp-accessibility-helper/assets/banner-772x250.jpg?rev=1418183\";}s:11:\"banners_rtl\";a:0:{}s:6:\"tested\";s:3:\"5.1\";s:12:\"requires_php\";s:3:\"5.3\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}s:24:\"wordpress-seo/wp-seo.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:27:\"w.org/plugins/wordpress-seo\";s:4:\"slug\";s:13:\"wordpress-seo\";s:6:\"plugin\";s:24:\"wordpress-seo/wp-seo.php\";s:11:\"new_version\";s:3:\"9.7\";s:3:\"url\";s:44:\"https://wordpress.org/plugins/wordpress-seo/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/wordpress-seo.9.7.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:66:\"https://ps.w.org/wordpress-seo/assets/icon-256x256.png?rev=1834347\";s:2:\"1x\";s:58:\"https://ps.w.org/wordpress-seo/assets/icon.svg?rev=1946641\";s:3:\"svg\";s:58:\"https://ps.w.org/wordpress-seo/assets/icon.svg?rev=1946641\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/wordpress-seo/assets/banner-1544x500.png?rev=1843435\";s:2:\"1x\";s:68:\"https://ps.w.org/wordpress-seo/assets/banner-772x250.png?rev=1843435\";}s:11:\"banners_rtl\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/wordpress-seo/assets/banner-1544x500-rtl.png?rev=1843435\";s:2:\"1x\";s:72:\"https://ps.w.org/wordpress-seo/assets/banner-772x250-rtl.png?rev=1843435\";}s:6:\"tested\";s:3:\"5.1\";s:12:\"requires_php\";s:5:\"5.2.4\";s:13:\"compatibility\";O:8:\"stdClass\":0:{}}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:4:{s:36:\"contact-form-7/wp-contact-form-7.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:28:\"w.org/plugins/contact-form-7\";s:4:\"slug\";s:14:\"contact-form-7\";s:6:\"plugin\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:11:\"new_version\";s:5:\"5.1.1\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/contact-form-7/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/contact-form-7.5.1.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/contact-form-7/assets/icon-256x256.png?rev=984007\";s:2:\"1x\";s:66:\"https://ps.w.org/contact-form-7/assets/icon-128x128.png?rev=984007\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/contact-form-7/assets/banner-1544x500.png?rev=860901\";s:2:\"1x\";s:68:\"https://ps.w.org/contact-form-7/assets/banner-772x250.png?rev=880427\";}s:11:\"banners_rtl\";a:0:{}}s:9:\"hello.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:25:\"w.org/plugins/hello-dolly\";s:4:\"slug\";s:11:\"hello-dolly\";s:6:\"plugin\";s:9:\"hello.php\";s:11:\"new_version\";s:3:\"1.6\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/hello-dolly/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/plugin/hello-dolly.1.6.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/hello-dolly/assets/icon-256x256.jpg?rev=969907\";s:2:\"1x\";s:63:\"https://ps.w.org/hello-dolly/assets/icon-128x128.jpg?rev=969907\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:65:\"https://ps.w.org/hello-dolly/assets/banner-772x250.png?rev=478342\";}s:11:\"banners_rtl\";a:0:{}}s:38:\"post-duplicator/m4c-postduplicator.php\";O:8:\"stdClass\":9:{s:2:\"id\";s:29:\"w.org/plugins/post-duplicator\";s:4:\"slug\";s:15:\"post-duplicator\";s:6:\"plugin\";s:38:\"post-duplicator/m4c-postduplicator.php\";s:11:\"new_version\";s:4:\"2.20\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/post-duplicator/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/plugin/post-duplicator.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:68:\"https://ps.w.org/post-duplicator/assets/icon-128x128.png?rev=1587588\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/post-duplicator/assets/banner-1544x500.png?rev=1587588\";s:2:\"1x\";s:70:\"https://ps.w.org/post-duplicator/assets/banner-772x250.png?rev=1587588\";}s:11:\"banners_rtl\";a:0:{}}s:37:\"tinymce-advanced/tinymce-advanced.php\";O:8:\"stdClass\":12:{s:2:\"id\";s:30:\"w.org/plugins/tinymce-advanced\";s:4:\"slug\";s:16:\"tinymce-advanced\";s:6:\"plugin\";s:37:\"tinymce-advanced/tinymce-advanced.php\";s:11:\"new_version\";s:5:\"5.1.0\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/tinymce-advanced/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/tinymce-advanced.5.1.0.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/tinymce-advanced/assets/icon-256x256.png?rev=971511\";s:2:\"1x\";s:68:\"https://ps.w.org/tinymce-advanced/assets/icon-128x128.png?rev=971511\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/tinymce-advanced/assets/banner-1544x500.png?rev=2011513\";s:2:\"1x\";s:71:\"https://ps.w.org/tinymce-advanced/assets/banner-772x250.png?rev=2011513\";}s:11:\"banners_rtl\";a:0:{}s:6:\"tested\";s:3:\"5.1\";s:12:\"requires_php\";s:3:\"5.2\";s:13:\"compatibility\";a:0:{}}}}','no');
/*!40000 ALTER TABLE `plk_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_postmeta`
--

DROP TABLE IF EXISTS `plk_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_postmeta`
--

LOCK TABLES `plk_postmeta` WRITE;
/*!40000 ALTER TABLE `plk_postmeta` DISABLE KEYS */;
INSERT INTO `plk_postmeta` VALUES (1,2,'_wp_page_template','default'),(2,3,'_wp_page_template','default'),(3,10,'form','<p>Your Name (required)<br />\n    [text* your-name] </p>\n\n<p>Your Email (required)<br />\n    [email* your-email] </p>\n\n<p>Subject<br />\n    [text your-subject] </p>\n\n<p>Your Message<br />\n    [textarea your-message] </p>\n\n<p>[submit \"Send\"]</p>'),(4,10,'mail','a:7:{s:7:\"subject\";s:14:\"[your-subject]\";s:6:\"sender\";s:26:\"[your-name] <[your-email]>\";s:4:\"body\";s:188:\"From: [your-name] <[your-email]>\nSubject: [your-subject]\n\nMessage Body:\n[your-message]\n\n--\nThis mail is sent via contact form on אתר וורדפרס חדש http://master.s485.upress.link\";s:9:\"recipient\";s:21:\"yotamizakov@gmail.com\";s:18:\"additional_headers\";s:0:\"\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";i:0;}'),(5,10,'mail_2','a:8:{s:6:\"active\";b:0;s:7:\"subject\";s:14:\"[your-subject]\";s:6:\"sender\";s:26:\"[your-name] <[your-email]>\";s:4:\"body\";s:130:\"Message body:\n[your-message]\n\n--\nThis mail is sent via contact form on אתר וורדפרס חדש http://master.s485.upress.link\";s:9:\"recipient\";s:12:\"[your-email]\";s:18:\"additional_headers\";s:0:\"\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";i:0;}'),(6,10,'messages','a:6:{s:12:\"mail_sent_ok\";s:43:\"Your message was sent successfully. Thanks.\";s:12:\"mail_sent_ng\";s:93:\"Failed to send your message. Please try later or contact the administrator by another method.\";s:16:\"validation_error\";s:74:\"Validation errors occurred. Please confirm the fields and submit it again.\";s:12:\"accept_terms\";s:35:\"Please accept the terms to proceed.\";s:13:\"invalid_email\";s:28:\"Email address seems invalid.\";s:16:\"invalid_required\";s:31:\"Please fill the required field.\";}'),(7,10,'additional_settings',NULL);
/*!40000 ALTER TABLE `plk_postmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_posts`
--

DROP TABLE IF EXISTS `plk_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_posts`
--

LOCK TABLES `plk_posts` WRITE;
/*!40000 ALTER TABLE `plk_posts` DISABLE KEYS */;
INSERT INTO `plk_posts` VALUES (1,1,'2018-11-26 15:56:31','2018-11-26 13:56:31','ברוכים הבאים לוורדפרס. זה הפוסט הראשון באתר. ניתן למחוק או לערוך אותו, ולהתחיל לכתוב.','שלום עולם!','','publish','open','open','','%d7%a9%d7%9c%d7%95%d7%9d-%d7%a2%d7%95%d7%9c%d7%9d','','','2018-11-26 15:56:31','2018-11-26 13:56:31','',0,'http://master.s485.upress.link/?p=1',0,'post','',1),(2,1,'2018-11-26 15:56:31','2018-11-26 13:56:31','זו דוגמה לעמוד בוורדפרס. בניגוד לפוסטים, עמודים נשארים תמיד באותו מקום, וברוב ערכות העיצוב הם מופיעים כחלק מתפריט הניווט הראשי של האתר. מומלץ להתחיל ביצירת עמוד \"אודות\", ולהציג בו למבקרים את האתר ואת בעליו. הנה עמוד אודות לדוגמה:\n\n<blockquote>שלום! אני שליחה בשעות היום, שחקנית בשעות הלילה, וזה האתר שלי. אני גרה בירושלים, יש לי כלב שקוראים לו יוני, ואני אוהבת לשתות פינה קולדה (ולהיות בחוץ כשיורד גשם).</blockquote>\n\nגם זה עמוד אודות:\n\n<blockquote>החברה א.א. ובניו בע\"מ מייצרת ומשווקת מוצרי איכות מאז 1971. אנו מעסיקים כ-2,000 עובדים במשרדינו שבמגדל משה, ועוסקים בפעילות חברתית ענפה בקרב הקהילה המקומית.</blockquote>\n\nאת עמוד הדוגמה הזה כדאי למחוק <a href=\"http://master.s485.upress.link/wp-admin/\">בלוח הבקרה</a>, וליצור במקומו עמודים חדשים. בהצלחה!','עמוד לדוגמא','','publish','closed','open','','sample-page','','','2018-11-26 15:56:31','2018-11-26 13:56:31','',0,'http://master.s485.upress.link/?page_id=2',0,'page','',0),(3,1,'2018-11-26 15:56:31','2018-11-26 13:56:31','<h2>מי אנחנו</h2><p>כתובת האתר שלנו היא: http://master.s485.upress.link.</p><h2>מה המידע האישי שאנו אוספים ומדוע אנחנו אוספים אותו</h2><h3>תגובות</h3><p>כאשר המבקרים משאירים תגובות באתר אנו אוספים את הנתונים המוצגים בטופס התגובה, ובנוסף גם את כתובת ה-IP של המבקר, ואת מחרוזת ה-user agent של הדפדפן שלו כדי לסייע בזיהוי תגובות זבל.</p><p>יתכן ונעביר מחרוזת אנונימית שנוצרה מכתובת הדואר האלקטרוני שלך (הנקראת גם hash) לשירות Gravatar כדי לראות אם הנך חבר/ה בשירות. מדיניות הפרטיות של שירות Gravatar זמינה כאן: https://automattic.com/privacy/. לאחר אישור התגובה שלך, תמונת הפרופיל שלך גלויה לציבור בהקשר של התגובה שלך.</p><h3>מדיה</h3><p>בהעלאה של תמונות לאתר, מומלץ להימנע מהעלאת תמונות עם נתוני מיקום מוטבעים (EXIF GPS). המבקרים באתר יכולים להוריד ולחלץ את כל נתוני מיקום מהתמונות באתר.</p><h3>טפסי יצירת קשר</h3><h3>עוגיות</h3><p>בכתיבת תגובה באתר שלנו, באפשרותך להחליט אם לאפשר לנו לשמור את השם שלך, כתובת האימייל שלך וכתובת האתר שלך בקבצי עוגיות (cookies). השמירה תתבצע לנוחיותך, על מנת שלא יהיה צורך למלא את הפרטים שלך שוב בכתיבת תגובה נוספת. קבצי העוגיות ישמרו לשנה.</p><p>אם יש לך חשבון ואתה מתחבר לאתר זה, נגדיר קובץ \'עוגיה\' זמני על מנת לבדוק אם הדפדפן שלך מקבל קבצי עוגיות. קובץ עוגיה זה אינו מכיל נתונים אישיים והוא נמחק בעת סגירת הדפדפן.</p><p>כאשר תתחבר, אנחנו גם נגדיר מספר \'עוגיות\' על מנת לשמור את פרטי ההתחברות שלך ואת בחירות התצוגה שלך. עוגיות התחברות תקפות ליומיים, ועוגיות אפשרויות מסך תקפות לשנה. אם תבחר באפשרות &quot;זכור אותי&quot;, פרטי ההתחברות שלך יהיו תקפים למשך שבועיים. אם תתנתק מהחשבון שלך, עוגיות ההתחברות יימחקו.</p><p>אם אתה עורך או מפרסם מאמר, קובץ \'עוגיה\' נוסף יישמר בדפדפן שלך. קובץ \'עוגיה\' זה אינו כולל נתונים אישיים ופשוט מציין את מזהה הפוסט של המאמר. הוא יפוג לאחר יום אחד.</p><h3>תוכן מוטמע מאתרים אחרים</h3><p>כתבות או פוסטים באתר זה עשויים לכלול תוכן מוטבע (לדוגמה, קטעי וידאו, תמונות, מאמרים, וכו\'). תוכן מוטבע מאתרי אינטרנט אחרים דינו כביקור הקורא באתרי האינטרנט מהם מוטבע התוכן.</p><p>אתרים אלו עשויים לאסוף נתונים אודותיך, להשתמש בקבצי \'עוגיות\', להטמיע מעקב של צד שלישי נוסף, ולנטר את האינטראקציה שלך עם תוכן מוטמע זה, לרבות מעקב אחר האינטראקציה שלך עם התוכן המוטמע, אם יש לך חשבון ואתה מחובר לאתר זה.</p><h3>אנליטיקה</h3><h2>עם מי אנו חולקים את המידע שלך</h2><h2>משך הזמן בו נשמור את המידע שלך</h2><p>במידה ותגיב/י על תוכן באתר, התגובה והנתונים אודותיה יישמרו ללא הגבלת זמן, כדי שנוכל לזהות ולאשר את כל התגובות העוקבות באופן אוטומטי.</p><p>עבור משתמשים רשומים באתר (במידה ויש כאלה) אנו מאחסנים גם את המידע האישי שהם מספקים בפרופיל המשתמש שלהם. כל המשתמשים יכולים לראות, לערוך או למחוק את המידע האישי שלהם בכל עת (פרט לשם המשתמש אותו לא ניתן לשנות). גם מנהלי האתר יכולים לראות ולערוך מידע זה.</p><h2>אילו זכויות יש לך על המידע שלך</h2><p>אם יש לך חשבון באתר זה, או שהשארת תגובות באתר, באפשרותך לבקש לקבל קובץ של הנתונים האישיים שאנו מחזיקים לגביך, כולל כל הנתונים שסיפקת לנו. באפשרותך גם לבקש שנמחק כל מידע אישי שאנו מחזיקים לגביך. הדבר אינו כולל נתונים שאנו מחויבים לשמור למטרות מנהליות, משפטיות או ביטחוניות.</p><h2>להיכן אנו שולחים את המידע שלך</h2><p>תגובות מבקרים עלולות להיבדק על ידי שירות אוטומטי למניעת תגובות זבל.</p><h2>פרטי ההתקשרות שלך</h2><h2>מידע נוסף</h2><h3>כיצד אנו מגינים על המידע שלך</h3><h3>אילו הליכי פרצת נתונים יש לנו</h3><h3>מאילו גופי צד-שלישי אנו מקבלים מידע</h3><h3>קבלת החלטות אוטומטיות ו/או יצירת פרופילים שאנו עושים עם נתוני המשתמשים שלנו</h3><h3>דרישות גילוי רגולטוריות של התעשייה </h3>','מדיניות פרטיות','','draft','closed','open','','privacy-policy','','','2018-11-26 15:56:31','2018-11-26 13:56:31','',0,'http://master.s485.upress.link/?page_id=3',0,'page','',0),(4,1,'2018-11-26 16:31:13','0000-00-00 00:00:00','','טיוטה משמירה אוטומטית','','auto-draft','open','open','','','','','2018-11-26 16:31:13','0000-00-00 00:00:00','',0,'http://master.s485.upress.link/?p=4',0,'post','',0),(5,1,'2018-11-26 16:31:24','0000-00-00 00:00:00','','avia_logo','','draft','closed','closed','','','','','2018-11-26 16:31:24','0000-00-00 00:00:00','',0,'http://master.s485.upress.link/?post_type=avia_framework_post&p=5',0,'avia_framework_post','',0),(6,1,'2018-11-26 16:31:24','0000-00-00 00:00:00','','avia_favicon','','draft','closed','closed','','','','','2018-11-26 16:31:24','0000-00-00 00:00:00','',0,'http://master.s485.upress.link/?post_type=avia_framework_post&p=6',0,'avia_framework_post','',0),(7,1,'2018-11-26 16:31:24','0000-00-00 00:00:00','','avia_custom_logo_for_preloader','','draft','closed','closed','','','','','2018-11-26 16:31:24','0000-00-00 00:00:00','',0,'http://master.s485.upress.link/?post_type=avia_framework_post&p=7',0,'avia_framework_post','',0),(8,1,'2018-11-26 16:31:24','0000-00-00 00:00:00','','avia_custom_background_image','','draft','closed','closed','','','','','2018-11-26 16:31:24','0000-00-00 00:00:00','',0,'http://master.s485.upress.link/?post_type=avia_framework_post&p=8',0,'avia_framework_post','',0),(9,1,'2018-11-26 16:31:24','0000-00-00 00:00:00','','avia_transparency_logo','','draft','closed','closed','','','','','2018-11-26 16:31:24','0000-00-00 00:00:00','',0,'http://master.s485.upress.link/?post_type=avia_framework_post&p=9',0,'avia_framework_post','',0),(10,1,'2018-11-26 16:32:32','2018-11-26 14:32:32','<p>Your Name (required)<br />\n    [text* your-name] </p>\n\n<p>Your Email (required)<br />\n    [email* your-email] </p>\n\n<p>Subject<br />\n    [text your-subject] </p>\n\n<p>Your Message<br />\n    [textarea your-message] </p>\n\n<p>[submit \"Send\"]</p>\n[your-subject]\n[your-name] <[your-email]>\nFrom: [your-name] <[your-email]>\nSubject: [your-subject]\n\nMessage Body:\n[your-message]\n\n--\nThis mail is sent via contact form on אתר וורדפרס חדש http://master.s485.upress.link\nyotamizakov@gmail.com\n\n\n0\n\n[your-subject]\n[your-name] <[your-email]>\nMessage body:\n[your-message]\n\n--\nThis mail is sent via contact form on אתר וורדפרס חדש http://master.s485.upress.link\n[your-email]\n\n\n0\nYour message was sent successfully. Thanks.\nFailed to send your message. Please try later or contact the administrator by another method.\nValidation errors occurred. Please confirm the fields and submit it again.\nPlease accept the terms to proceed.\nEmail address seems invalid.\nPlease fill the required field.','Contact form 1','','publish','closed','closed','','contact-form-1','','','2018-11-26 16:32:32','2018-11-26 14:32:32','',0,'http://master.s485.upress.link/wpcf7_contact_form/contact-form-1/',0,'wpcf7_contact_form','',0);
/*!40000 ALTER TABLE `plk_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_redirection_404`
--

DROP TABLE IF EXISTS `plk_redirection_404`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_redirection_404` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referrer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `url` (`url`(191)),
  KEY `referrer` (`referrer`(191)),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_redirection_404`
--

LOCK TABLES `plk_redirection_404` WRITE;
/*!40000 ALTER TABLE `plk_redirection_404` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_redirection_404` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_redirection_groups`
--

DROP TABLE IF EXISTS `plk_redirection_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_redirection_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking` int(11) NOT NULL DEFAULT '1',
  `module_id` int(11) unsigned NOT NULL DEFAULT '0',
  `status` enum('enabled','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enabled',
  `position` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_redirection_groups`
--

LOCK TABLES `plk_redirection_groups` WRITE;
/*!40000 ALTER TABLE `plk_redirection_groups` DISABLE KEYS */;
INSERT INTO `plk_redirection_groups` VALUES (1,'Redirections',1,1,'enabled',0),(2,'Modified Posts',1,1,'enabled',1);
/*!40000 ALTER TABLE `plk_redirection_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_redirection_items`
--

DROP TABLE IF EXISTS `plk_redirection_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_redirection_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `regex` int(11) unsigned NOT NULL DEFAULT '0',
  `position` int(11) unsigned NOT NULL DEFAULT '0',
  `last_count` int(10) unsigned NOT NULL DEFAULT '0',
  `last_access` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `status` enum('enabled','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enabled',
  `action_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_code` int(11) unsigned NOT NULL,
  `action_data` mediumtext COLLATE utf8mb4_unicode_ci,
  `match_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `url` (`url`(191)),
  KEY `status` (`status`),
  KEY `regex` (`regex`),
  KEY `group_idpos` (`group_id`,`position`),
  KEY `group` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_redirection_items`
--

LOCK TABLES `plk_redirection_items` WRITE;
/*!40000 ALTER TABLE `plk_redirection_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_redirection_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_redirection_logs`
--

DROP TABLE IF EXISTS `plk_redirection_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_redirection_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `url` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sent_to` mediumtext COLLATE utf8mb4_unicode_ci,
  `agent` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `referrer` mediumtext COLLATE utf8mb4_unicode_ci,
  `redirection_id` int(11) unsigned DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `redirection_id` (`redirection_id`),
  KEY `ip` (`ip`),
  KEY `group_id` (`group_id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_redirection_logs`
--

LOCK TABLES `plk_redirection_logs` WRITE;
/*!40000 ALTER TABLE `plk_redirection_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_redirection_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_term_relationships`
--

DROP TABLE IF EXISTS `plk_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_term_relationships`
--

LOCK TABLES `plk_term_relationships` WRITE;
/*!40000 ALTER TABLE `plk_term_relationships` DISABLE KEYS */;
INSERT INTO `plk_term_relationships` VALUES (1,1,0);
/*!40000 ALTER TABLE `plk_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_term_taxonomy`
--

DROP TABLE IF EXISTS `plk_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_term_taxonomy`
--

LOCK TABLES `plk_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `plk_term_taxonomy` DISABLE KEYS */;
INSERT INTO `plk_term_taxonomy` VALUES (1,1,'category','',0,1);
/*!40000 ALTER TABLE `plk_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_termmeta`
--

DROP TABLE IF EXISTS `plk_termmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_termmeta`
--

LOCK TABLES `plk_termmeta` WRITE;
/*!40000 ALTER TABLE `plk_termmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_termmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_terms`
--

DROP TABLE IF EXISTS `plk_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  `term_order` int(4) DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_terms`
--

LOCK TABLES `plk_terms` WRITE;
/*!40000 ALTER TABLE `plk_terms` DISABLE KEYS */;
INSERT INTO `plk_terms` VALUES (1,'כללי','%d7%9b%d7%9c%d7%9c%d7%99',0,0);
/*!40000 ALTER TABLE `plk_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_usermeta`
--

DROP TABLE IF EXISTS `plk_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_usermeta`
--

LOCK TABLES `plk_usermeta` WRITE;
/*!40000 ALTER TABLE `plk_usermeta` DISABLE KEYS */;
INSERT INTO `plk_usermeta` VALUES (1,1,'nickname','yotam'),(2,1,'first_name',''),(3,1,'last_name',''),(4,1,'description',''),(5,1,'rich_editing','true'),(6,1,'syntax_highlighting','true'),(7,1,'comment_shortcuts','false'),(8,1,'admin_color','fresh'),(9,1,'use_ssl','0'),(10,1,'show_admin_bar_front','true'),(11,1,'locale',''),(12,1,'plk_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(13,1,'plk_user_level','10'),(14,1,'dismissed_wp_pointers','wp496_privacy'),(15,1,'show_welcome_panel','1'),(16,1,'session_tokens','a:1:{s:64:\"1c22cd8264da9f2ce0027cf7b9183eaa6cf29b42052aa1ed555b829f12ef619a\";a:4:{s:10:\"expiration\";i:1544452272;s:2:\"ip\";s:12:\"5.29.148.119\";s:2:\"ua\";s:78:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:63.0) Gecko/20100101 Firefox/63.0\";s:5:\"login\";i:1543242672;}}'),(17,1,'plk_dashboard_quick_press_last_post_id','4'),(18,1,'community-events-location','a:1:{s:2:\"ip\";s:10:\"5.29.148.0\";}'),(19,1,'plk_yoast_notifications','a:2:{i:0;a:2:{s:7:\"message\";s:173:\"Don\'t miss your crawl errors: <a href=\"http://master.s485.upress.link/wp-admin/admin.php?page=wpseo_search_console&tab=settings\">connect with Google Search Console here</a>.\";s:7:\"options\";a:9:{s:4:\"type\";s:7:\"warning\";s:2:\"id\";s:17:\"wpseo-dismiss-gsc\";s:5:\"nonce\";N;s:8:\"priority\";d:0.5;s:9:\"data_json\";a:0:{}s:13:\"dismissal_key\";N;s:12:\"capabilities\";s:20:\"wpseo_manage_options\";s:16:\"capability_check\";s:3:\"all\";s:14:\"yoast_branding\";b:0;}}i:1;a:2:{s:7:\"message\";s:357:\"You still have the default WordPress tagline, even an empty one is probably better. <a href=\"http://master.s485.upress.link/wp-admin/customize.php?autofocus[control]=blogdescription&amp;url=http%3A%2F%2Fmaster.s485.upress.link%2Fwp-admin%2Fplugins.php%3Factivate-multi%3Dtrue%26plugin_status%3Dall%26paged%3D1%26s%3D\">You can fix this in the customizer</a>.\";s:7:\"options\";a:9:{s:4:\"type\";s:5:\"error\";s:2:\"id\";s:28:\"wpseo-dismiss-tagline-notice\";s:5:\"nonce\";N;s:8:\"priority\";d:0.5;s:9:\"data_json\";a:0:{}s:13:\"dismissal_key\";N;s:12:\"capabilities\";s:20:\"wpseo_manage_options\";s:16:\"capability_check\";s:3:\"all\";s:14:\"yoast_branding\";b:0;}}}');
/*!40000 ALTER TABLE `plk_usermeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_users`
--

DROP TABLE IF EXISTS `plk_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_users`
--

LOCK TABLES `plk_users` WRITE;
/*!40000 ALTER TABLE `plk_users` DISABLE KEYS */;
INSERT INTO `plk_users` VALUES (1,'yotam','$P$BO.wBqip50P.SLUC4OM311/6jJAaNs/','yotam','yotamizakov@gmail.com','','2018-11-26 13:56:31','',0,'yotam');
/*!40000 ALTER TABLE `plk_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_yoast_seo_links`
--

DROP TABLE IF EXISTS `plk_yoast_seo_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_yoast_seo_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  `target_post_id` bigint(20) unsigned NOT NULL,
  `type` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `link_direction` (`post_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_yoast_seo_links`
--

LOCK TABLES `plk_yoast_seo_links` WRITE;
/*!40000 ALTER TABLE `plk_yoast_seo_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_yoast_seo_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plk_yoast_seo_meta`
--

DROP TABLE IF EXISTS `plk_yoast_seo_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plk_yoast_seo_meta` (
  `object_id` bigint(20) unsigned NOT NULL,
  `internal_link_count` int(10) unsigned DEFAULT NULL,
  `incoming_link_count` int(10) unsigned DEFAULT NULL,
  UNIQUE KEY `object_id` (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plk_yoast_seo_meta`
--

LOCK TABLES `plk_yoast_seo_meta` WRITE;
/*!40000 ALTER TABLE `plk_yoast_seo_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `plk_yoast_seo_meta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-11  8:52:56
