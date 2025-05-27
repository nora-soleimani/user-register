-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 12:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user-register`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Idadmin` int(11) NOT NULL,
  `Iduser` int(11) NOT NULL,
  `Username` varchar(300) NOT NULL,
  `Idlevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Idadmin`, `Iduser`, `Username`, `Idlevel`) VALUES
(2, 12, 'alibabaeai', 3),
(3, 11, 'noraslm', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `IDCity` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `CityName` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`IDCity`, `province_id`, `CityName`) VALUES
(2, 1, 'شهریار'),
(3, 1, 'ورامین'),
(4, 2, 'اصفهان'),
(5, 2, 'کاشان'),
(6, 2, 'نجف‌آباد'),
(7, 3, 'شیراز'),
(8, 3, 'مرودشت'),
(10, 1, 'شهرری');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `IdLevel` int(11) NOT NULL,
  `NameLevel` varchar(255) NOT NULL,
  `Discription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`IdLevel`, `NameLevel`, `Discription`) VALUES
(1, 'مدیرسایت', 'تواناییی حذف ویرایش و اضافه کردن  شهر و استان جدید\r\nتوانایی اضافه کردن مدیر جدید \r\nتوانایی گزارش گیری\r\nدیدن log تغییرات \r\n'),
(2, 'کارمند', 'تواناییی حذف ویرایش و اضافه کردن  شهر و استان جدید\nتوانایی اضافه کردن مدیر جدید \nتوانایی گزارش گیری'),
(3, 'کاراموز', 'تواناییی حذف ویرایش و اضافه کردن  شهر و استان جدید\nتوانایی گزارش گیری'),
(4, 'کاربر عادی', 'مشاهده و تغییر اطلاعات شخصی');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `IDLog` int(11) NOT NULL,
  `IDUser` int(11) NOT NULL,
  `IDAdmin` int(11) NOT NULL,
  `Action` varchar(300) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`IDLog`, `IDUser`, `IDAdmin`, `Action`, `CreatedAt`) VALUES
(1, 9, 11, 'اپدیت پسورد کاربر', '2024-07-07 18:19:14'),
(2, 12, 11, 'ویرایش سطح دسترسی ادمین', '2024-07-07 18:30:54');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `IDProvince` int(11) NOT NULL,
  `ProvinceName` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`IDProvince`, `ProvinceName`) VALUES
(1, 'تهران'),
(2, 'اصفهان'),
(3, 'فارس');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `national_code` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `birth_date` text NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `verify` int(11) NOT NULL,
  `IDLevel` int(11) NOT NULL,
  `created_at` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `national_code`, `phone_number`, `birth_date`, `gender`, `email`, `photo`, `username`, `password`, `province_id`, `city_id`, `verify`, `IDLevel`, `created_at`) VALUES
(9, 'nora', 'soleimani', '0020901153', '09123698755', '۱۳۸۱/۰۸/۱۴', 'male', 'noraslmi30@gmail.com', '', 'noraslmi', '2c6d1126e7159ddab702fef96ea136ad', 1, 3, 1, 4, '1403/4/15'),
(11, 'نورا', 'سلیمانی', '0020901151', '09213249718', '۱۳۸۰/۰۱/۱۳', 'male', 'nora.slm97@gmail.com', 'img_66894ea2efff59.99461744.jpg', 'noraslm', '25f9e794323b453885f5181f1b624d0b', 2, 5, 1, 1, '1403/4/15'),
(12, 'علی', 'بابایی', '1463720467', '09123698755', '۱۳۸۰/۰۱/۱۳', 'male', 'noraslmi20@gmail.com', '', 'alibabaeai', '25f9e794323b453885f5181f1b624d0b', 2, 5, 1, 3, '1403/4/16'),
(25, 'علیرضا', 'سلیمانی', '1463719728', '09213249718', '۱۳۸۱/۰۸/۱۴', 'male', 'noraslmi98@gmail.com', '', 'alirezaslm', '25f9e794323b453885f5181f1b624d0b', NULL, NULL, 1, 4, '1403/4/17'),
(26, 'bahar', 'rezaeai', '1250518113', '09123698755', '۱۳۸۱/۰۸/۱۴', 'female', 'noraslmi98@gmail.com', '', 'baharrezaii', '25f9e794323b453885f5181f1b624d0b', NULL, NULL, 1, 4, '1403/4/18');

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `IDVerify` int(11) NOT NULL,
  `IDuser` int(11) NOT NULL,
  `Email` varchar(500) NOT NULL,
  `Cod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `verify`
--

INSERT INTO `verify` (`IDVerify`, `IDuser`, `Email`, `Cod`) VALUES
(2, 9, 'noraslmi98@gmail.com', 35127195),
(3, 11, 'nora.slm97@gmail.com', 88031615),
(9, 12, 'noraslmi98@gmail.com', 13602619),
(10, 25, 'noraslmi98@gmail.com', 94072872),
(12, 26, 'noraslmi98@gmail.com', 34455875);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Idadmin`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`IDCity`),
  ADD KEY `ProvincesID` (`province_id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`IdLevel`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`IDLog`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`IDProvince`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDLevel` (`IDLevel`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`IDVerify`),
  ADD KEY `IDuser` (`IDuser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Idadmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `IDCity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `IdLevel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `IDLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `IDProvince` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `verify`
--
ALTER TABLE `verify`
  MODIFY `IDVerify` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`IDProvince`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`IDLevel`) REFERENCES `level` (`Idlevel`);

--
-- Constraints for table `verify`
--
ALTER TABLE `verify`
  ADD CONSTRAINT `verify_ibfk_1` FOREIGN KEY (`IDuser`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
