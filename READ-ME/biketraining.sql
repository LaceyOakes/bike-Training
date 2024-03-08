-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2024 at 01:42 PM
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
-- Database: `biketraining`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateur`
--

CREATE TABLE `administrateur` (
  `admId` int(11) NOT NULL,
  `admNom` int(11) NOT NULL COMMENT 'nom de l''administrateur',
  `admAdr` int(11) NOT NULL COMMENT 'adresse de l''administrateur',
  `admEtat` int(11) NOT NULL COMMENT '1 = Actif, 2 = Désactivé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courId` int(11) NOT NULL,
  `courDate` int(11) NOT NULL COMMENT 'date de la course',
  `courLieu` int(11) NOT NULL COMMENT 'emplacement de la course',
  `courLong` int(11) NOT NULL COMMENT 'longueur de la course en mètres',
  `courUsrCrea` int(11) NOT NULL,
  `courDateCrea` date NOT NULL DEFAULT current_timestamp(),
  `courUsrMod` int(11) NOT NULL,
  `courDateMod` date DEFAULT NULL,
  `courUsrSuppr` int(11) NOT NULL,
  `courDateSuppr` date DEFAULT NULL,
  `courEtat` int(11) NOT NULL COMMENT '1 = créée, 2 = terminée, 3 = supprimée'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cyclistes`
--

CREATE TABLE `cyclistes` (
  `cycId` int(11) NOT NULL,
  `cycNom` int(11) NOT NULL COMMENT 'Nom du cycliste',
  `cycNum` int(11) NOT NULL COMMENT 'Numéro de licence du cycliste',
  `cycAdr` int(11) NOT NULL COMMENT 'Adresse du cycliste',
  `cycAge` int(11) NOT NULL COMMENT 'Age du cycliste'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informations`
--

CREATE TABLE `informations` (
  `infoId` int(11) NOT NULL,
  `infoIdCour` int(11) NOT NULL,
  `infoComm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `inscrId` int(11) NOT NULL,
  `inscrIdCour` int(11) NOT NULL,
  `inscrIdCyc` int(11) NOT NULL,
  `inscrDate` datetime NOT NULL,
  `inscrEtat` int(11) NOT NULL COMMENT '1 = inscrit, 2 = désinscrit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performance`
--

CREATE TABLE `performance` (
  `perfId` int(11) NOT NULL,
  `perfIdCyc` int(11) NOT NULL COMMENT 'identifiant du coureur',
  `perfIdCour` int(11) NOT NULL COMMENT 'identifiant de la course',
  `perfTps` time NOT NULL COMMENT 'temps de la performance du coureur',
  `perfRng` int(11) NOT NULL COMMENT 'rang obtenu par le coureur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`admId`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courId`);

--
-- Indexes for table `cyclistes`
--
ALTER TABLE `cyclistes`
  ADD PRIMARY KEY (`cycId`);

--
-- Indexes for table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`infoId`);

--
-- Indexes for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`inscrId`);

--
-- Indexes for table `performance`
--
ALTER TABLE `performance`
  ADD PRIMARY KEY (`perfId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `admId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cyclistes`
--
ALTER TABLE `cyclistes`
  MODIFY `cycId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informations`
--
ALTER TABLE `informations`
  MODIFY `infoId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `inscrId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance`
--
ALTER TABLE `performance`
  MODIFY `perfId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
