-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 12:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pembayaran_listrik`
--

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` int(11) NOT NULL,
  `daya` int(11) NOT NULL CHECK (`daya` > 0),
  `tarif_per_kwh` decimal(10,2) NOT NULL CHECK (`tarif_per_kwh` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `daya`, `tarif_per_kwh`) VALUES
(1, 450, 415.00),
(2, 900, 1352.00),
(3, 1300, 1444.70),
(4, 450, 415.00),
(5, 900, 1352.00),
(6, 1300, 1444.70),
(7, 450, 415.00),
(8, 900, 1352.00),
(9, 1300, 1444.70),
(10, 450, 415.00),
(11, 900, 1352.00),
(12, 1300, 1444.70),
(13, 450, 415.00),
(14, 900, 1352.00),
(15, 1300, 1444.70),
(16, 450, 415.00),
(17, 900, 1352.00),
(18, 1300, 1444.70),
(19, 450, 415.00),
(20, 900, 1352.00),
(21, 1300, 1444.70),
(22, 450, 415.00),
(23, 900, 1352.00),
(24, 1300, 1444.70),
(25, 450, 415.00),
(26, 900, 1352.00),
(27, 1300, 1444.70),
(28, 450, 415.00),
(29, 900, 1352.00),
(30, 1300, 1444.70),
(31, 450, 415.00),
(32, 900, 1352.00),
(33, 1300, 1444.70),
(34, 450, 415.00),
(35, 900, 1352.00),
(36, 1300, 1444.70),
(37, 450, 415.00),
(38, 900, 1352.00),
(39, 1300, 1444.70),
(40, 450, 415.00),
(41, 900, 1352.00),
(42, 1300, 1444.70),
(43, 450, 415.00),
(44, 900, 1352.00),
(45, 1300, 1444.70),
(46, 450, 415.00),
(47, 900, 1352.00),
(48, 1300, 1444.70),
(49, 450, 415.00),
(50, 900, 1352.00),
(51, 1300, 1444.70),
(52, 450, 415.00),
(53, 900, 1352.00),
(54, 1300, 1444.70),
(55, 450, 415.00),
(56, 900, 1352.00),
(57, 1300, 1444.70),
(58, 450, 415.00),
(59, 900, 1352.00),
(60, 1300, 1444.70),
(61, 450, 415.00),
(62, 900, 1352.00),
(63, 1300, 1444.70),
(64, 450, 415.00),
(65, 900, 1352.00),
(66, 1300, 1444.70),
(67, 450, 415.00),
(68, 900, 1352.00),
(69, 1300, 1444.70),
(70, 450, 415.00),
(71, 900, 1352.00),
(72, 1300, 1444.70),
(73, 450, 415.00),
(74, 900, 1352.00),
(75, 1300, 1444.70),
(76, 450, 415.00),
(77, 900, 1352.00),
(78, 1300, 1444.70),
(79, 450, 415.00),
(80, 900, 1352.00),
(81, 1300, 1444.70);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `pelanggan_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`pelanggan_id`, `nama`, `alamat`, `level_id`, `user_id`) VALUES
(1, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(2, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(3, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(4, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(5, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(6, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(7, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(8, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(9, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(10, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(11, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(12, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(13, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(14, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(15, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(16, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(17, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(18, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(19, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(20, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(21, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(22, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(23, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(24, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(25, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(26, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2),
(27, 'Pelanggan Satu', 'Jl. Merdeka No. 1', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan`
--

CREATE TABLE `penggunaan` (
  `penggunaan_id` int(11) NOT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `bulan` int(11) NOT NULL CHECK (`bulan` between 1 and 12),
  `tahun` int(11) NOT NULL CHECK (`tahun` > 2000),
  `meter_awal` decimal(10,2) NOT NULL CHECK (`meter_awal` >= 0),
  `meter_akhir` decimal(10,2) NOT NULL CHECK (`meter_akhir` >= `meter_awal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `tagihan_id` int(11) NOT NULL,
  `penggunaan_id` int(11) DEFAULT NULL,
  `total_kwh` decimal(10,2) NOT NULL,
  `total_tagihan` decimal(10,2) NOT NULL,
  `status` enum('Lunas','Belum Lunas') DEFAULT 'Belum Lunas',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `nama`, `role`) VALUES
(1, 'admin1', '$2b$12$AqyTsCDYT11ENJOeDaZD4OXvzQFQU.nJDM12VepsWz4bdO00Ko2Dy', 'Admin Satu', 'admin'),
(2, 'pelanggan1', '$2b$12$JsqIDNvPCOewFQtLCSPkX.wBLeqBTU/jTe6x9RpCmzM1hF87M57Ui', 'Pelanggan Satu', 'pelanggan');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_penggunaan_listrik`
-- (See below for the actual view)
--
CREATE TABLE `vw_penggunaan_listrik` (
`pelanggan_id` int(11)
,`nama_pelanggan` varchar(100)
,`alamat` text
,`daya` int(11)
,`tarif_per_kwh` decimal(10,2)
,`bulan` int(11)
,`tahun` int(11)
,`meter_awal` decimal(10,2)
,`meter_akhir` decimal(10,2)
,`total_kwh` decimal(11,2)
,`total_tagihan` decimal(21,4)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_penggunaan_listrik`
--
DROP TABLE IF EXISTS `vw_penggunaan_listrik`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `vw_penggunaan_listrik`  AS SELECT `p`.`pelanggan_id` AS `pelanggan_id`, `p`.`nama` AS `nama_pelanggan`, `p`.`alamat` AS `alamat`, `l`.`daya` AS `daya`, `l`.`tarif_per_kwh` AS `tarif_per_kwh`, `pg`.`bulan` AS `bulan`, `pg`.`tahun` AS `tahun`, `pg`.`meter_awal` AS `meter_awal`, `pg`.`meter_akhir` AS `meter_akhir`, `pg`.`meter_akhir`- `pg`.`meter_awal` AS `total_kwh`, (`pg`.`meter_akhir` - `pg`.`meter_awal`) * `l`.`tarif_per_kwh` AS `total_tagihan` FROM ((`pelanggan` `p` join `level` `l` on(`p`.`level_id` = `l`.`level_id`)) join `penggunaan` `pg` on(`p`.`pelanggan_id` = `pg`.`pelanggan_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`pelanggan_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_pelanggan_level` (`level_id`);

--
-- Indexes for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`penggunaan_id`),
  ADD UNIQUE KEY `pelanggan_id` (`pelanggan_id`,`bulan`,`tahun`),
  ADD KEY `idx_penggunaan_pelanggan` (`pelanggan_id`,`bulan`,`tahun`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`tagihan_id`),
  ADD KEY `penggunaan_id` (`penggunaan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `pelanggan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `penggunaan`
--
ALTER TABLE `penggunaan`
  MODIFY `penggunaan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `tagihan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `level` (`level_id`),
  ADD CONSTRAINT `pelanggan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`pelanggan_id`);

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`penggunaan_id`) REFERENCES `penggunaan` (`penggunaan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
