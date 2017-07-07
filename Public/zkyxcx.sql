-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2017 at 10:26 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zkyxcx`
--

-- --------------------------------------------------------

--
-- Table structure for table `zk_rank`
--

CREATE TABLE `zk_rank` (
  `id` int(11) NOT NULL COMMENT '主键ID',
  `username` varchar(250) NOT NULL COMMENT '用户名',
  `avatarurl` varchar(500) NOT NULL COMMENT '头像地址',
  `rankmoney` int(11) DEFAULT '0' COMMENT '积分'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zk_rank`
--

INSERT INTO `zk_rank` (`id`, `username`, `avatarurl`, `rankmoney`) VALUES
(1, '刘泽中', 'http://img1.2345.com/duoteimg/qqTxImg/11/542b567ecf0f2794.jpg!200x200.jpg', 12230),
(2, '周杰伦', 'http://www.qqxoo.com/uploads/allimg/170129/2255523224-5.jpg', 5681),
(3, '白骨精', 'http://img1.skqkw.cn:888/2014/12/08/07/rf5rlvjegvz-10335.jpg', 924),
(4, '王大锤', 'http://img2.imgtn.bdimg.com/it/u=3065230094,1438966738&fm=26&gp=0.jpg', 736),
(5, '中铠云', 'http://www.qqxoo.com/uploads/allimg/170705/1412591Z3-2.jpg', 8915),
(6, '白骨精', 'http://img1.skqkw.cn:888/2014/12/08/07/rf5rlvjegvz-10335.jpg', 544),
(7, '金大宝', 'http://k2.jsqq.net/uploads/allimg/1706/7_170622145618_8.jpg', 412);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zk_rank`
--
ALTER TABLE `zk_rank`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `zk_rank`
--
ALTER TABLE `zk_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID', AUTO_INCREMENT=8;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
