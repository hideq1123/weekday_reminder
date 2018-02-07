-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018 年 2 朁E07 日 19:25
-- サーバのバージョン： 5.6.24
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `businessday`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `ken`
--

CREATE TABLE `ken` (
  `No` mediumint(7) NOT NULL DEFAULT '0',
  `id` int(1) NOT NULL,
  `ken` varchar(20) DEFAULT NULL,
  `sendday` date DEFAULT NULL,
  `set_sendday` int(2) DEFAULT NULL,
  `send_text` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `ken_messe1`
--

CREATE TABLE `ken_messe1` (
  `no` int(9) NOT NULL,
  `id` int(1) NOT NULL,
  `messe_No` int(6) NOT NULL DEFAULT '0',
  `ken` varchar(20) DEFAULT NULL,
  `sendday` date DEFAULT NULL,
  `send_time` tinyint(2) DEFAULT NULL,
  `set_sendday` int(2) DEFAULT NULL,
  `sendday_option` varchar(20) DEFAULT NULL,
  `send_timing` int(1) DEFAULT NULL,
  `send_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `ken_messe2`
--

CREATE TABLE `ken_messe2` (
  `no` int(9) NOT NULL,
  `id` int(1) NOT NULL,
  `messe_No` int(6) NOT NULL DEFAULT '0',
  `ken` varchar(20) DEFAULT NULL,
  `sendday` date DEFAULT NULL,
  `send_time` tinyint(2) DEFAULT NULL,
  `set_sendday` varchar(10) DEFAULT NULL,
  `send_timing` int(1) DEFAULT NULL,
  `send_text` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `ken_messe3`
--

CREATE TABLE `ken_messe3` (
  `no` int(9) NOT NULL,
  `id` int(1) NOT NULL,
  `messe_No` int(6) NOT NULL DEFAULT '0',
  `ken` varchar(20) DEFAULT NULL,
  `sendday` date DEFAULT NULL,
  `send_time` tinyint(2) DEFAULT NULL,
  `set_sendday` int(2) DEFAULT NULL,
  `send_timing` int(1) DEFAULT NULL,
  `send_text` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `member`
--

CREATE TABLE `member` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `change_name` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `ken` smallint(6) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  `last_login_date` date DEFAULT NULL,
  `max_messe_no` int(6) NOT NULL DEFAULT '0',
  `list_url` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `premember`
--

CREATE TABLE `premember` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `birthday` char(10) DEFAULT NULL,
  `ken` smallint(6) DEFAULT NULL,
  `link_pass` varchar(128) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `sche`
--

CREATE TABLE `sche` (
  `no` int(9) NOT NULL,
  `id` int(1) NOT NULL,
  `messe_No` int(6) NOT NULL DEFAULT '0',
  `send_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `system`
--

CREATE TABLE `system` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ken`
--
ALTER TABLE `ken`
  ADD PRIMARY KEY (`No`);

--
-- Indexes for table `ken_messe1`
--
ALTER TABLE `ken_messe1`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `ken_messe2`
--
ALTER TABLE `ken_messe2`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `ken_messe3`
--
ALTER TABLE `ken_messe3`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `premember`
--
ALTER TABLE `premember`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sche`
--
ALTER TABLE `sche`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ken_messe1`
--
ALTER TABLE `ken_messe1`
  MODIFY `no` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ken_messe2`
--
ALTER TABLE `ken_messe2`
  MODIFY `no` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ken_messe3`
--
ALTER TABLE `ken_messe3`
  MODIFY `no` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `premember`
--
ALTER TABLE `premember`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sche`
--
ALTER TABLE `sche`
  MODIFY `no` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
