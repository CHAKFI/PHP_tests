-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 22 août 2019 à 21:23
-- Version du serveur :  10.1.39-MariaDB
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `passman`
--

-- --------------------------------------------------------

--
-- Structure de la table `authentf`
--

CREATE TABLE `authentf` (
  `id_au` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pssw` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `authentf`
--

INSERT INTO `authentf` (`id_au`, `username`, `email`, `pssw`) VALUES
(1, 'BIGBOSS', '', 'azerty'),
(2, 'ESTsb', '', 'aqwxszedc'),
(3, 'CHAKFI', '', 'qsdfgh');

-- --------------------------------------------------------

--
-- Structure de la table `password`
--

CREATE TABLE `password` (
  `id_p` int(11) NOT NULL,
  `lien` text NOT NULL,
  `username` varchar(15) NOT NULL,
  `pssw` varchar(15) NOT NULL,
  `id_au` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `password`
--

INSERT INTO `password` (`id_p`, `lien`, `username`, `pssw`, `id_au`) VALUES
(1, 'https://www.facebook.com/', 'BIGBOSS', 'azerty', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `authentf`
--
ALTER TABLE `authentf`
  ADD PRIMARY KEY (`id_au`);

--
-- Index pour la table `password`
--
ALTER TABLE `password`
  ADD PRIMARY KEY (`id_p`),
  ADD KEY `id_au` (`id_au`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `authentf`
--
ALTER TABLE `authentf`
  MODIFY `id_au` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `password`
--
ALTER TABLE `password`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `password`
--
ALTER TABLE `password`
  ADD CONSTRAINT `password_ibfk_1` FOREIGN KEY (`id_au`) REFERENCES `authentf` (`id_au`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
