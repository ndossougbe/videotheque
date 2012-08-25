-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Sam 25 Août 2012 à 20:27
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: 'videotheque'
--

-- --------------------------------------------------------

--
-- Structure de la table 'actors'
--

DROP TABLE IF EXISTS actors;
CREATE TABLE actors (
  id int(11) NOT NULL AUTO_INCREMENT,
  personne_id int(11) NOT NULL,
  video_id int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table 'categories'
--

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table 'categories_videos'
--

DROP TABLE IF EXISTS categories_videos;
CREATE TABLE categories_videos (
  id int(11) NOT NULL AUTO_INCREMENT,
  category_id int(11) NOT NULL,
  video_id int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table 'countries'
--

DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  nationality varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table 'countries'
--

INSERT INTO countries (id, `name`, nationality) VALUES
(1, 'France', 'Français'),
(2, 'USA', 'Américain'),
(3, 'Royaume-Uni', 'Britannique'),
(4, 'Canada', 'Canadien');

-- --------------------------------------------------------

--
-- Structure de la table 'formats'
--

DROP TABLE IF EXISTS formats;
CREATE TABLE formats (
  id int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table 'formats'
--

INSERT INTO formats (id, `name`) VALUES
(1, 'DVD'),
(2, 'DivX'),
(3, 'Blu-Ray'),
(4, 'HD 720p'),
(5, 'HD 1080p');

-- --------------------------------------------------------

--
-- Structure de la table 'personnes'
--

DROP TABLE IF EXISTS personnes;
CREATE TABLE personnes (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table 'users'
--

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  role varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table 'videos'
--

DROP TABLE IF EXISTS videos;
CREATE TABLE videos (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  url varchar(128) DEFAULT NULL,
  format_id int(2) NOT NULL,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  cover varchar(255) NOT NULL DEFAULT 'covers/jaquette_indisponible.png',
  director_id int(11) DEFAULT NULL,
  country_id int(11) DEFAULT NULL,
  synopsis text,
  duration time DEFAULT NULL,
  releasedate date DEFAULT NULL,
  rating decimal(10,0) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
