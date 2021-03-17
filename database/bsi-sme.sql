-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2021 at 10:14 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsi-sme`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dbs`
--

CREATE TABLE `tbl_dbs` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `module` varchar(50) NOT NULL,
  `file_size` float NOT NULL,
  `tgl_data` date NOT NULL,
  `update_posisi` tinyint(1) NOT NULL,
  `upload_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gross`
--

CREATE TABLE `tbl_gross` (
  `no_id` int(11) NOT NULL,
  `area` varchar(100) NOT NULL,
  `region` varchar(25) NOT NULL,
  `kode_bsi` varchar(15) NOT NULL,
  `tgl_rekap` date NOT NULL,
  `no_rek` varchar(15) NOT NULL,
  `no_cif` char(15) NOT NULL,
  `nm_debitur` varchar(100) NOT NULL,
  `cabang_bsi` varchar(100) NOT NULL,
  `prod_name` varchar(50) NOT NULL,
  `jns_penggunaan_kode` varchar(50) DEFAULT NULL,
  `sekon_kode` varchar(15) DEFAULT NULL,
  `tgl_cair` date NOT NULL,
  `nom_pencairan` bigint(20) NOT NULL,
  `bln_pencairan` int(11) NOT NULL,
  `binaan` varchar(100) NOT NULL,
  `bank_legacy` varchar(15) NOT NULL,
  `time_sparate` varchar(15) NOT NULL,
  `perusahaan_final` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_performance`
--

CREATE TABLE `tbl_performance` (
  `no_id` int(11) NOT NULL,
  `index_bank` varchar(50) NOT NULL,
  `nm_bank` char(15) NOT NULL,
  `tgl_data` date NOT NULL,
  `noloan` varchar(50) NOT NULL,
  `no_cif` varchar(50) NOT NULL,
  `nm_nasabah` varchar(100) NOT NULL,
  `kd_cabang` varchar(25) NOT NULL,
  `nm_cabang` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `region` varchar(50) NOT NULL,
  `leg_loantype` varchar(25) NOT NULL,
  `loantype` varchar(25) NOT NULL,
  `skim` varchar(50) NOT NULL,
  `sub_loantype` varchar(50) DEFAULT NULL,
  `kd_sub_sektor` char(25) NOT NULL,
  `sektor_ekonomi` varchar(100) NOT NULL,
  `tgl_cair` date NOT NULL,
  `tgl_jt_tempo` date NOT NULL,
  `dpd` int(11) NOT NULL,
  `sektor` varchar(25) NOT NULL,
  `segment` varchar(25) NOT NULL,
  `restru_flag` varchar(25) DEFAULT NULL,
  `tgl_restru` date DEFAULT NULL,
  `tenor` int(11) DEFAULT NULL,
  `kol_dpd` varchar(15) NOT NULL,
  `kol_loan` int(11) NOT NULL,
  `kol_lalu` int(11) NOT NULL,
  `kol_vs` varchar(15) NOT NULL,
  `flag_dg` int(11) NOT NULL,
  `kol_flag` varchar(15) NOT NULL,
  `kol_cif` varchar(15) NOT NULL,
  `ospokok` bigint(20) NOT NULL,
  `tungg_pokok_adj` bigint(20) NOT NULL,
  `tungg_pokok` bigint(20) NOT NULL,
  `tungg_margin` bigint(20) NOT NULL,
  `plafond` int(11) NOT NULL,
  `desc_prod` varchar(100) DEFAULT NULL,
  `model_bsi` varchar(25) NOT NULL,
  `tgl_jt_angsuran` int(11) DEFAULT NULL,
  `rek_afiliasi` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `username` varchar(25) NOT NULL,
  `nm_user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lv_user` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`username`, `nm_user`, `password`, `lv_user`) VALUES
('admin', 'Admin', 'ae1561c6eda3c6d46599ab1cdcea82eb', 'admin'),
('user', 'User', 'ee11cbb19052e40b07aac0ca060c23ee', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_dbs`
--
ALTER TABLE `tbl_dbs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gross`
--
ALTER TABLE `tbl_gross`
  ADD PRIMARY KEY (`no_id`);

--
-- Indexes for table `tbl_performance`
--
ALTER TABLE `tbl_performance`
  ADD PRIMARY KEY (`no_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_dbs`
--
ALTER TABLE `tbl_dbs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_gross`
--
ALTER TABLE `tbl_gross`
  MODIFY `no_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_performance`
--
ALTER TABLE `tbl_performance`
  MODIFY `no_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
