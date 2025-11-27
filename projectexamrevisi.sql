-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.6 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for projectexamrevisi
CREATE DATABASE IF NOT EXISTS `projectexamrevisi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projectexamrevisi`;

-- Dumping structure for table projectexamrevisi.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.admin: ~2 rows (approximately)
INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
	(1, 'sunnygkp10@gmail.com', '123456'),
	(2, 'admin@admin.com', 'admin');

-- Dumping structure for table projectexamrevisi.answer
CREATE TABLE IF NOT EXISTS `answer` (
  `qid` text NOT NULL,
  `ansid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.answer: ~15 rows (approximately)
INSERT INTO `answer` (`qid`, `ansid`) VALUES
	('55892169bf6a7', '55892169d2efc'),
	('5589216a3646e', '5589216a48722'),
	('558922117fcef', '5589221195248'),
	('55892211e44d5', '55892211f1fa7'),
	('558922894c453', '558922895ea0a'),
	('558922899ccaa', '55892289aa7cf'),
	('558973f4389ac', '558973f462e61'),
	('558973f4c46f2', '558973f4d4abe'),
	('558973f51600d', '558973f526fc5'),
	('558973f55d269', '558973f57af07'),
	('558973f5abb1a', '558973f5e764a'),
	('6911c3249f2c1', '6911c324a03d0'),
	('6911c324a5f68', '6911c324a6d28'),
	('6915554f704bc', '6915554f71404'),
	('69166626abdc6', '69166626ae2d5');

-- Dumping structure for table projectexamrevisi.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `feedback` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.feedback: ~6 rows (approximately)
INSERT INTO `feedback` (`id`, `name`, `email`, `subject`, `feedback`, `date`, `time`) VALUES
	('55846be776610', 'testing', 'sunnygkp10@gmail.com', 'testing', 'testing stART', '2015-06-19', '09:22:15pm'),
	('5584ddd0da0ab', 'netcamp', 'sunnygkp10@gmail.com', 'feedback', ';mLBLB', '2015-06-20', '05:28:16am'),
	('558510a8a1234', 'sunnygkp10', 'sunnygkp10@gmail.com', 'dl;dsnklfn', 'fmdsfld fdj', '2015-06-20', '09:05:12am'),
	('5585509097ae2', 'sunny', 'sunnygkp10@gmail.com', 'kcsncsk', 'l.mdsavn', '2015-06-20', '01:37:52pm'),
	('5586ee27af2c9', 'vikas', 'vikas@gmail.com', 'trial feedback', 'triaal feedbak', '2015-06-21', '07:02:31pm'),
	('5589858b6c43b', 'nik', 'nik1@gmail.com', 'good', 'good site', '2015-06-23', '06:12:59pm');

-- Dumping structure for table projectexamrevisi.guru
CREATE TABLE IF NOT EXISTS `guru` (
  `id_guru` int NOT NULL AUTO_INCREMENT,
  `nama_guru` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pendidikan_terakhir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mapel` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mob_guru` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email_guru` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password_guru` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('pending','accept','reject') COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_guru`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table projectexamrevisi.guru: ~7 rows (approximately)
INSERT INTO `guru` (`id_guru`, `nama_guru`, `pendidikan_terakhir`, `mapel`, `mob_guru`, `email_guru`, `password_guru`, `status`, `tanggal_daftar`) VALUES
	(1, 'Lia', 'S1', 'RPL', '0', 'lia1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'accept', '2025-11-10 03:00:50'),
	(2, 'Lea', 'S1', 'RPL', '0', 'lea@gmail.com', '812b94eb454835665e25797809c1d137', 'accept', '2025-11-10 03:36:30'),
	(3, 'Yuhu', 'S2', 'RPL', '0', 'yuhu@gmail.com', 'c20ad4d76fe97759aa27a0c99bff6710', 'reject', '2025-11-10 10:12:30'),
	(4, 'Guru1', 'S1 PTI', 'RPL', '098876543221', 'guru1@gmail.com', '76d416af67228dd8ea69e3971b94a454', 'accept', '2025-11-16 14:25:17'),
	(5, 'Guru1', 'S1 Pendidikan TI', 'Pemrograman', '0813365980789', 'guru@gmail.com', 'b47c6e71ca3a5e23cab99c2e9da03046', 'accept', '2025-11-20 03:08:58'),
	(6, 'Aulia', 'S1 Pendidikan TI', 'matematika', '081335678090', 'aulia@gmail.com', '28a15217d3d4cc056c14ec07d59c9fe3', 'pending', '2025-11-20 13:31:22'),
	(7, 'Guru5', 'S1 PTI', 'RPL', '087665432122', 'guru5@gmail.com', 'ded26041ffe98ddc8944e98539ca7c62', 'accept', '2025-11-26 02:41:53');

-- Dumping structure for table projectexamrevisi.history
CREATE TABLE IF NOT EXISTS `history` (
  `email` varchar(50) NOT NULL,
  `eid` text NOT NULL,
  `score` int NOT NULL,
  `level` int NOT NULL,
  `sahi` int NOT NULL,
  `wrong` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.history: ~13 rows (approximately)
INSERT INTO `history` (`email`, `eid`, `score`, `level`, `sahi`, `wrong`, `date`) VALUES
	('sunnygkp10@gmail.com', '558921841f1ec', 4, 2, 2, 0, '2015-06-23 09:31:26'),
	('sunnygkp10@gmail.com', '558920ff906b8', 4, 2, 2, 0, '2015-06-23 13:32:09'),
	('avantika420@gmail.com', '558921841f1ec', 4, 2, 2, 0, '2015-06-23 14:33:04'),
	('avantika420@gmail.com', '5589222f16b93', 4, 2, 2, 0, '2015-06-23 14:49:39'),
	('sunnygkp10@gmail.com', '5589222f16b93', 1, 2, 1, 1, '2015-06-24 03:22:38'),
	('admin@admin.com', '6916f416b2c63', 10, 1, 1, 0, '2025-11-14 10:10:55'),
	('coba@gmail.com', '6916f416b2c63', -10, 1, 0, 1, '2025-11-15 14:15:58'),
	('coba@gmail.com', '69198954b8202', -12, 3, 1, 2, '2025-11-16 12:02:53'),
	('siswa@gmail.com', '69198954b8202', -28, 3, 1, 2, '2025-11-16 13:32:16'),
	('mei@gmail.com', '6923186c3485f', 100, 2, 2, 0, '2025-11-23 16:12:16'),
	('mei@gmail.com', '692310293d7cb', 100, 2, 2, 0, '2025-11-23 17:23:39'),
	('mei@gmail.com', '692520296dbef', 50, 1, 1, 0, '2025-11-26 10:49:52'),
	('mei@gmail.com', '69230e19d5d74', 0, 2, 0, 2, '2025-11-26 11:10:58'),
	('mei@gmail.com', '6926e649c6dc4', 10, 1, 1, 0, '2025-11-26 15:02:17'),
	('aulia@gmail.com', '6926e649c6dc4', 10, 1, 1, 0, '2025-11-27 04:24:19');

-- Dumping structure for table projectexamrevisi.options
CREATE TABLE IF NOT EXISTS `options` (
  `qid` varchar(50) NOT NULL,
  `option` varchar(5000) NOT NULL,
  `optionid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.options: ~60 rows (approximately)
INSERT INTO `options` (`qid`, `option`, `optionid`) VALUES
	('55892169bf6a7', 'usermod', '55892169d2efc'),
	('55892169bf6a7', 'useradd', '55892169d2f05'),
	('55892169bf6a7', 'useralter', '55892169d2f09'),
	('55892169bf6a7', 'groupmod', '55892169d2f0c'),
	('5589216a3646e', '751', '5589216a48713'),
	('5589216a3646e', '752', '5589216a4871a'),
	('5589216a3646e', '754', '5589216a4871f'),
	('5589216a3646e', '755', '5589216a48722'),
	('558922117fcef', 'echo', '5589221195248'),
	('558922117fcef', 'print', '558922119525a'),
	('558922117fcef', 'printf', '5589221195265'),
	('558922117fcef', 'cout', '5589221195270'),
	('55892211e44d5', 'int a', '55892211f1f97'),
	('55892211e44d5', '$a', '55892211f1fa7'),
	('55892211e44d5', 'long int a', '55892211f1fb4'),
	('55892211e44d5', 'int a$', '55892211f1fbd'),
	('558922894c453', 'cin>>a;', '558922895ea0a'),
	('558922894c453', 'cin<<a;', '558922895ea26'),
	('558922894c453', 'cout>>a;', '558922895ea34'),
	('558922894c453', 'cout<a;', '558922895ea41'),
	('558922899ccaa', 'cout', '55892289aa7cf'),
	('558922899ccaa', 'cin', '55892289aa7df'),
	('558922899ccaa', 'print', '55892289aa7eb'),
	('558922899ccaa', 'printf', '55892289aa7f5'),
	('558973f4389ac', 'containing root file-system required during bootup', '558973f462e44'),
	('558973f4389ac', ' Contains only scripts to be executed during bootup', '558973f462e56'),
	('558973f4389ac', ' Contains root-file system and drivers required to be preloaded during bootup', '558973f462e61'),
	('558973f4389ac', 'None of the above', '558973f462e6b'),
	('558973f4c46f2', 'Kernel', '558973f4d4abe'),
	('558973f4c46f2', 'Shell', '558973f4d4acf'),
	('558973f4c46f2', 'Commands', '558973f4d4ad9'),
	('558973f4c46f2', 'Script', '558973f4d4ae3'),
	('558973f51600d', 'Boot Loading', '558973f526f9d'),
	('558973f51600d', ' Boot Record', '558973f526fb9'),
	('558973f51600d', ' Boot Strapping', '558973f526fc5'),
	('558973f51600d', ' Booting', '558973f526fce'),
	('558973f55d269', ' Quick boot', '558973f57aef1'),
	('558973f55d269', 'Cold boot', '558973f57af07'),
	('558973f55d269', ' Hot boot', '558973f57af17'),
	('558973f55d269', ' Fast boot', '558973f57af27'),
	('558973f5abb1a', 'bash', '558973f5e7623'),
	('558973f5abb1a', ' Csh', '558973f5e7636'),
	('558973f5abb1a', ' ksh', '558973f5e7640'),
	('558973f5abb1a', ' sh', '558973f5e764a'),
	('6911c3249f2c1', 'algo', '6911c324a03c5'),
	('6911c3249f2c1', 'alga', '6911c324a03cd'),
	('6911c3249f2c1', 'algi', '6911c324a03ce'),
	('6911c3249f2c1', 'algoritma', '6911c324a03d0'),
	('6911c324a5f68', 'pemr', '6911c324a6d20'),
	('6911c324a5f68', 'pem', '6911c324a6d27'),
	('6911c324a5f68', 'pemro', '6911c324a6d28'),
	('6911c324a5f68', 'per', '6911c324a6d2a'),
	('6915554f704bc', 'h', '6915554f71404'),
	('6915554f704bc', 't', '6915554f71408'),
	('6915554f704bc', 'm', '6915554f71409'),
	('6915554f704bc', 'l', '6915554f7140a'),
	('69166626abdc6', '2', '69166626ae2d5'),
	('69166626abdc6', '3', '69166626ae2d9'),
	('69166626abdc6', '5', '69166626ae2da'),
	('69166626abdc6', '6', '69166626ae2db');

-- Dumping structure for table projectexamrevisi.questions
CREATE TABLE IF NOT EXISTS `questions` (
  `qid` text NOT NULL,
  `eid` text NOT NULL,
  `qns` text NOT NULL,
  `optionA` varchar(500) NOT NULL,
  `optionB` varchar(500) NOT NULL,
  `optionC` varchar(500) NOT NULL,
  `optionD` varchar(500) NOT NULL,
  `answer` enum('a','b','c','d') NOT NULL,
  `sn` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.questions: ~38 rows (approximately)
INSERT INTO `questions` (`qid`, `eid`, `qns`, `optionA`, `optionB`, `optionC`, `optionD`, `answer`, `sn`) VALUES
	('55892169bf6a7', '558920ff906b8', 'what is command for changing user information??', '', '', '', '', 'd', 1),
	('5589216a3646e', '558920ff906b8', 'what is permission for view only for other??', '', '', '', '', 'd', 2),
	('558922117fcef', '558921841f1ec', 'what is command for print in php??', '', '', '', '', 'd', 1),
	('55892211e44d5', '558921841f1ec', 'which is a variable of php??', '', '', '', '', 'd', 2),
	('558922894c453', '5589222f16b93', 'what is correct statement in c++??', '', '', '', '', 'd', 1),
	('558922899ccaa', '5589222f16b93', 'which command is use for print the output in c++?', '', '', '', '', 'd', 2),
	('558973f4389ac', '55897338a6659', 'On Linux, initrd is a file', '', '', '', '', 'd', 1),
	('558973f4c46f2', '55897338a6659', 'Which is loaded into memory when system is booted?', '', '', '', '', 'd', 2),
	('558973f51600d', '55897338a6659', ' The process of starting up a computer is known as', '', '', '', '', 'd', 3),
	('558973f55d269', '55897338a6659', ' Bootstrapping is also known as', '', '', '', '', 'd', 4),
	('558973f5abb1a', '55897338a6659', 'The shell used for Single user mode shell is:', '', '', '', '', 'd', 5),
	('6911c3249f2c1', '6911c2e60c9e1', 'apa itu algoritma...', '', '', '', '', 'd', 1),
	('6911c324a5f68', '6911c2e60c9e1', 'apa itu pemrograman...', '', '', '', '', 'd', 2),
	('6915554f704bc', '6915549e3c414', 'html adalah', '', '', '', '', 'd', 1),
	('69166626abdc6', '691666153af18', 'k', '', '', '', '', 'd', 1),
	('6916ffa88f5e2', '6916f416b2c63', 'mlljjjjj', 'b', 's', 'i', 'a', 'a', 10),
	('69193c3a48788', '6919391f2ce81', 'lllllll', 'a', 'b', 'c', 'd', 'b', 50),
	('69198bfd3a8a4', '69198954b8202', 'mmann', 'a', 'b', 'c', 'd', 'a', 12),
	('6919a55c7cc44', '69198954b8202', 'coba aja', 'a', 'b', 'c', 'd', 'b', 12),
	('6919a99605004', '69198954b8202', 'hallo', 'iya', 'apa', 'hmm', 'capek', 'd', 12),
	('692152b08935d', '692152621f126', 'javascript', 'a', 'b', 'c', 'd', 'c', 100),
	('692152b089815', '692152621f126', 'coba', 'a', 'b', 'c', 'd', 'c', 100),
	('692152b089bcf', '692152621f126', 'coba 3', 'a', 'c', 'b', 'd', 'c', 100),
	('692152b089f9c', '692152621f126', 'coba 4', 'a', 'b', 'c', 'd', 'b', 100),
	('692152b08a507', '692152621f126', 'coba 5', 'a', 'c', 'b', 'd', 'b', 100),
	('692163950beee', '69216387496e7', 'coba', 'a', 'b', 'c', 'd', 'b', 100),
	('6921dae130d23', '6921cdff0d07d', 'pertanyaan 1', 'aku', 'aku2', 'aku3', 'aku4', 'a', 0),
	('69230adb11434', '692309b85870e', 'baku adalah', 'baku', 'b', 'c', 'd', 'a', 0),
	('69230adb11c36', '692309b85870e', 'tidak baku adalah', 'tidka baku', 'b', 'c', 'd', 'a', 0),
	('69230e3657cc6', '69230e19d5d74', 'coba', 'salah', 'salah', 'benar', 'salah', '', 0),
	('69230e36588a5', '69230e19d5d74', 'coba 2', 'benar', 'salah', 'salah', 'salah', '', 0),
	('69231045c688f', '692310293d7cb', 'hm', 'benar', 'slh', 'slh', 'slh', 'b', 1),
	('69231045c6d69', '692310293d7cb', 'hm2', 'slh', 'bnr', 'slh', 'slh', 'b', 2),
	('6923189784c74', '6923186c3485f', 'coba', 'bnr', 'slh', 'slh', 'slh', 'a', 50),
	('69231897856d8', '6923186c3485f', 'coba2', 'slh', 'slh', 'bnr', 'slh', 'c', 50),
	('692520c9e4b43', '692520296dbef', 'apa itu', 'bnr', 's', 's', 's', 'a', 1),
	('69271640267b3', '6926e649c6dc4', 'data mining', 'b', 's', 's', 's', 'a', 10);

-- Dumping structure for table projectexamrevisi.quiz
CREATE TABLE IF NOT EXISTS `quiz` (
  `eid` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `sahi` int NOT NULL,
  `wrong` int NOT NULL,
  `total` int NOT NULL,
  `time` bigint NOT NULL,
  `intro` text NOT NULL,
  `tag` varchar(100) NOT NULL,
  `pembuat_role` enum('admin','guru') NOT NULL DEFAULT 'admin',
  `id_guru` int DEFAULT NULL COMMENT '''NULL jika dibuat admin, berisi id_guru jika dibuat guru''',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `FK_quiz_guru` (`id_guru`),
  CONSTRAINT `FK_quiz_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.quiz: ~37 rows (approximately)
INSERT INTO `quiz` (`eid`, `title`, `sahi`, `wrong`, `total`, `time`, `intro`, `tag`, `pembuat_role`, `id_guru`, `date`) VALUES
	('558920ff906b8', 'Linux : File Managment', 2, 1, 2, 5, '', 'linux', 'admin', NULL, '2015-06-23 09:03:59'),
	('558921841f1ec', 'Php Coding', 2, 1, 2, 5, '', 'PHP', 'admin', NULL, '2015-06-23 09:06:12'),
	('5589222f16b93', 'C++ Coding', 2, 1, 2, 5, '', 'c++', 'admin', NULL, '2015-06-23 09:09:03'),
	('55897338a6659', 'Linux:startup', 2, 1, 5, 10, '', 'linux', 'admin', NULL, '2015-06-23 14:54:48'),
	('69118b75a6fa8', 'Algoritma', 100, 100, 1, 5, 'pemrograman', '#algo', 'admin', NULL, '2025-11-10 06:51:33'),
	('6911c2e60c9e1', 'Algoritma', 50, 50, 2, 5, 'pemrograman', '#algo', 'admin', NULL, '2025-11-10 10:48:06'),
	('69154f455b93a', 'Java', 100, 100, 1, 1, 'java java', '#java', 'admin', NULL, '2025-11-13 03:23:49'),
	('69155074c9723', 'Java', 100, 100, 1, 1, 'java java', '#java', 'admin', NULL, '2025-11-13 03:28:52'),
	('691552bb136eb', 'Java', 100, 100, 1, 1, 'J', '#java', 'admin', 2, '2025-11-13 03:38:35'),
	('6915542950cad', 'Html', 10, 10, 11, 1, 'h', '#html', 'admin', 2, '2025-11-13 03:44:41'),
	('6915549e3c414', 'Html', 10, 10, 1, 1, 'h', '#html', 'admin', 2, '2025-11-13 03:46:38'),
	('6916660729987', 'Php', 25, 15, 1, 1, 'p', '#php', 'admin', NULL, '2025-11-13 23:13:11'),
	('691666153af18', 'Php', 50, 15, 1, 1, 'p', '#php', 'admin', NULL, '2025-11-13 23:13:25'),
	('69166dda546f7', 'Php', 90, 9, 1, 1, 'mgyjm', '#php', 'admin', 1, '2025-11-13 23:46:34'),
	('69167160c6061', 'Php', 12, 2, 1, 1, ',m', '#p', 'admin', 2, '2025-11-14 00:01:36'),
	('6916747bcbe39', 'Kode', 12, 1, 1, 1, 'nk', 'kode', 'admin', 1, '2025-11-14 00:14:51'),
	('691674bbc6472', 'Algi', 32, 4, 1, 1, 'a', 'a', 'admin', NULL, '2025-11-14 00:15:55'),
	('6916f416b2c63', 'Bismillah', 10, 10, 1, 1, 'b', '#b', 'admin', 2, '2025-11-14 09:19:18'),
	('6919391f2ce81', 'Mysql', 50, 50, 1, 1, 'm', '#mysql', 'admin', 2, '2025-11-16 02:38:23'),
	('69196ef1b7965', 'Js', 40, 40, 1, 1, 'js', '#js', 'admin', 2, '2025-11-16 06:28:01'),
	('69197ae2da443', 'Django', 10, 1, 1, 1, 'jg', '#j', 'admin', 2, '2025-11-16 07:18:58'),
	('69197df69e877', 'Mtk', 55, 25, 1, 1, 'mtk', '#mtk', 'admin', 2, '2025-11-16 07:32:06'),
	('691984e4c0e07', 'Huft', 11, 1, 1, 1, 'b', 'b', 'guru', 2, '2025-11-16 08:01:40'),
	('691986ede6317', 'Capek', 12, 2, 1, 1, 'a', 'q', 'guru', 2, '2025-11-16 08:10:21'),
	('69198954b8202', 'bisa', 20, 20, 3, 1, 'bisaaaaaa', '#bisalo', 'guru', 2, '2025-11-16 13:01:56'),
	('692152621f126', 'pemrograman', 100, 20, 5, 50, 'Kerjakan dengan benar', '#javascript', 'guru', 5, '2025-11-22 06:04:18'),
	('69216387496e7', 'coba', 100, 100, 1, 10, 'coba aja', '#javascript', 'guru', 5, '2025-11-22 07:17:27'),
	('6921cdff0d07d', 'matematika', 100, 100, 1, 20, 'mencoba', '#mtk', 'guru', 5, '2025-11-22 14:51:43'),
	('6921dc0fcad20', 'fisika', 50, 50, 2, 20, 'listrik', 'fisika', 'guru', 5, '2025-11-22 15:51:43'),
	('6922fe73284b5', 'Bahasa Indonesia', 50, 50, 2, 10, 'Baku dan tidak baku', '#BIN', 'guru', 5, '2025-11-23 12:30:43'),
	('692308db202cf', 'coba', 100, 100, 1, 10, 'coba', 'coba', 'guru', 5, '2025-11-23 13:15:07'),
	('692309b85870e', 'Bahasa Indonesia', 50, 50, 2, 10, 'Baku dan tidak baku', 'BIN', 'guru', 5, '2025-11-23 13:18:48'),
	('69230e19d5d74', 'mencoba lagi', 50, 50, 2, 10, 'coba ', 'coba', 'guru', 5, '2025-11-23 13:37:29'),
	('692310293d7cb', 'mtk', 50, 50, 2, 5, 'trigonometri', 'mtk', 'guru', 5, '2025-11-23 13:46:17'),
	('6923186c3485f', 'cobalagi', 50, 50, 2, 5, 'mencoba', '#javascript', 'guru', 5, '2025-11-23 14:21:32'),
	('692520296dbef', 'MVC', 50, 50, 1, 1, 'pemrograman web', '#laravel', 'guru', 5, '2025-11-25 03:19:05'),
	('6926e649c6dc4', 'Data Mining', 10, 10, 1, 1, 'data', '#datmin', 'guru', 7, '2025-11-26 11:36:41');

-- Dumping structure for table projectexamrevisi.rank
CREATE TABLE IF NOT EXISTS `rank` (
  `email` varchar(50) NOT NULL,
  `score` int NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.rank: ~5 rows (approximately)
INSERT INTO `rank` (`email`, `score`, `time`) VALUES
	('sunnygkp10@gmail.com', 9, '2015-06-24 03:22:38'),
	('avantika420@gmail.com', 8, '2015-06-23 14:49:39'),
	('coba@gmail.com', -22, '2025-11-16 12:02:53'),
	('siswa@gmail.com', -28, '2025-11-16 13:32:16'),
	('mei@gmail.com', 160, '2025-11-26 15:02:17'),
	('aulia@gmail.com', 10, '2025-11-27 04:24:19');

-- Dumping structure for table projectexamrevisi.user
CREATE TABLE IF NOT EXISTS `user` (
  `name` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `college` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mob` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table projectexamrevisi.user: ~8 rows (approximately)
INSERT INTO `user` (`name`, `gender`, `college`, `email`, `mob`, `password`) VALUES
	('Aulia', 'Perempuan', 'unesa', 'aulia@gmail.com', '082339273933', '9d43863a1e1b460a4632f7c31420d6c3'),
	('Avantika', 'F', 'KNIT sultanpur', 'avantika420@gmail.com', '7785068889', 'e10adc3949ba59abbe56e057f20f883e'),
	('Coba', 'Laki-Laki', 'unesa', 'coba@gmail.com', '98764322122', '25d55ad283aa400af464c76d713c07ad'),
	('Lia', 'Perempuan', 'unesa', 'lia@gmail.com', '89765432122', '827ccb0eea8a706c4c34a16891f84e7b'),
	('Mei', 'Perempuan', 'SMKN 1 SURABAYA', 'mei@gmail.com', '082331452332', 'b52f14a65ac622aefdd7d1bc48b4f0bf'),
	('Siswa2', 'Laki-Laki', 'unesa', 'siswa2@gmail.com', '098765432133', '707a346bf458baa2a333205e56fa2ee2'),
	('Siswa', 'Perempuan', 'unesa', 'siswa@gmail.com', '98754332123', '707a346bf458baa2a333205e56fa2ee2'),
	('Sunny', 'M', 'KNIT sultanpur', 'sunnygkp10@gmail.com', '7785068889', 'e10adc3949ba59abbe56e057f20f883e'),
	('User', 'M', 'cimt', 'user@user.com', '11', 'e10adc3949ba59abbe56e057f20f883e');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
