-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql.info.unicaen.fr:3306
-- Généré le : lun. 28 nov. 2022 à 15:37
-- Version du serveur :  10.5.11-MariaDB-1
-- Version de PHP : 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `22011830_3`
--

-- --------------------------------------------------------

--
-- Structure de la table `reliques`
--

CREATE TABLE `reliques` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pouvoir` varchar(255) DEFAULT NULL,
  `creation` int(4) DEFAULT NULL,
  `proprietaire` varchar(255) DEFAULT NULL,
  `liens` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reliques`
--

INSERT INTO `reliques` (`id`, `name`, `pouvoir`, `creation`, `proprietaire`, `liens`) VALUES
(1, 'Vibranium', 'une MatierePremier', 1940, 'Wakanda', 'im1'),
(2, 'Mjølnir', 'le Marteau de THOR', 1900, 'Thor', 'im2'),
(3, 'Tesseract', 'Récipient de confinement ', 1942, 'Asgardiens', 'im3'),
(5, 'le gantelet', 'metrise des element', 2020, 'Tanos', 'tpLQL2'),
(6, 'bouclier', 'protection', 1844, 'Capitaine America', 'oPSNgC'),
(7, 'ceptre', 'duperie/tonner/..', 1662, 'Lokie', 'y4jNKO');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `reliques`
--
ALTER TABLE `reliques`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reliques`
--
ALTER TABLE `reliques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
