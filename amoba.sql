-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2020. Ápr 06. 10:56
-- Kiszolgáló verziója: 10.4.11-MariaDB
-- PHP verzió: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `amoba`
--
CREATE DATABASE IF NOT EXISTS `amoba` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `amoba`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jatek`
--

CREATE TABLE `jatek` (
  `ID` int(11) NOT NULL,
  `sor` int(11) NOT NULL,
  `oszlop` int(11) NOT NULL,
  `kezdidopont` timestamp NOT NULL DEFAULT current_timestamp(),
  `nyertes` text COLLATE utf8_hungarian_ci DEFAULT 'Senki',
  `vegidopont` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `lepes`
--

CREATE TABLE `lepes` (
  `jatekID` int(11) NOT NULL,
  `jatekosKarakter` varchar(1) COLLATE utf8_hungarian_ci NOT NULL,
  `sor` int(11) NOT NULL,
  `oszlop` int(11) NOT NULL,
  `sorszam` int(11) NOT NULL,
  `gondolkodasido` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
