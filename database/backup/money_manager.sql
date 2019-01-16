/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.37-MariaDB : Database - money_manager
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`money_manager` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `money_manager`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `storage_gb` tinyint(3) unsigned DEFAULT '16' COMMENT 'default GB for this category',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`storage_gb`) values (1,'A',16),(2,'B',32),(3,'C',64);

/*Table structure for table `colors` */

DROP TABLE IF EXISTS `colors`;

CREATE TABLE `colors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `colors` */

insert  into `colors`(`id`,`name`) values (1,'Red'),(2,'Green'),(3,'Blue'),(4,'White'),(5,'Gray'),(6,'Yellow'),(7,'Gold');

/*Table structure for table `distribution_invoice` */

DROP TABLE IF EXISTS `distribution_invoice`;

CREATE TABLE `distribution_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(100) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `notes` varchar(2000) DEFAULT NULL,
  `locations_id` int(10) unsigned DEFAULT NULL,
  `total_amount` double(20,2) DEFAULT NULL,
  `payment_status` tinyint(3) unsigned DEFAULT '0',
  `total_payment` double(20,2) DEFAULT NULL,
  `delivery_status` tinyint(1) unsigned DEFAULT '0' COMMENT '0=delivered, 1=sent, 2=transit',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `distribution_invoice` */

insert  into `distribution_invoice`(`id`,`invoice_number`,`invoice_date`,`notes`,`locations_id`,`total_amount`,`payment_status`,`total_payment`,`delivery_status`) values (3,'INV-54034','2018-06-24','shenim prove',3,198000.00,0,NULL,0),(5,'INV-20018','2018-07-10',NULL,4,180000.00,1,180000.00,0);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `flg_delete` tinyint(1) unsigned DEFAULT '1' COMMENT 'can be deleted or not',
  `deleted` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`id`,`role_name`,`description`,`flg_delete`,`deleted`) values (1,'Admin','Has permissions to access everything by default.',0,0),(2,'Dyqan','Approve Reservations and Open new ones',0,0);

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `status` */

insert  into `status`(`id`,`name`,`description`) values (0,'Jo Aktiv','Nuk eshte mbullur fatura e importit'),(1,'Shitur',NULL),(2,'Ne Magazine','Aktivizuar pas mbylljes se fatures, Gjendje ne magazine'),(3,'Ne Dyqan','Gjendje ne dyqanin perkates'),(4,'Ne Servis','Derguar per riparim ne servis'),(5,'ADEX','Postuar me ADEX');

/*Table structure for table `user_failed_logins` */

DROP TABLE IF EXISTS `user_failed_logins`;

CREATE TABLE `user_failed_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_users` int(10) unsigned DEFAULT '0',
  `ip_address` char(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `attempted` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usersId` (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `user_failed_logins` */

insert  into `user_failed_logins`(`id`,`id_users`,`ip_address`,`attempted`) values (1,0,'127.0.0.1',1449587190),(2,0,'127.0.0.1',1449587261),(3,0,'127.0.0.1',1449587286),(4,0,'127.0.0.1',1449778436),(5,3,'127.0.0.1',1449778609),(6,3,'127.0.0.1',1449778694),(7,3,'127.0.0.1',1449778944),(8,1,'127.0.0.1',1450203898),(9,1,'127.0.0.1',1455717135),(10,1,'127.0.0.1',1455786663);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `email_code` varchar(100) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `role_id` tinyint(4) unsigned DEFAULT '2',
  `description` varchar(800) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '0=not active 1=active 2=Blocked',
  `deleted` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`email`,`email_code`,`firstname`,`lastname`,`role_id`,`description`,`tel`,`created_at`,`updated_at`,`remember_token`,`status`,`deleted`) values (1,'','$2y$10$ch50LN92wteXe/H0pb8aAe2i/gn9om9R3WNRnuOfIB.molviaxUKS','admin@mail.com',NULL,'Admin','Admin',1,NULL,'2483204','2015-11-16 10:23:04',NULL,'D1fO0BSg2iFVL7vjPJoM2KsIvufzRrZKnC7WXyxJ1uXpm83vckGrHmyIAa0v',1,0),(2,'','$2y$10$CMHS6NAV.iRYv8CsQvWXSO02C83gxjRyTxVvpSxhQAp2V9aYtJOBS','one@mail.com',NULL,'One','Black',2,NULL,'20493204','2015-11-17 16:19:57',NULL,NULL,1,0),(3,'','$2y$10$gCE4ijCxJwyevvEe8sktP.fJOS9Tm7bHljLz8WZycNcGlTLLFYZha','two@mail.com',NULL,'Two','Green',2,NULL,'29043902','2015-11-17 16:20:26',NULL,'PMhWAkNuxO26wSgXoGZqk8oUozeNdg27ER0Q2ApFUTHDMiAl4a2D0bzPKbsW',1,0),(5,'','$2y$10$X7yyNtSbzEOk24IujMNs0emH3hiEKhZYYIajrdq.uWcVQX0zdJ.Z.','ace@mail.com',NULL,'Seven11','Eleven',2,NULL,NULL,'2016-02-19 12:01:29',NULL,NULL,1,1),(6,'','$2y$10$bPZ38STFt8Jvu7ASSBT7r.3QMvi1YSS3685HW5RSdAEbTjb6jDcP.','kater@mail.com',NULL,'Seven7','Eleven',2,NULL,NULL,'2016-02-19 12:11:00',NULL,NULL,1,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
