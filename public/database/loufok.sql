-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 30 oct. 2023 à 14:00
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `loufok`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nom_admin` varchar(50) NOT NULL,
  `mail_admin` varchar(100) NOT NULL,
  `mdp_admin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom_admin`, `mail_admin`, `mdp_admin`) VALUES
(3, 'Jean', 'jean@mail.fr', '1234'),
(4, 'Hubert', 'hubert@mail.fr', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `cadavre`
--

CREATE TABLE `cadavre` (
  `id_cadavre` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `titre_cadavre` varchar(100) NOT NULL,
  `date_debut_cadavre` date NOT NULL DEFAULT current_timestamp(),
  `date_fin_cadavre` date NOT NULL,
  `nb_contributions` int(11) NOT NULL,
  `nb_likes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contribution`
--

CREATE TABLE `contribution` (
  `id_contribution` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_cadavre` int(11) NOT NULL,
  `id_joueur` int(11) DEFAULT NULL,
  `txt_contribution` text NOT NULL,
  `date_contribution` date NOT NULL DEFAULT current_timestamp(),
  `ordre_contribution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id_joueur` int(11) NOT NULL,
  `nom_plume_joueur` varchar(100) NOT NULL,
  `mail_joueur` varchar(100) NOT NULL,
  `sexe_joueur` varchar(25) NOT NULL,
  `date_naissance_joueur` date NOT NULL,
  `mdp_joueur` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `nom_plume_joueur`, `mail_joueur`, `sexe_joueur`, `date_naissance_joueur`, `mdp_joueur`) VALUES
(4, 'Gaston', 'gaston@mail.com', 'homme', '2004-10-28', '1234'),
(5, 'Mélanie', 'melanie@mail.fr', 'femme', '2004-05-02', '1234'),
(6, 'Bastien', 'bastien@mail.fr', 'homme', '2003-08-17', '1234');

-- --------------------------------------------------------

--
-- Structure de la table `rand_contribution`
--

CREATE TABLE `rand_contribution` (
  `id_rand_contribution` int(11) NOT NULL,
  `id_cadavre` int(11) NOT NULL,
  `id_joueur` int(11) NOT NULL,
  `id_contribution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `cadavre`
--
ALTER TABLE `cadavre`
  ADD PRIMARY KEY (`id_cadavre`),
  ADD KEY `FK_admin_cadavre` (`id_admin`);

--
-- Index pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`id_contribution`),
  ADD KEY `FK_admin_contribution` (`id_admin`),
  ADD KEY `FK_cadavre_contribution` (`id_cadavre`),
  ADD KEY `FK_joueur_contribution` (`id_joueur`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id_joueur`);

--
-- Index pour la table `rand_contribution`
--
ALTER TABLE `rand_contribution`
  ADD PRIMARY KEY (`id_rand_contribution`),
  ADD KEY `FK_cadavre_rand_contrib` (`id_cadavre`),
  ADD KEY `FK_contribution_rand_contrib` (`id_contribution`),
  ADD KEY `FK_joueur_rand_contrib` (`id_joueur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `cadavre`
--
ALTER TABLE `cadavre`
  MODIFY `id_cadavre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `contribution`
--
ALTER TABLE `contribution`
  MODIFY `id_contribution` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id_joueur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `rand_contribution`
--
ALTER TABLE `rand_contribution`
  MODIFY `id_rand_contribution` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cadavre`
--
ALTER TABLE `cadavre`
  ADD CONSTRAINT `FK_admin_cadavre` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Contraintes pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD CONSTRAINT `FK_admin_contribution` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cadavre_contribution` FOREIGN KEY (`id_cadavre`) REFERENCES `cadavre` (`id_cadavre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_joueur_contribution` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id_joueur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rand_contribution`
--
ALTER TABLE `rand_contribution`
  ADD CONSTRAINT `FK_cadavre_rand_contrib` FOREIGN KEY (`id_cadavre`) REFERENCES `cadavre` (`id_cadavre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_contribution_rand_contrib` FOREIGN KEY (`id_contribution`) REFERENCES `contribution` (`id_contribution`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_joueur_rand_contrib` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id_joueur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
