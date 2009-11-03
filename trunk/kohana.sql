-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 03, 2009 at 08:01 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `kohana`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_groups`
--

CREATE TABLE IF NOT EXISTS `access_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Dumping data for table `access_groups`
--

INSERT INTO `access_groups` (`id`, `name`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `agama`
--

CREATE TABLE IF NOT EXISTS `agama` (
  `id` int(11) NOT NULL auto_increment,
  `agama` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=8 ;

--
-- Dumping data for table `agama`
--

INSERT INTO `agama` (`id`, `agama`) VALUES
(1, 'Islam'),
(2, 'Katholik'),
(3, 'Protestan'),
(4, 'Hindu'),
(5, 'Budha'),
(6, 'Konghucu'),
(7, 'resrsr');

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE IF NOT EXISTS `alamat` (
  `id` int(11) NOT NULL auto_increment,
  `alamat` varchar(255) default NULL,
  `rukun_tetangga` int(11) default NULL,
  `rukun_warga` int(11) default NULL,
  `kelurahan_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_alamat_kelurahan` (`kelurahan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `alamat`
--


-- --------------------------------------------------------

--
-- Table structure for table `group_details`
--

CREATE TABLE IF NOT EXISTS `group_details` (
  `id` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `table` varchar(70) NOT NULL,
  `field` varchar(70) NOT NULL,
  `create` int(1) NOT NULL default '0',
  `update` int(1) NOT NULL default '0',
  `delete` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `FK_group_details_access` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `group_details`
--


-- --------------------------------------------------------

--
-- Table structure for table `kb`
--

CREATE TABLE IF NOT EXISTS `kb` (
  `id` int(11) NOT NULL auto_increment,
  `kb` varchar(40) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- Dumping data for table `kb`
--

INSERT INTO `kb` (`id`, `kb`) VALUES
(1, 'IUD'),
(2, 'Spiral'),
(3, 'Pil');

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE IF NOT EXISTS `kecamatan` (
  `id` int(11) NOT NULL auto_increment,
  `kd_wilayah` varchar(7) NOT NULL,
  `camat` varchar(255) default NULL,
  `nama_kecamatan` varchar(255) NOT NULL,
  `kodepos` varchar(5) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=20 ;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `kd_wilayah`, `camat`, `nama_kecamatan`, `kodepos`) VALUES
(1, '3504010', 'SUDARMAJI, S.Sos', 'Besuki', '66275'),
(2, '3504020', 'Drs. SUKADHI, M.Si', 'Bandung', '66274'),
(3, '3504030', 'Drs. TRANGGONO DIBYOHARSONO', 'Pakel', '66273'),
(4, '3504040', 'ISWAHYUDI', 'Campurdarat', '66272'),
(5, '3504050', 'DJANOE SOEKITO', 'Tanggunggunung', '66283'),
(6, '3504060', 'H. SYAMSUL LAILY, SH', 'Kalidawir', '66281'),
(7, '3504070', 'TRI WANTORO S.Sos', 'Pucanglaban', '66284'),
(8, '3504080', 'Drs. ARIEF BOEDIONO, MSi', 'Rejotangan', '66293'),
(9, '3504090', 'Drs. MOHAMAD ACHWAN', 'Ngunut', '66292'),
(10, '3504100', 'H. MUDAWAM, SH.', 'Sumbergempol', '66291'),
(11, '3504110', 'SOEROTO, S.Sos', 'Boyolangu', '66271'),
(12, '3504120', 'Dra. SUHARMIYATI ,M.Si', 'Tulungagung', '66211'),
(13, '3504130', 'Drs. SUGIANTO, MM', 'Kedungwaru', '66226'),
(14, '3504140', 'Drs. TRI HARIADI', 'Ngantru', '66252'),
(15, '3504150', 'Drs. BUDI FATAHILLAH', 'Karangrejo', '66253'),
(16, '3504160', 'Drs. HERU SANTOSA', 'Kauman', '66261'),
(17, '3504170', 'Drs. YASID BASTOMI', 'Gondang', '66263'),
(18, '3504180', 'Drs. SUGITO,M.Si', 'Pagerwojo', '66262'),
(19, '3504190', 'Drs. MOCH. HANAFI', 'Sendang', '66254');

-- --------------------------------------------------------

--
-- Table structure for table `keluarga`
--

CREATE TABLE IF NOT EXISTS `keluarga` (
  `id` int(11) NOT NULL auto_increment,
  `kode_keluarga` varchar(16) NOT NULL,
  `alamat_id` int(11) NOT NULL,
  `no_formulir` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_keluarga_alamat` (`alamat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `keluarga`
--


-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE IF NOT EXISTS `kelurahan` (
  `id` int(11) NOT NULL auto_increment,
  `lurah` varchar(255) NOT NULL default '',
  `nama_kelurahan` varchar(255) NOT NULL default '',
  `kecamatan_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_kelurahan_kecamatan` (`kecamatan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=279 ;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id`, `lurah`, `nama_kelurahan`, `kecamatan_id`) VALUES
(1, 'Martoyo, Spd', 'Bantengan', 2),
(2, 'R. Endro Rianto, S. Kep. Nera', 'Soko', 2),
(3, 'Drs. H. A. Kasim', 'Ngepeh', 2),
(4, 'Suyatno', 'Sebalor', 2),
(5, 'Muserin', 'Tulunkulon', 2),
(6, 'H. M. Sakuran', 'Bandung', 2),
(7, 'Mujiati', 'Ngunggahan', 2),
(8, 'Marhudi', 'Mergayu', 2),
(9, 'Maryono, S.pd', 'Kedungwilut', 2),
(10, 'Subandi', 'Nglampir', 2),
(11, 'Suroso', 'Sukoharjo', 2),
(12, 'Amawati, A. Ma', 'Suruhan Lor', 2),
(13, 'H. Imam Suryani, Sp.d', 'Kesambi', 2),
(14, 'H. Masingut', 'Singgit', 2),
(15, 'Mulyono', 'Gondang', 2),
(16, 'Toha Mahsun', 'Suwaru', 2),
(17, 'Karmen', 'Bulus', 2),
(18, 'Setianto', 'Suruhan Kidul', 2),
(19, 'Widoto', 'Besole', 1),
(20, 'Sihadji', 'Besuki', 1),
(21, 'Agus Utomo', 'Tanggulwelehan', 1),
(22, 'Supriyo Bondowo', 'Kebonireng', 1),
(23, 'Supri Astuti', 'Tanggulterus', 1),
(24, 'Zaenal Arifin', 'Sedayugunung', 1),
(25, 'Mulyadi, S.Pd', 'Tanggulkundung', 1),
(26, 'Imam Sapingi', 'Watenkroyo', 1),
(27, 'Djoko Sugiono', 'Siyotobagus', 1),
(28, 'Sukardi', 'Tulungrejo', 1),
(29, 'Joko Sinung', 'Moyoketen', 11),
(30, 'Moedjito', 'Waung', 11),
(31, 'Drs. Suharno', 'Sanggrahan', 11),
(32, 'H. Karjanto', 'Beji', 11),
(33, 'Suyitno', 'Serut', 11),
(34, 'Eko Prisdianto', 'Kendal Bulur', 11),
(35, 'Slamet', 'Kepuh', 11),
(36, 'Samudji', 'Ngranti', 11),
(37, 'Sumarno', 'Wajak Lor', 11),
(38, 'Drs. Sudjangi', 'Karangrejo', 11),
(39, 'Mohammad Rifai', 'Tanjungsari', 11),
(40, 'Sukemi', 'Pucungkidul', 11),
(41, 'Muhari', 'Boyolangu', 11),
(42, 'Mahfud Sokip', 'Subontoro', 11),
(43, 'Moch. Moezamil, S.Sos', 'Bono', 11),
(44, 'Supayati', 'Wajak Kidul', 11),
(45, 'Sunarto', 'Gedangsewu', 11),
(46, 'Mudjito', 'Ngentrong', 4),
(47, 'Warsito', 'Sawo', 4),
(48, 'Sukarman', 'Gedangan', 4),
(49, 'Suyono', 'Gamping', 4),
(50, 'Sutarji', 'Wates', 4),
(51, 'Nugroho Agus Tawan', 'Pelem', 4),
(52, 'Bondan Wiratmoko', 'Pojok', 4),
(53, 'Moch. Syamsu Ridjal', 'Tanggung', 4),
(54, 'Mualim', 'Campurdarat', 4),
(55, 'Eko Alrijanto, Se', 'Kendal', 17),
(56, 'Nanang Setiawan', 'Tawing', 17),
(57, 'H. Gatot Suminto', 'Gondosilu', 17),
(58, 'Sutikna', 'Dukuh', 17),
(59, 'Sudarminto', 'Sepatan', 17),
(60, 'Drs. M. Rubangi', 'Macanbang', 17),
(61, 'Maryono', 'Kiping', 17),
(62, 'Suharyani', 'Rejosari', 17),
(63, 'Suwanto', 'Bendo', 17),
(64, 'Yayuk Sri Rahayu', 'Ngrendeng', 17),
(65, 'Sumarsono', 'Gondang', 17),
(66, 'Siswoyo', 'Bendungan', 17),
(67, 'Mustakim', 'Notorejo', 17),
(68, 'Muri', 'Sidem', 17),
(69, 'Mukar', 'Sidomulyo', 17),
(70, 'Drs. Haryanto', 'Blendis', 17),
(71, 'Arif Junedi, ST', 'Mojoarum', 17),
(72, 'Asrori', 'Tiudan', 17),
(73, 'Bambang Siswanto', 'Jarakan', 17),
(74, 'Guwandi', 'Wonokromo', 17),
(75, 'Widodo', 'Kalibatur', 6),
(76, 'Drs. Midi Kuswantoro', 'Rejosari', 6),
(77, 'Hadi Sutrisno, SP. MM', 'Banyuurip', 6),
(78, 'Mudjo', 'Sukorejo Kulon', 6),
(79, 'Sutejo', 'Winong', 6),
(80, 'Supingi', 'Joho', 6),
(81, 'Sumadi', 'Pakisaji', 6),
(82, 'Drs. Agus Imam W', 'Karangtalun', 6),
(83, 'Adi Pronoto', 'Kalidawir', 6),
(84, 'Drs. Siswanto', 'Ngubalan', 6),
(85, 'Syamsul Maarif', 'Salak Kembang', 6),
(86, 'Drs. Nahrowi', 'Domasan', 6),
(87, 'Djumari', 'Jabon', 6),
(88, 'Harsono', 'Pagersari', 6),
(89, 'Dra. Endang Zuliyati', 'Tunggangri', 6),
(90, 'Drs. H. Mughni', 'Betak', 6),
(91, 'Machin', 'Tanjung', 6),
(92, 'Sunari', 'Plosokandang', 13),
(93, 'Ir. Triko Iriyanto', 'Tunggulsari', 13),
(94, 'Kartijo', 'Ringinpitu', 13),
(95, 'Kusbani', 'Loderesan', 13),
(96, 'Suwito', 'Bulusari', 13),
(97, 'Leman Dwi P, SE', 'Bangoan', 13),
(98, 'Moh. Soleh', 'Boro', 13),
(99, 'Gunawan', 'Tapan', 13),
(100, 'Njohadi', 'Rejoagung', 13),
(101, 'Sugeng Mulyono', 'Kedungwaru', 13),
(102, 'Mulyono', 'Plandaan', 13),
(103, 'Masrur. Sag', 'Ketanon', 13),
(104, 'Nur Muslim', 'Tawangsari', 13),
(105, 'Wahyudi Rianto', 'Winong', 13),
(106, 'Parwoto', 'Majan', 13),
(107, 'Nur Rohman', 'Simo', 13),
(108, 'H. Ahmad Choiri Huda', 'Gendingan', 13),
(109, 'Eko Purnomo', 'Ngujang', 13),
(110, 'Makin', 'Punjul', 15),
(111, 'Karyono', 'Gedangan', 15),
(112, 'Sidiq Ghofur', 'Sukowiyono', 15),
(113, 'Deby Subiyantoro', 'Sembong', 15),
(114, 'Hasan Malik', 'Jeli', 15),
(115, 'Suharsono', 'Karangrejo', 15),
(116, 'Arif Junedi, ST', 'Sukorejo', 15),
(117, 'H. Makin', 'Sukodono', 15),
(118, 'Haryani', 'Bungur', 15),
(119, 'M. Nurul Huda, SP', 'Tanjungsari', 15),
(120, 'Imam Suhadi', 'Sukowidodo', 15),
(121, 'Suyitno', 'Babadan', 15),
(122, 'Yusak', 'Tulungrejo', 15),
(123, 'Kemis', 'Pucangan', 16),
(124, 'Drs. Hurip Setiyadi', 'Balerejo', 16),
(125, 'Kukuh Wahyono', 'Kalangbret', 16),
(126, 'Suwarno', 'Bolorejo', 16),
(127, 'Palil', 'Batangsaren', 16),
(128, 'Dwi Utari Nurini', 'Panggungrejo', 16),
(129, 'Danang Catur Budi Utomo, ST', 'Sidorejo', 16),
(130, 'Robet Wahidi Wiyono', 'Mojosari', 16),
(131, 'Yuniarti, SP.d', 'Karanganom', 16),
(132, 'Gendut', 'Kates', 16),
(133, 'Adi Sunawan', 'Banaran', 16),
(134, 'Bekti Sasongko, ST', 'Jatimulyo', 16),
(135, 'Imam Asrofi', 'Kauman', 16),
(161, 'Bla bla bla', 'Desa bla bla', 9),
(162, 'Mustangin', 'Pakel', 14),
(163, 'Faton didik Hanafi', 'Pucunglor', 14),
(164, 'Wiharyadi', 'Srikaton', 14),
(165, 'Situr', 'Padangan', 14),
(166, 'Purnomo', 'Banjarsari', 14),
(167, 'Mulyono, ST', 'Pulerejo', 14),
(168, 'Mujiono', 'Bendosari', 14),
(169, 'Bambang S Wibowo', 'Ngantru', 14),
(170, 'Winarsih, SP', 'Batokan', 14),
(171, 'Mamik Retnowati, SH', 'Mojoagung', 14),
(172, 'Drs. Jumani', 'Kepuhrejo', 14),
(173, 'Sutaji', 'Pojok', 14),
(174, 'H. Agus Syai', 'Pinggirsari', 14),
(175, 'Dwi Sunarhadi', 'Kradinan', 18),
(176, 'Suwoto', 'Segawe', 18),
(177, 'Tarno', 'Penjor', 18),
(178, 'Mujiarto', 'Gambiran', 18),
(179, 'Baru Hardiono', 'Samar', 18),
(180, 'Sunardi', 'Pagerwojo', 18),
(181, 'Sabar sugianto', 'Mulyosari', 18),
(182, 'Marsukamto', 'Sidomulyo', 18),
(183, 'Basroni', 'Kedungcangkring', 18),
(184, 'Katini', 'Gondanggunung', 18),
(185, 'Sakur', 'Wonorejo', 18),
(186, 'Agus Sucipto', 'Sambitan', 3),
(187, 'Jakat', 'Bono', 3),
(188, 'Sukarto', 'Sukoanyar', 3),
(189, 'Setiono', 'Duwet', 3),
(190, 'Muljadi', 'Tamban', 3),
(191, 'Subriyanto', 'Ngebong', 3),
(192, 'Drs. Resyanto', 'Sodo', 3),
(193, 'Wiwik Rodijah', 'Gombang', 3),
(194, 'Unang Hardoyo', 'Pakel', 3),
(195, 'Muhlisin', 'Suwaluh', 3),
(196, 'Muanam', 'Pecuk', 3),
(197, 'Moh. Syafii', 'Bangunmulyo', 3),
(198, 'Sasmito.S', 'Kasreman', 3),
(199, 'Kastubi, SH', 'Sanan', 3),
(200, 'Drs. Endi Sumarna', 'Bangunjaya', 3),
(201, 'Slamet', 'Ngrance', 3),
(202, 'Supriyono', 'Gebang', 3),
(203, 'Isroful Mustofa', 'Gempolan', 3),
(204, 'Nurhadi Setiawan', 'Gesikan', 3),
(205, 'Surani Al Djiman', 'Panggungsalak', 7),
(206, 'Agus Sumani', 'Kalidawe', 7),
(207, 'Tulus', 'Pucanglaban', 7),
(208, 'Surani Gandos', 'Sumberbendo', 7),
(209, 'Sholeh Hasan', 'Kaligentong', 7),
(210, 'Sumiran', 'Manding', 7),
(211, 'Sutoyo, S.Pd, MM', 'Sumberdadap', 7),
(212, 'Roliyah', 'Panggunguni', 7),
(213, 'Slamet Rianto', 'Demuk', 7),
(214, 'Ahmad samsul', 'Tenggur', 8),
(215, 'Minowati', 'Panjarejo', 8),
(216, 'Hariyanto', 'Karangsari', 8),
(217, 'Rantinah', 'Tugu', 8),
(218, 'Susanto', 'Sukorejo wetan', 8),
(219, 'Mahmud', 'Jatidowo', 8),
(220, 'Imam Robangi, BA', 'Banjarejo', 8),
(221, 'Tohir', 'Tanen', 8),
(222, 'Sukadi, S.Sos', 'Sumberagung', 8),
(223, 'Kamid', 'Blimbing', 8),
(224, 'Ir. Atmadi Siswoyo', 'Rejotangan', 8),
(225, 'Drs. Waras Harsono', 'Pakisrejo', 8),
(226, 'Diana Kolidah', 'Tegalrejo', 8),
(227, 'Sugeng', 'Aryojeding', 8),
(228, 'Bambang Siswanto', 'Tenggong', 8),
(229, 'Komari', 'Buntaran', 8),
(230, 'Trimo', 'Kedoyo', 19),
(231, 'Latip', 'Nglutung', 19),
(232, 'suparlin', 'Talang', 19),
(233, 'Muselam', 'Picisan', 19),
(234, 'Tutik Purwitosari', 'Tugu', 19),
(235, 'H. Sabar', 'Nyawangan', 19),
(236, 'Suwarto', 'Sendang', 19),
(237, 'Seran', 'Nglurup', 19),
(238, 'Srianah', 'geger', 19),
(239, 'Priyambodo', 'Dono', 19),
(240, 'Muhaimin', 'Krosok', 19),
(241, 'Winarsih, SPd', 'Junjung', 10),
(242, 'Tamyis', 'Podorejo', 10),
(243, 'Djani', 'Wates', 10),
(244, 'Siti Romelah', 'Sambidoplang', 10),
(245, 'Kristina. D', 'Mirigambar', 10),
(246, 'Drs. Moh Tohir', 'Bendiljati Kulon', 10),
(247, 'Sukani Gunawan. B', 'Bendiljati Wetan', 10),
(248, 'Murjana', 'Trenceng', 10),
(249, 'Moh. Soleh', 'Bendilwungu', 10),
(250, 'Haryono', 'Sambijajar', 10),
(251, 'Widayat, S.Pd', 'Tambakrejo', 10),
(252, 'Agus Muhaji', 'Doroampel', 10),
(253, 'H. Bambang Setyono', 'Wonorejo', 10),
(254, 'Sri Ismiatin', 'Sumberdadi', 10),
(255, 'M. Akris Riyanto', 'Sambirobyong', 10),
(256, 'Sunarti', 'Jabalsari', 10),
(257, 'Mohammad Jiko', 'Bukur', 10),
(258, 'Sunar', 'Kresikan', 5),
(259, 'Sumari', 'Jengglungharjo', 5),
(260, 'Sumardi Spd', 'Ngrejo', 5),
(261, 'Mudjito', 'Tenggarejo', 5),
(262, 'Supriyono, S.Pd', 'Tanggunggunung', 5),
(263, 'Soekadji', 'Pakisrejo', 5),
(264, 'Agus', 'Ngepoh', 5),
(265, 'aaaaa', 'Tertek', 12),
(266, 'aaaaa', 'Kutoanyar', 12),
(267, 'aaaaa', 'Kauman', 12),
(268, 'aaaaa', 'Kampungdalem', 12),
(269, 'aaaaa', 'Karangwaru', 12),
(270, 'aaaaa', 'Kedungsuko', 12),
(271, 'aaaaa', 'Kepatihan', 12),
(272, 'aaaaa', 'Bago', 12),
(273, 'aaaaa', 'Jepun', 12),
(274, 'aaaaa', 'Kenayan', 12),
(275, 'aaaaa', 'Sembung', 12),
(276, 'aaaaa', 'Botoran', 12),
(277, 'aaaaa', 'Tamanan', 12),
(278, 'aaaaa', 'Panggungrejo', 12);

-- --------------------------------------------------------

--
-- Table structure for table `orang_tua`
--

CREATE TABLE IF NOT EXISTS `orang_tua` (
  `id` int(11) NOT NULL auto_increment,
  `bapak_id` int(11) NOT NULL,
  `ibu_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_orang_tua_ayah` (`bapak_id`),
  KEY `FK_orang_tua_ibu` (`ibu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `orang_tua`
--


-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE IF NOT EXISTS `pekerjaan` (
  `id` int(11) NOT NULL auto_increment,
  `pekerjaan` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id`, `pekerjaan`) VALUES
(1, 'Tani'),
(2, 'Guru'),
(3, 'Dagang'),
(4, 'Nelayan'),
(5, 'Wiraswasta'),
(6, 'PNS'),
(7, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE IF NOT EXISTS `pendidikan` (
  `id` int(11) NOT NULL auto_increment,
  `pendidikan` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=10 ;

--
-- Dumping data for table `pendidikan`
--

INSERT INTO `pendidikan` (`id`, `pendidikan`) VALUES
(1, 'SD'),
(2, 'Tidak Tamat SD'),
(3, 'SLTP'),
(4, 'SLTA'),
(5, 'D1'),
(6, 'D2'),
(7, 'D3'),
(8, 'Sarjana'),
(9, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `penduduk`
--

CREATE TABLE IF NOT EXISTS `penduduk` (
  `id` int(11) NOT NULL auto_increment,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `status_hub_kel` enum('Nenek','Kakek','Mertua','Menantu','Anak','Istri','Kepala Keluarga') default NULL,
  `tmp_lahir` varchar(255) default '',
  `tgl_lahir` date default NULL,
  `pendidikan_id` int(11) default NULL,
  `pekerjaan_id` int(11) default NULL,
  `gol_darah` enum('AB','O','B','-','A') default NULL,
  `agama_id` int(11) default NULL,
  `orangtua_id` int(11) default NULL,
  `wni` enum('WNA','WNI') default NULL,
  `status_nikah` enum('Duda','Janda','Tidak kawin','Kawin') NOT NULL default 'Tidak kawin',
  `jenis_kelamin` enum('Perempuan','Laki-laki') NOT NULL default 'Perempuan',
  `keluarga_id` int(11) default NULL,
  `kb_id` int(11) default NULL,
  `keterangan` text,
  `photo` varchar(255) default '',
  `wafat` date default NULL,
  `no_formulir` varchar(255) default NULL,
  `masa_berlaku` date default NULL,
  `no_surat_kematian` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_penduduk` (`pekerjaan_id`),
  KEY `FK_penduduk_agama` (`agama_id`),
  KEY `FK_penduduk_kb` (`kb_id`),
  KEY `FK_penduduk_pendidikan` (`pendidikan_id`),
  KEY `FK_penduduk_keluarga` (`keluarga_id`),
  KEY `FK_penduduk_ortu` (`orangtua_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `penduduk`
--


-- --------------------------------------------------------

--
-- Table structure for table `pindah_alamat`
--

CREATE TABLE IF NOT EXISTS `pindah_alamat` (
  `id` int(11) NOT NULL,
  `penduduk_id` int(11) NOT NULL,
  `tgl_pindah` date NOT NULL,
  `alamat_id_lama` int(11) default NULL,
  `alamat_id_baru` int(11) default NULL,
  `keterangan` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_pindah_alamat_penduduk` (`penduduk_id`),
  KEY `FK_pindah_alamat_lama` (`alamat_id_lama`),
  KEY `FK_pindah_alamat_baru` (`alamat_id_baru`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pindah_alamat`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_users` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `group_id`) VALUES
(1, 'admin', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamat`
--
ALTER TABLE `alamat`
  ADD CONSTRAINT `FK_alamat_kelurahan` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`);

--
-- Constraints for table `group_details`
--
ALTER TABLE `group_details`
  ADD CONSTRAINT `FK_group_details_access` FOREIGN KEY (`group_id`) REFERENCES `access_groups` (`id`);

--
-- Constraints for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD CONSTRAINT `FK_keluarga_alamat` FOREIGN KEY (`alamat_id`) REFERENCES `alamat` (`id`);

--
-- Constraints for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `FK_kelurahan_kecamatan` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`);

--
-- Constraints for table `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD CONSTRAINT `FK_orang_tua_ayah` FOREIGN KEY (`bapak_id`) REFERENCES `penduduk` (`id`),
  ADD CONSTRAINT `FK_orang_tua_ibu` FOREIGN KEY (`ibu_id`) REFERENCES `penduduk` (`id`);

--
-- Constraints for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD CONSTRAINT `FK_penduduk` FOREIGN KEY (`pekerjaan_id`) REFERENCES `pekerjaan` (`id`),
  ADD CONSTRAINT `FK_penduduk_agama` FOREIGN KEY (`agama_id`) REFERENCES `agama` (`id`),
  ADD CONSTRAINT `FK_penduduk_kb` FOREIGN KEY (`kb_id`) REFERENCES `kb` (`id`),
  ADD CONSTRAINT `FK_penduduk_keluarga` FOREIGN KEY (`keluarga_id`) REFERENCES `keluarga` (`id`),
  ADD CONSTRAINT `FK_penduduk_ortu` FOREIGN KEY (`orangtua_id`) REFERENCES `orang_tua` (`id`),
  ADD CONSTRAINT `FK_penduduk_pendidikan` FOREIGN KEY (`pendidikan_id`) REFERENCES `pendidikan` (`id`);

--
-- Constraints for table `pindah_alamat`
--
ALTER TABLE `pindah_alamat`
  ADD CONSTRAINT `FK_pindah_alamat_baru` FOREIGN KEY (`alamat_id_baru`) REFERENCES `alamat` (`id`),
  ADD CONSTRAINT `FK_pindah_alamat_lama` FOREIGN KEY (`alamat_id_lama`) REFERENCES `alamat` (`id`),
  ADD CONSTRAINT `FK_pindah_alamat_penduduk` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users` FOREIGN KEY (`group_id`) REFERENCES `access_groups` (`id`);
