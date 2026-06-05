-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 oct. 2025 à 19:20
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eatsmart_bdd_bruno`
--
CREATE DATABASE IF NOT EXISTS `eatsmart_bdd_bruno` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `eatsmart_bdd_bruno`;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prix` decimal(19,4) DEFAULT NULL,
  `description` text,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_article`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `nom`, `prix`, `description`, `id_categorie`) VALUES
(1, 'Anchois 23cm', 7.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, anchois, olive', 1),
(2, 'Anchois 33cm', 11.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, anchois, olive', 1),
(3, 'Emmental 23cm', 7.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, emmental, basilic, olive', 1),
(4, 'Emmental 33cm', 11.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, emmental, basilic, olive', 1),
(5, 'Margherita 23cm', 7.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella', 1),
(6, 'Margherita 33cm', 11.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella', 1),
(7, '3 fromages 23cm', 8.4000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, emmental, chevre', 1),
(8, '3 fromages 33cm', 12.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, emmental, chevre', 1),
(9, '4 fromages 23cm', 8.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, emmental, chevre, roquefort', 1),
(10, '4 fromages 33cm', 13.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, emmental, chevre, roquefort', 1),
(11, 'Royale 23cm', 8.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, jambon label rouge, champignon brun, olive', 2),
(12, 'Royale 33cm', 13.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, jambon label rouge, champignon brun, olive', 2),
(13, 'Vegetarienne 23cm', 8.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, roquette, oignon rouge, poivron, champignon brun, olive', 2),
(14, 'Vegetarienne 33cm', 13.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, roquette, oignon rouge, poivron, champignon brun, olive', 2),
(15, 'Provencale 23cm', 8.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, filets de poulet rôti, oignon rouge, poivron, olive', 2),
(16, 'Provencale 33cm', 13.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, filets de poulet rôti, oignon rouge, poivron, olive', 2),
(17, 'Espagnol 23cm', 8.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, chorizo de León, poivron, olive', 2),
(18, 'Espagnol 33cm', 13.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, chorizo de León, poivron, olive', 2),
(19, 'Italienne 23cm', 10.4000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, jambon cru IGP, roquette, parmigiano reggiano, olive', 2),
(20, 'Italienne 33cm', 16.9000, 'sauce tomate premium, origan, huile d\'olive extra vierge, mozzarella, jambon cru IGP, roquette, parmigiano reggiano, olive', 2),
(21, 'Armenienne 23cm', 8.9000, 'sauce crème fraîche premium, mozzarella, viande hachée 100% pur bœuf, oignon rouge, olive', 3),
(22, 'Armenienne 33cm', 13.9000, 'sauce crème fraîche premium, mozzarella, viande hachée 100% pur bœuf, oignon rouge, olive', 3),
(23, 'White royale 23cm', 8.9000, 'sauce crème fraîche premium, mozzarella, jambon label rouge, champignon brun, olive', 3),
(24, 'White royale 33cm', 13.9000, 'sauce crème fraîche premium, mozzarella, jambon label rouge, champignon brun, olive', 3),
(25, 'Chevre miel 23cm', 8.9000, 'sauce crème fraîche premium, mozzarella, chevre, miel, olive', 3),
(26, 'Chevre miel 33cm', 13.9000, 'sauce crème fraîche premium, mozzarella, chevre, miel, olive', 3),
(27, 'Tiramisu', 3.9000, 'boudoirs imbibés ou non de café, mascarpone, œufs, sucre, arôme vanille, cacao en poudre', 4),
(28, 'Gourmande', 6.9000, 'nutella, avec une glace noix de coco râpé ou chocolat, supplément fruits frais possible', 4),
(29, 'Eaux', 1.9000, 'eaux cristalline, san pellegrino, badoit', 5),
(30, 'Soda 33cl', 1.9000, 'coca original, zero, cherry', 5),
(31, 'Soda 1L+', 3.0000, 'coca, icetea, orangina, sprite, oasis', 5),
(32, 'Biere', 3.5000, 'desperados, heineken', 5),
(33, 'Vin AOP 25cl', 4.9000, 'rouge, rose', 5),
(34, 'Vin AOP 50cl', 7.5000, 'rouge, rose', 5),
(60, 'Frommage 23cm', 23.0000, 'sauce tomate premium, origan, viande et algerienne et sel', 2),
(63, 'tomate 23cm', 23.0000, 'sauce tomate premium, jambon', 3);

-- --------------------------------------------------------

--
-- Structure de la table `assoc_article_commande`
--

DROP TABLE IF EXISTS `assoc_article_commande`;
CREATE TABLE IF NOT EXISTS `assoc_article_commande` (
  `id_article` int NOT NULL,
  `id_commande` int NOT NULL,
  `quantite_article` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_article`,`id_commande`),
  KEY `id_commande` (`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `assoc_article_commande`
--

INSERT INTO `assoc_article_commande` (`id_article`, `id_commande`, `quantite_article`) VALUES
(1, 1, 1.00),
(1, 2, 1.00),
(1, 3, 3.00),
(1, 4, 2.00),
(1, 15, NULL),
(1, 19, NULL),
(1, 21, 10.00),
(1, 23, 10.00),
(1, 30, NULL),
(1, 31, 2.00),
(2, 15, NULL),
(2, 19, NULL),
(2, 21, 5.00),
(2, 23, 5.00),
(3, 2, 1.00),
(3, 4, 1.00),
(3, 15, NULL),
(3, 19, NULL),
(3, 21, 2.00),
(3, 23, 2.00),
(5, 2, 1.00),
(5, 4, 2.00),
(5, 30, NULL),
(5, 31, 1.50),
(7, 5, 1.00),
(27, 5, 1.00),
(33, 5, 1.00);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom`) VALUES
(1, 'classic'),
(2, 'tradition'),
(3, 'creme'),
(4, 'dessert maison'),
(5, 'boisson');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int NOT NULL,
  `date_commande` datetime DEFAULT NULL,
  `prix_total` double DEFAULT NULL,
  `etat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `date_commande`, `prix_total`, `etat`) VALUES
(1, '2024-10-25 00:00:00', 7.9, 'en cours'),
(2, '2024-10-25 00:00:00', 23.2, 'en cours'),
(3, '2024-10-25 00:00:00', 23.7, 'en cours'),
(4, '2024-10-25 00:00:00', 34.2, 'en cours'),
(5, '2024-10-25 00:00:00', 17.7, 'en cours'),
(10, '2024-10-25 00:00:00', 10, 'en cours'),
(15, '2024-10-25 00:00:00', 10, 'en cours'),
(17, '2024-10-25 00:00:00', 10, 'en cours'),
(19, '2024-10-25 00:00:00', 10, 'en cours'),
(20, '2024-10-25 00:00:00', 10, 'en cours'),
(21, '2024-10-25 00:00:00', 10, 'en cours'),
(23, '2024-10-25 00:00:00', 10, 'en cours'),
(30, '2024-10-25 00:00:00', 25.8, 'en cours'),
(31, '2024-10-25 00:00:00', 25.8, 'en cours');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `assoc_article_commande`
--
ALTER TABLE `assoc_article_commande`
  ADD CONSTRAINT `assoc_article_commande_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`),
  ADD CONSTRAINT `assoc_article_commande_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
