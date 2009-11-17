-- MySQL dump 10.11
--
-- Host: localhost    Database: kohana
-- ------------------------------------------------------
-- Server version	5.0.45-community-nt

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

DROP DATABASE IF EXISTS `kohana`;
CREATE DATABASE `kohana`;
USE `kohana`;

--
-- Table structure for table `access_groups`
--

DROP TABLE IF EXISTS `access_groups`;
CREATE TABLE `access_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `kecamatan_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `access_groups`
--

LOCK TABLES `access_groups` WRITE;
/*!40000 ALTER TABLE `access_groups` DISABLE KEYS */;
INSERT INTO `access_groups` VALUES (1,'admin',-1),(2,'campurdarat',4),(3,'capil',-5),(4,'kua',-6);
/*!40000 ALTER TABLE `access_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agama`
--

DROP TABLE IF EXISTS `agama`;
CREATE TABLE `agama` (
  `id` int(11) NOT NULL auto_increment,
  `agama` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `agama`
--

LOCK TABLES `agama` WRITE;
/*!40000 ALTER TABLE `agama` DISABLE KEYS */;
INSERT INTO `agama` VALUES (0,'-'),(1,'Islam'),(2,'Katholik'),(3,'Protestan'),(4,'Hindu'),(5,'Budha'),(6,'Konghucu'),(7,'resrsr');
/*!40000 ALTER TABLE `agama` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `akta_kelahiran`
--

DROP TABLE IF EXISTS `akta_kelahiran`;
CREATE TABLE `akta_kelahiran` (
  `id` int(11) NOT NULL auto_increment,
  `penduduk_id` int(11) default NULL,
  `no_akta` varchar(20) default NULL,
  `jam_lahir` time default NULL,
  `saksi1` varchar(255) default NULL,
  `saksi2` varchar(255) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `akta_kelahiran`
--

LOCK TABLES `akta_kelahiran` WRITE;
/*!40000 ALTER TABLE `akta_kelahiran` DISABLE KEYS */;
INSERT INTO `akta_kelahiran` VALUES (1,11,'10000','13:00:00','Budi','Sukri','2009-11-17 13:36:42',NULL),(2,12,'10001','13:00:00','Budi','Sukri','2009-11-17 13:37:39',NULL),(3,13,'100002','12:00:00','samad','chandra','2009-11-17 13:40:17',NULL);
/*!40000 ALTER TABLE `akta_kelahiran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alamat`
--

DROP TABLE IF EXISTS `alamat`;
CREATE TABLE `alamat` (
  `id` int(11) NOT NULL auto_increment,
  `alamat` varchar(255) default NULL,
  `rukun_tetangga` int(11) default NULL,
  `rukun_warga` int(11) default NULL,
  `kelurahan_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_alamat_kelurahan` (`kelurahan_id`),
  CONSTRAINT `FK_alamat_kelurahan` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `alamat`
--

LOCK TABLES `alamat` WRITE;
/*!40000 ALTER TABLE `alamat` DISABLE KEYS */;
INSERT INTO `alamat` VALUES (1,'Jl. Nangka',1,2,48);
/*!40000 ALTER TABLE `alamat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kb`
--

DROP TABLE IF EXISTS `kb`;
CREATE TABLE `kb` (
  `id` int(11) NOT NULL auto_increment,
  `kb` varchar(40) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kb`
--

LOCK TABLES `kb` WRITE;
/*!40000 ALTER TABLE `kb` DISABLE KEYS */;
INSERT INTO `kb` VALUES (0,'-'),(1,'IUD'),(2,'Spiral'),(3,'Pil');
/*!40000 ALTER TABLE `kb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kecamatan`
--

DROP TABLE IF EXISTS `kecamatan`;
CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL auto_increment,
  `kd_wilayah` varchar(7) NOT NULL,
  `camat` varchar(255) default NULL,
  `nama_kecamatan` varchar(255) NOT NULL,
  `kodepos` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kecamatan`
--

LOCK TABLES `kecamatan` WRITE;
/*!40000 ALTER TABLE `kecamatan` DISABLE KEYS */;
INSERT INTO `kecamatan` VALUES (1,'350401','SUDARMAJI, S.Sos','Besuki','66275'),(2,'350402','Drs. SUKADHI, M.Si','Bandung','66274'),(3,'350403','Drs. TRANGGONO DIBYOHARSONO','Pakel','66273'),(4,'350404','ISWAHYUDI','Campurdarat','66272'),(5,'350405','DJANOE SOEKITO','Tanggunggunung','66283'),(6,'350406','H. SYAMSUL LAILY, SH','Kalidawir','66281'),(7,'350407','TRI WANTORO S.Sos','Pucanglaban','66284'),(8,'350408','Drs. ARIEF BOEDIONO, MSi','Rejotangan','66293'),(9,'350409','Drs. MOHAMAD ACHWAN','Ngunut','66292'),(10,'350410','H. MUDAWAM, SH.','Sumbergempol','66291'),(11,'350411','SOEROTO, S.Sos','Boyolangu','66271'),(12,'350412','Dra. SUHARMIYATI ,M.Si','Tulungagung','66211'),(13,'350413','Drs. SUGIANTO, MM','Kedungwaru','66226'),(14,'350414','Drs. TRI HARIADI','Ngantru','66252'),(15,'350415','Drs. BUDI FATAHILLAH','Karangrejo','66253'),(16,'350416','Drs. HERU SANTOSA','Kauman','66261'),(17,'350417','Drs. YASID BASTOMI','Gondang','66263'),(18,'350418','Drs. SUGITO,M.Si','Pagerwojo','66262'),(19,'350419','Drs. MOCH. HANAFI','Sendang','66254');
/*!40000 ALTER TABLE `kecamatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keluarga`
--

DROP TABLE IF EXISTS `keluarga`;
CREATE TABLE `keluarga` (
  `id` int(11) NOT NULL auto_increment,
  `kode_keluarga` varchar(16) NOT NULL,
  `alamat_id` int(11) NOT NULL,
  `no_formulir` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_keluarga_alamat` (`alamat_id`),
  CONSTRAINT `FK_keluarga_alamat` FOREIGN KEY (`alamat_id`) REFERENCES `alamat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `keluarga`
--

LOCK TABLES `keluarga` WRITE;
/*!40000 ALTER TABLE `keluarga` DISABLE KEYS */;
INSERT INTO `keluarga` VALUES (1,'100000',1,'100000'),(2,'200000',1,'100000');
/*!40000 ALTER TABLE `keluarga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelurahan`
--

DROP TABLE IF EXISTS `kelurahan`;
CREATE TABLE `kelurahan` (
  `id` int(11) NOT NULL auto_increment,
  `lurah` varchar(255) NOT NULL default '',
  `nama_kelurahan` varchar(255) NOT NULL default '',
  `kecamatan_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_kelurahan_kecamatan` (`kecamatan_id`),
  CONSTRAINT `FK_kelurahan_kecamatan` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=279 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `kelurahan`
--

LOCK TABLES `kelurahan` WRITE;
/*!40000 ALTER TABLE `kelurahan` DISABLE KEYS */;
INSERT INTO `kelurahan` VALUES (1,'Martoyo, Spd','Bantengan',2),(2,'R. Endro Rianto, S. Kep. Nera','Soko',2),(3,'Drs. H. A. Kasim','Ngepeh',2),(4,'Suyatno','Sebalor',2),(5,'Muserin','Tulunkulon',2),(6,'H. M. Sakuran','Bandung',2),(7,'Mujiati','Ngunggahan',2),(8,'Marhudi','Mergayu',2),(9,'Maryono, S.pd','Kedungwilut',2),(10,'Subandi','Nglampir',2),(11,'Suroso','Sukoharjo',2),(12,'Amawati, A. Ma','Suruhan Lor',2),(13,'H. Imam Suryani, Sp.d','Kesambi',2),(14,'H. Masingut','Singgit',2),(15,'Mulyono','Gondang',2),(16,'Toha Mahsun','Suwaru',2),(17,'Karmen','Bulus',2),(18,'Setianto','Suruhan Kidul',2),(19,'Widoto','Besole',1),(20,'Sihadji','Besuki',1),(21,'Agus Utomo','Tanggulwelehan',1),(22,'Supriyo Bondowo','Kebonireng',1),(23,'Supri Astuti','Tanggulterus',1),(24,'Zaenal Arifin','Sedayugunung',1),(25,'Mulyadi, S.Pd','Tanggulkundung',1),(26,'Imam Sapingi','Watenkroyo',1),(27,'Djoko Sugiono','Siyotobagus',1),(28,'Sukardi','Tulungrejo',1),(29,'Joko Sinung','Moyoketen',11),(30,'Moedjito','Waung',11),(31,'Drs. Suharno','Sanggrahan',11),(32,'H. Karjanto','Beji',11),(33,'Suyitno','Serut',11),(34,'Eko Prisdianto','Kendal Bulur',11),(35,'Slamet','Kepuh',11),(36,'Samudji','Ngranti',11),(37,'Sumarno','Wajak Lor',11),(38,'Drs. Sudjangi','Karangrejo',11),(39,'Mohammad Rifai','Tanjungsari',11),(40,'Sukemi','Pucungkidul',11),(41,'Muhari','Boyolangu',11),(42,'Mahfud Sokip','Subontoro',11),(43,'Moch. Moezamil, S.Sos','Bono',11),(44,'Supayati','Wajak Kidul',11),(45,'Sunarto','Gedangsewu',11),(46,'Mudjito','Ngentrong',4),(47,'Warsito','Sawo',4),(48,'Sukarman','Gedangan',4),(49,'Suyono','Gamping',4),(50,'Sutarji','Wates',4),(51,'Nugroho Agus Tawan','Pelem',4),(52,'Bondan Wiratmoko','Pojok',4),(53,'Moch. Syamsu Ridjal','Tanggung',4),(54,'Mualim','Campurdarat',4),(55,'Eko Alrijanto, Se','Kendal',17),(56,'Nanang Setiawan','Tawing',17),(57,'H. Gatot Suminto','Gondosilu',17),(58,'Sutikna','Dukuh',17),(59,'Sudarminto','Sepatan',17),(60,'Drs. M. Rubangi','Macanbang',17),(61,'Maryono','Kiping',17),(62,'Suharyani','Rejosari',17),(63,'Suwanto','Bendo',17),(64,'Yayuk Sri Rahayu','Ngrendeng',17),(65,'Sumarsono','Gondang',17),(66,'Siswoyo','Bendungan',17),(67,'Mustakim','Notorejo',17),(68,'Muri','Sidem',17),(69,'Mukar','Sidomulyo',17),(70,'Drs. Haryanto','Blendis',17),(71,'Arif Junedi, ST','Mojoarum',17),(72,'Asrori','Tiudan',17),(73,'Bambang Siswanto','Jarakan',17),(74,'Guwandi','Wonokromo',17),(75,'Widodo','Kalibatur',6),(76,'Drs. Midi Kuswantoro','Rejosari',6),(77,'Hadi Sutrisno, SP. MM','Banyuurip',6),(78,'Mudjo','Sukorejo Kulon',6),(79,'Sutejo','Winong',6),(80,'Supingi','Joho',6),(81,'Sumadi','Pakisaji',6),(82,'Drs. Agus Imam W','Karangtalun',6),(83,'Adi Pronoto','Kalidawir',6),(84,'Drs. Siswanto','Ngubalan',6),(85,'Syamsul Maarif','Salak Kembang',6),(86,'Drs. Nahrowi','Domasan',6),(87,'Djumari','Jabon',6),(88,'Harsono','Pagersari',6),(89,'Dra. Endang Zuliyati','Tunggangri',6),(90,'Drs. H. Mughni','Betak',6),(91,'Machin','Tanjung',6),(92,'Sunari','Plosokandang',13),(93,'Ir. Triko Iriyanto','Tunggulsari',13),(94,'Kartijo','Ringinpitu',13),(95,'Kusbani','Loderesan',13),(96,'Suwito','Bulusari',13),(97,'Leman Dwi P, SE','Bangoan',13),(98,'Moh. Soleh','Boro',13),(99,'Gunawan','Tapan',13),(100,'Njohadi','Rejoagung',13),(101,'Sugeng Mulyono','Kedungwaru',13),(102,'Mulyono','Plandaan',13),(103,'Masrur. Sag','Ketanon',13),(104,'Nur Muslim','Tawangsari',13),(105,'Wahyudi Rianto','Winong',13),(106,'Parwoto','Majan',13),(107,'Nur Rohman','Simo',13),(108,'H. Ahmad Choiri Huda','Gendingan',13),(109,'Eko Purnomo','Ngujang',13),(110,'Makin','Punjul',15),(111,'Karyono','Gedangan',15),(112,'Sidiq Ghofur','Sukowiyono',15),(113,'Deby Subiyantoro','Sembong',15),(114,'Hasan Malik','Jeli',15),(115,'Suharsono','Karangrejo',15),(116,'Arif Junedi, ST','Sukorejo',15),(117,'H. Makin','Sukodono',15),(118,'Haryani','Bungur',15),(119,'M. Nurul Huda, SP','Tanjungsari',15),(120,'Imam Suhadi','Sukowidodo',15),(121,'Suyitno','Babadan',15),(122,'Yusak','Tulungrejo',15),(123,'Kemis','Pucangan',16),(124,'Drs. Hurip Setiyadi','Balerejo',16),(125,'Kukuh Wahyono','Kalangbret',16),(126,'Suwarno','Bolorejo',16),(127,'Palil','Batangsaren',16),(128,'Dwi Utari Nurini','Panggungrejo',16),(129,'Danang Catur Budi Utomo, ST','Sidorejo',16),(130,'Robet Wahidi Wiyono','Mojosari',16),(131,'Yuniarti, SP.d','Karanganom',16),(132,'Gendut','Kates',16),(133,'Adi Sunawan','Banaran',16),(134,'Bekti Sasongko, ST','Jatimulyo',16),(135,'Imam Asrofi','Kauman',16),(161,'Bla bla bla','Desa bla bla',9),(162,'Mustangin','Pakel',14),(163,'Faton didik Hanafi','Pucunglor',14),(164,'Wiharyadi','Srikaton',14),(165,'Situr','Padangan',14),(166,'Purnomo','Banjarsari',14),(167,'Mulyono, ST','Pulerejo',14),(168,'Mujiono','Bendosari',14),(169,'Bambang S Wibowo','Ngantru',14),(170,'Winarsih, SP','Batokan',14),(171,'Mamik Retnowati, SH','Mojoagung',14),(172,'Drs. Jumani','Kepuhrejo',14),(173,'Sutaji','Pojok',14),(174,'H. Agus Syai','Pinggirsari',14),(175,'Dwi Sunarhadi','Kradinan',18),(176,'Suwoto','Segawe',18),(177,'Tarno','Penjor',18),(178,'Mujiarto','Gambiran',18),(179,'Baru Hardiono','Samar',18),(180,'Sunardi','Pagerwojo',18),(181,'Sabar sugianto','Mulyosari',18),(182,'Marsukamto','Sidomulyo',18),(183,'Basroni','Kedungcangkring',18),(184,'Katini','Gondanggunung',18),(185,'Sakur','Wonorejo',18),(186,'Agus Sucipto','Sambitan',3),(187,'Jakat','Bono',3),(188,'Sukarto','Sukoanyar',3),(189,'Setiono','Duwet',3),(190,'Muljadi','Tamban',3),(191,'Subriyanto','Ngebong',3),(192,'Drs. Resyanto','Sodo',3),(193,'Wiwik Rodijah','Gombang',3),(194,'Unang Hardoyo','Pakel',3),(195,'Muhlisin','Suwaluh',3),(196,'Muanam','Pecuk',3),(197,'Moh. Syafii','Bangunmulyo',3),(198,'Sasmito.S','Kasreman',3),(199,'Kastubi, SH','Sanan',3),(200,'Drs. Endi Sumarna','Bangunjaya',3),(201,'Slamet','Ngrance',3),(202,'Supriyono','Gebang',3),(203,'Isroful Mustofa','Gempolan',3),(204,'Nurhadi Setiawan','Gesikan',3),(205,'Surani Al Djiman','Panggungsalak',7),(206,'Agus Sumani','Kalidawe',7),(207,'Tulus','Pucanglaban',7),(208,'Surani Gandos','Sumberbendo',7),(209,'Sholeh Hasan','Kaligentong',7),(210,'Sumiran','Manding',7),(211,'Sutoyo, S.Pd, MM','Sumberdadap',7),(212,'Roliyah','Panggunguni',7),(213,'Slamet Rianto','Demuk',7),(214,'Ahmad samsul','Tenggur',8),(215,'Minowati','Panjarejo',8),(216,'Hariyanto','Karangsari',8),(217,'Rantinah','Tugu',8),(218,'Susanto','Sukorejo wetan',8),(219,'Mahmud','Jatidowo',8),(220,'Imam Robangi, BA','Banjarejo',8),(221,'Tohir','Tanen',8),(222,'Sukadi, S.Sos','Sumberagung',8),(223,'Kamid','Blimbing',8),(224,'Ir. Atmadi Siswoyo','Rejotangan',8),(225,'Drs. Waras Harsono','Pakisrejo',8),(226,'Diana Kolidah','Tegalrejo',8),(227,'Sugeng','Aryojeding',8),(228,'Bambang Siswanto','Tenggong',8),(229,'Komari','Buntaran',8),(230,'Trimo','Kedoyo',19),(231,'Latip','Nglutung',19),(232,'suparlin','Talang',19),(233,'Muselam','Picisan',19),(234,'Tutik Purwitosari','Tugu',19),(235,'H. Sabar','Nyawangan',19),(236,'Suwarto','Sendang',19),(237,'Seran','Nglurup',19),(238,'Srianah','geger',19),(239,'Priyambodo','Dono',19),(240,'Muhaimin','Krosok',19),(241,'Winarsih, SPd','Junjung',10),(242,'Tamyis','Podorejo',10),(243,'Djani','Wates',10),(244,'Siti Romelah','Sambidoplang',10),(245,'Kristina. D','Mirigambar',10),(246,'Drs. Moh Tohir','Bendiljati Kulon',10),(247,'Sukani Gunawan. B','Bendiljati Wetan',10),(248,'Murjana','Trenceng',10),(249,'Moh. Soleh','Bendilwungu',10),(250,'Haryono','Sambijajar',10),(251,'Widayat, S.Pd','Tambakrejo',10),(252,'Agus Muhaji','Doroampel',10),(253,'H. Bambang Setyono','Wonorejo',10),(254,'Sri Ismiatin','Sumberdadi',10),(255,'M. Akris Riyanto','Sambirobyong',10),(256,'Sunarti','Jabalsari',10),(257,'Mohammad Jiko','Bukur',10),(258,'Sunar','Kresikan',5),(259,'Sumari','Jengglungharjo',5),(260,'Sumardi Spd','Ngrejo',5),(261,'Mudjito','Tenggarejo',5),(262,'Supriyono, S.Pd','Tanggunggunung',5),(263,'Soekadji','Pakisrejo',5),(264,'Agus','Ngepoh',5),(265,'aaaaa','Tertek',12),(266,'aaaaa','Kutoanyar',12),(267,'aaaaa','Kauman',12),(268,'aaaaa','Kampungdalem',12),(269,'aaaaa','Karangwaru',12),(270,'aaaaa','Kedungsuko',12),(271,'aaaaa','Kepatihan',12),(272,'aaaaa','Bago',12),(273,'aaaaa','Jepun',12),(274,'aaaaa','Kenayan',12),(275,'aaaaa','Sembung',12),(276,'aaaaa','Botoran',12),(277,'aaaaa','Tamanan',12),(278,'aaaaa','Panggungrejo',12);
/*!40000 ALTER TABLE `kelurahan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nikcounter`
--

DROP TABLE IF EXISTS `nikcounter`;
CREATE TABLE `nikcounter` (
  `id` int(11) NOT NULL auto_increment,
  `kecamatan_id` int(11) NOT NULL,
  `tanggal` datetime default NULL,
  `counter` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nikcounter`
--

LOCK TABLES `nikcounter` WRITE;
/*!40000 ALTER TABLE `nikcounter` DISABLE KEYS */;
INSERT INTO `nikcounter` VALUES (3,4,'1982-10-11 00:00:00',1),(4,4,'1979-10-11 00:00:00',1),(5,5,'2009-11-01 00:00:00',1),(6,10,'2009-11-15 00:00:00',1),(7,4,'2009-11-01 00:00:00',1),(8,4,'1977-10-16 00:00:00',2),(9,4,'1983-10-16 00:00:00',2),(10,4,'1980-10-16 00:00:00',1),(11,1,'1983-11-15 00:00:00',2),(12,1,'1981-11-15 00:00:00',1),(13,4,'1985-11-15 00:00:00',1),(14,4,'1981-11-15 00:00:00',1);
/*!40000 ALTER TABLE `nikcounter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orang_tua`
--

DROP TABLE IF EXISTS `orang_tua`;
CREATE TABLE `orang_tua` (
  `id` int(11) NOT NULL auto_increment,
  `bapak_id` int(11) default NULL,
  `ibu_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_orang_tua_ayah` (`bapak_id`),
  KEY `FK_orang_tua_ibu` (`ibu_id`),
  CONSTRAINT `FK_orang_tua_ayah` FOREIGN KEY (`bapak_id`) REFERENCES `penduduk` (`id`),
  CONSTRAINT `FK_orang_tua_ibu` FOREIGN KEY (`ibu_id`) REFERENCES `penduduk` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `orang_tua`
--

LOCK TABLES `orang_tua` WRITE;
/*!40000 ALTER TABLE `orang_tua` DISABLE KEYS */;
INSERT INTO `orang_tua` VALUES (1,4,3);
/*!40000 ALTER TABLE `orang_tua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pekerjaan`
--

DROP TABLE IF EXISTS `pekerjaan`;
CREATE TABLE `pekerjaan` (
  `id` int(11) NOT NULL auto_increment,
  `pekerjaan` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pekerjaan`
--

LOCK TABLES `pekerjaan` WRITE;
/*!40000 ALTER TABLE `pekerjaan` DISABLE KEYS */;
INSERT INTO `pekerjaan` VALUES (0,'-'),(1,'Tani'),(2,'Guru'),(3,'Dagang'),(4,'Nelayan'),(5,'Wiraswasta'),(6,'PNS'),(7,'Lainnya');
/*!40000 ALTER TABLE `pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendidikan`
--

DROP TABLE IF EXISTS `pendidikan`;
CREATE TABLE `pendidikan` (
  `id` int(11) NOT NULL auto_increment,
  `pendidikan` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pendidikan`
--

LOCK TABLES `pendidikan` WRITE;
/*!40000 ALTER TABLE `pendidikan` DISABLE KEYS */;
INSERT INTO `pendidikan` VALUES (0,'-'),(1,'SD'),(2,'Tidak Tamat SD'),(3,'SLTP'),(4,'SLTA'),(5,'D1'),(6,'D2'),(7,'D3'),(8,'Sarjana'),(9,'Lainnya');
/*!40000 ALTER TABLE `pendidikan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penduduk`
--

DROP TABLE IF EXISTS `penduduk`;
CREATE TABLE `penduduk` (
  `id` int(11) NOT NULL auto_increment,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `status_hub_kel` enum('Nenek','Kakek','Mertua','Menantu','Anak','Istri','Kepala Keluarga') default NULL,
  `tmp_lahir` varchar(255) default '',
  `tgl_lahir` date default NULL,
  `pendidikan_id` int(11) default '0',
  `pekerjaan_id` int(11) default '0',
  `penghasilan` int(11) default '0',
  `gol_darah` enum('AB','O','B','-','A') default NULL,
  `agama_id` int(11) default '0',
  `orangtua_id` int(11) default NULL,
  `wni` enum('WNA','WNI') default NULL,
  `status_nikah` enum('Duda','Janda','Tidak kawin','Kawin') NOT NULL default 'Tidak kawin',
  `jenis_kelamin` enum('Perempuan','Laki-laki') NOT NULL default 'Perempuan',
  `keluarga_id` int(11) default NULL,
  `kb_id` int(11) default '0',
  `keterangan` text,
  `photo` varchar(255) default '',
  `wafat` date default NULL,
  `no_formulir` varchar(255) default NULL,
  `masa_berlaku` date default NULL,
  `no_surat_kematian` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `penduduk`
--

LOCK TABLES `penduduk` WRITE;
/*!40000 ALTER TABLE `penduduk` DISABLE KEYS */;
INSERT INTO `penduduk` VALUES (3,'3504045110820001','mariska','Istri','Tulungagung','1982-10-11',1,1,0,'O',1,NULL,'WNI','Kawin','Perempuan',1,NULL,NULL,'3.jpg',NULL,NULL,NULL,NULL),(4,'3504041110790001','joni','Kepala Keluarga','Tulungagung','1979-10-11',1,1,0,'B',1,NULL,'WNI','Kawin','Laki-laki',1,NULL,NULL,'',NULL,NULL,NULL,NULL),(11,'3504015511830002','Nana','Anak','Tulungagung','1983-11-15',0,0,0,'AB',0,1,NULL,'Tidak kawin','Perempuan',1,0,NULL,'',NULL,NULL,NULL,NULL),(12,'3504041511810001','Fuad','Kepala Keluarga','Tulungagung','1981-11-15',0,0,0,'AB',0,1,'WNA','Kawin','Laki-laki',2,0,NULL,'',NULL,NULL,NULL,NULL),(13,'3504041511850001','Joko','Anak','Tulungagung','1985-11-15',0,0,0,'B',0,1,NULL,'Tidak kawin','Laki-laki',1,0,NULL,'',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `penduduk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pernikahan`
--

DROP TABLE IF EXISTS `pernikahan`;
CREATE TABLE `pernikahan` (
  `id` int(11) NOT NULL auto_increment,
  `pria` int(11) default NULL,
  `wanita` int(11) default NULL,
  `saksi1` int(11) default NULL,
  `saksi2` int(11) default NULL,
  `penghulu` varchar(80) default NULL,
  `tanggal` date default NULL,
  `wali` varchar(80) default NULL,
  `kecamatan_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pernikahan`
--

LOCK TABLES `pernikahan` WRITE;
/*!40000 ALTER TABLE `pernikahan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pernikahan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pindah_alamat`
--

DROP TABLE IF EXISTS `pindah_alamat`;
CREATE TABLE `pindah_alamat` (
  `id` int(11) NOT NULL auto_increment,
  `penduduk_id` int(11) NOT NULL,
  `tgl_pindah` date NOT NULL,
  `kk_id_lama` varchar(16) NOT NULL,
  `kk_id_baru` varchar(16) NOT NULL,
  `keterangan` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_pindah_alamat_penduduk` (`penduduk_id`),
  CONSTRAINT `FK_pindah_alamat_penduduk` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pindah_alamat`
--

LOCK TABLES `pindah_alamat` WRITE;
/*!40000 ALTER TABLE `pindah_alamat` DISABLE KEYS */;
/*!40000 ALTER TABLE `pindah_alamat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(80) default NULL,
  `type_value` enum('varchar','int','datetime','date','double') default 'varchar',
  `varchar_value` varchar(80) default NULL,
  `int_value` int(11) default NULL,
  `datetime_value` datetime default NULL,
  `date_value` date default NULL,
  `double_value` double default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'kepala_capil','varchar','Heru',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_users` (`group_id`),
  CONSTRAINT `FK_users` FOREIGN KEY (`group_id`) REFERENCES `access_groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','*4ACFE3202A5FF5CF467898FC58AAB1D615029441',1),(2,'joko','*312278CF7EA1A410C33E970BB3F3793F9E92C0CD',2),(3,'cap','*3A22E5B301EDD82AE2F0DEC49B9FBE5403EEBB89',3),(4,'kua','*6E4700B974A472F1F3D448BA2E70471142711E1C',4);
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

-- Dump completed on 2009-11-17  9:29:37
