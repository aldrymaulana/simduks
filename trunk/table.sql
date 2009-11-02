/*
SQLyog Community Edition- MySQL GUI v8.16 
MySQL - 5.0.45-community-nt : Database - griddemo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`griddemo` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `alamat` */

DROP TABLE IF EXISTS `alamat`;

CREATE TABLE `alamat` (
  `id` int(11) NOT NULL auto_increment,
  `nama` varchar(255) default NULL,
  `alamat` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `alamat` */

insert  into `alamat`(`id`,`nama`,`alamat`) values (1,'Heru Eko Susanto','Jl. Sriwijaya 36 Surabaya'),(2,'Sukandar','Jl. Nangka 30 Surabaya');

/*Table structure for table `personil` */

DROP TABLE IF EXISTS `personil`;

CREATE TABLE `personil` (
  `id` int(11) NOT NULL auto_increment,
  `nama_personel` varchar(100) default NULL,
  `alamat_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `personil` */

insert  into `personil`(`id`,`nama_personel`,`alamat_id`) values (1,'habis di edit saja',2),(2,'testing asoy',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
