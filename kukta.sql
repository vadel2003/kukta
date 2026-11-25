-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2026. Nov 25. 10:05
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `kukta`
--
CREATE DATABASE IF NOT EXISTS `kukta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;
USE `kukta`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cuisine`
--

DROP TABLE IF EXISTS `cuisine`;
CREATE TABLE `cuisine` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `cuisine`
--

INSERT INTO `cuisine` (`id`, `name`) VALUES
(1, 'Magyar'),
(2, 'Olasz'),
(3, 'Francia'),
(4, 'Ázsiai'),
(5, 'Amerikai'),
(6, 'Mexikói'),
(7, 'Görög');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cuisine_recipe`
--

DROP TABLE IF EXISTS `cuisine_recipe`;
CREATE TABLE `cuisine_recipe` (
  `cuisine_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `cuisine_recipe`
--

INSERT INTO `cuisine_recipe` (`cuisine_id`, `recipe_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 14),
(1, 15),
(1, 16),
(1, 21),
(1, 22),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 35),
(2, 2),
(2, 9),
(2, 10),
(2, 17),
(2, 19),
(3, 31),
(3, 32),
(3, 39),
(4, 30),
(4, 33),
(4, 34),
(4, 40),
(5, 11),
(5, 13),
(5, 18),
(5, 23),
(5, 24),
(5, 36),
(5, 37),
(6, 20),
(6, 38),
(7, 12),
(7, 29);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `diet`
--

DROP TABLE IF EXISTS `diet`;
CREATE TABLE `diet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `diet`
--

INSERT INTO `diet` (`id`, `name`) VALUES
(1, 'Mindenevő'),
(2, 'Vegetáriánus'),
(3, 'Vegán'),
(4, 'Pescetáriánus'),
(5, 'Flexitáriánus'),
(6, 'Keto'),
(7, 'Low-carb');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `diet_recipe`
--

DROP TABLE IF EXISTS `diet_recipe`;
CREATE TABLE `diet_recipe` (
  `diet_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `diet_recipe`
--

INSERT INTO `diet_recipe` (`diet_id`, `recipe_id`) VALUES
(1, 1),
(1, 3),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 32),
(1, 33),
(1, 37),
(1, 38),
(2, 2),
(2, 4),
(2, 5),
(2, 6),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 31),
(2, 34),
(2, 35),
(2, 36),
(2, 39),
(2, 40),
(3, 2),
(3, 4),
(3, 13),
(3, 14),
(3, 19),
(3, 20),
(3, 21),
(3, 23),
(3, 25),
(3, 26),
(3, 34),
(3, 40),
(4, 2),
(4, 4),
(4, 5),
(4, 6),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(4, 29),
(4, 30),
(4, 31),
(4, 34),
(4, 35),
(4, 36),
(4, 39),
(4, 40),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 9),
(5, 11),
(5, 12),
(5, 13),
(5, 14),
(5, 15),
(5, 16),
(5, 17),
(5, 18),
(5, 19),
(5, 20),
(5, 21),
(5, 22),
(5, 23),
(5, 24),
(5, 25),
(5, 26),
(5, 27),
(5, 28),
(5, 29),
(5, 30),
(5, 31),
(5, 32),
(5, 33),
(5, 34),
(5, 35),
(5, 36),
(5, 37),
(5, 38),
(5, 39),
(5, 40),
(6, 12),
(6, 20),
(6, 30),
(6, 31),
(6, 32),
(6, 36),
(6, 37),
(7, 2),
(7, 12),
(7, 20),
(7, 30),
(7, 31),
(7, 32),
(7, 36),
(7, 37);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `favorite`
--

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE `favorite` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `favorite`
--

INSERT INTO `favorite` (`id`, `user_id`, `recipe_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(2, 1, 5, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(3, 1, 9, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(4, 1, 12, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(5, 1, 15, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(6, 1, 30, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(7, 2, 2, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(8, 2, 3, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(9, 2, 7, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(10, 2, 14, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(11, 2, 21, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(12, 2, 38, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(13, 2, 40, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(14, 3, 6, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(15, 3, 11, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(16, 3, 18, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(17, 3, 26, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(18, 3, 33, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(19, 3, 35, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(20, 4, 4, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(21, 4, 8, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(22, 4, 10, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(23, 4, 16, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(24, 4, 17, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(25, 4, 22, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(26, 4, 28, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(27, 5, 2, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(28, 5, 23, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(29, 5, 24, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(30, 5, 27, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(31, 5, 29, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(32, 5, 31, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(33, 5, 36, '2026-11-24 19:24:06', '2026-11-24 19:24:06'),
(34, 5, 39, '2026-11-24 19:24:06', '2026-11-24 19:24:06');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `food_type`
--

DROP TABLE IF EXISTS `food_type`;
CREATE TABLE `food_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `food_type`
--

INSERT INTO `food_type` (`id`, `name`) VALUES
(1, 'Leves'),
(2, 'Főétel'),
(3, 'Desszert'),
(4, 'Előétel'),
(5, 'Köret'),
(6, 'Saláta'),
(7, 'Nasi'),
(8, 'Tészta'),
(9, 'Pékáru'),
(10, 'Ital'),
(11, 'Befőtt'),
(12, 'Gyümölcs');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `food_type_recipe`
--

DROP TABLE IF EXISTS `food_type_recipe`;
CREATE TABLE `food_type_recipe` (
  `food_type_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `food_type_recipe`
--

INSERT INTO `food_type_recipe` (`food_type_id`, `recipe_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 31),
(1, 39),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 29),
(2, 32),
(2, 33),
(2, 34),
(2, 37),
(2, 38),
(2, 40),
(3, 5),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 27),
(3, 28),
(3, 35),
(4, 2),
(4, 6),
(4, 12),
(4, 19),
(4, 20),
(4, 30),
(4, 31),
(4, 39),
(5, 13),
(5, 14),
(5, 40),
(6, 11),
(6, 12),
(6, 30),
(6, 36),
(6, 37),
(7, 13),
(7, 15),
(7, 18),
(7, 20),
(7, 22),
(7, 35),
(8, 9),
(8, 10),
(8, 34),
(9, 16),
(9, 21),
(9, 22),
(10, 23),
(10, 24),
(11, 25),
(11, 26),
(12, 5),
(12, 23),
(12, 25),
(12, 26),
(12, 27),
(12, 28);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `free_from`
--

DROP TABLE IF EXISTS `free_from`;
CREATE TABLE `free_from` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `label` varchar(30) NOT NULL,
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `free_from`
--

INSERT INTO `free_from` (`id`, `name`, `label`, `thumbnail`) VALUES
(1, 'Glutén', 'Gluténmentes', 'images/free_from/gluten.svg'),
(2, 'Laktóz', 'Laktózmentes', 'images/free_from/lactose.svg'),
(3, 'Cukor', 'Cukormentes', 'images/free_from/sugar.svg'),
(4, 'Tojás', 'Tojásmentes', 'images/free_from/egg.svg'),
(5, 'Szója', 'Szójamentes', 'images/free_from/soy.svg'),
(6, 'Diófélék', 'Dióféléktől mentes', 'images/free_from/tree-nuts.svg'),
(7, 'Földimogyoró', 'Földimogyoró-mentes', 'images/free_from/peanut.svg'),
(8, 'Hal', 'Halmentes', 'images/free_from/fish.svg'),
(9, 'Rákfélék', 'Rákféléktől mentes', 'images/free_from/crustaceans.svg'),
(10, 'Zeller', 'Zellermentes', 'images/free_from/celery.svg'),
(11, 'Mustár', 'Mustármentes', 'images/free_from/mustard.svg'),
(12, 'Szezámmag', 'Szezámmagmentes', 'images/free_from/sesame.svg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `free_from_recipe`
--

DROP TABLE IF EXISTS `free_from_recipe`;
CREATE TABLE `free_from_recipe` (
  `free_from_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `free_from_recipe`
--

INSERT INTO `free_from_recipe` (`free_from_id`, `recipe_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(1, 12),
(1, 13),
(1, 14),
(1, 20),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 31),
(1, 32),
(1, 36),
(1, 37),
(1, 38),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 7),
(2, 8),
(2, 13),
(2, 14),
(2, 19),
(2, 20),
(2, 21),
(2, 23),
(2, 25),
(2, 26),
(2, 27),
(2, 29),
(2, 30),
(2, 33),
(2, 34),
(2, 37),
(2, 38),
(2, 40),
(3, 1),
(3, 4),
(3, 12),
(3, 13),
(3, 14),
(3, 19),
(3, 20),
(3, 21),
(3, 23),
(3, 30),
(3, 31),
(3, 32),
(3, 36),
(3, 37),
(3, 39),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 9),
(4, 12),
(4, 13),
(4, 14),
(4, 19),
(4, 20),
(4, 21),
(4, 24),
(4, 27),
(4, 28),
(4, 29),
(4, 31),
(4, 33),
(4, 34),
(4, 37),
(4, 38),
(4, 39),
(4, 40);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE `ingredient` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `calories` double NOT NULL,
  `carbohydrate` double NOT NULL,
  `protein` double NOT NULL,
  `fat` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `ingredient`
--

INSERT INTO `ingredient` (`id`, `name`, `calories`, `carbohydrate`, `protein`, `fat`) VALUES
(1, 'Liszt', 364, 76, 10, 1),
(2, 'Tészta', 370, 74, 12, 1.5),
(3, 'Kenyér', 265, 49, 9, 3.2),
(4, 'Tej', 42, 5, 3.4, 3.6),
(5, 'Vaj', 717, 0.1, 0.85, 81.1),
(6, 'Sajt', 402, 1.3, 25, 33),
(7, 'Tejföl', 206, 4, 2.5, 20),
(8, 'Cukor', 387, 100, 0, 0),
(9, 'Tojás', 155, 1.1, 13, 11),
(10, 'Szójaszósz', 53, 4.9, 8.1, 0.6),
(11, 'Dió', 654, 14, 15, 65),
(12, 'Földimogyoró', 567, 16, 25, 49),
(13, 'Hal', 206, 0, 22, 12),
(14, 'Rák', 99, 0.2, 20, 1.5),
(15, 'Zeller', 16, 3, 0.7, 0.2),
(16, 'Mustár', 66, 5.5, 4.4, 3.3),
(17, 'Szezámmag', 573, 23, 18, 50),
(18, 'Olaj', 884, 0, 0, 100),
(19, 'Só', 0, 0, 0, 0),
(20, 'Bors', 251, 64, 10, 3.3),
(21, 'Hagyma', 40, 9.3, 1.1, 0.1),
(22, 'Fokhagyma', 149, 33, 6.4, 0.5),
(23, 'Paradicsom', 18, 3.9, 0.9, 0.2),
(24, 'Burgonya', 77, 17.5, 2, 0.1),
(25, 'Rizs', 130, 28, 2.7, 0.3),
(26, 'Csirkemell', 165, 0, 31, 3.6),
(27, 'Sertéshús', 242, 0, 27, 14),
(28, 'Marhahús', 250, 0, 26, 15),
(29, 'Alma', 52, 14, 0.3, 0.2),
(30, 'Banán', 89, 23, 1.1, 0.3),
(31, 'Narancs', 47, 12, 0.9, 0.1),
(32, 'Csokoládé', 546, 61, 4.9, 31),
(33, 'Kakaópor', 228, 58, 20, 14),
(34, 'Bab', 127, 22.8, 8.7, 0.5),
(35, 'Pirospaprika', 282, 54, 14, 13),
(36, 'Sárgarépa', 41, 9.6, 0.9, 0.2),
(37, 'Babapiskóta', 386, 77, 8, 4),
(38, 'Mascarpone', 429, 4.8, 4.6, 44),
(39, 'Kávé', 2, 0, 0.3, 0),
(40, 'Zsemlemorzsa', 395, 72, 13, 5.3),
(41, 'Római saláta', 17, 3.3, 1.2, 0.3),
(42, 'Feta sajt', 264, 4.1, 14, 21),
(43, 'Uborka', 15, 3.6, 0.7, 0.1),
(44, 'Olívabogyó', 115, 6, 0.8, 11),
(45, 'Avokádó', 160, 8.5, 2, 15),
(46, 'Lime', 30, 10.5, 0.7, 0.2),
(47, 'Élesztő', 105, 18, 8.4, 1.9),
(48, 'Eper', 32, 7.7, 0.7, 0.3),
(49, 'Fahéj', 247, 81, 4, 1.2),
(50, 'Méz', 304, 82, 0.3, 0),
(51, 'Citrom', 29, 9.3, 1.1, 0.3),
(52, 'Chili', 40, 8.8, 1.9, 0.4),
(53, 'Zöldborsó', 81, 14, 5.4, 0.4),
(54, 'Meggy', 50, 12, 1, 0.3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ingredient_recipe`
--

DROP TABLE IF EXISTS `ingredient_recipe`;
CREATE TABLE `ingredient_recipe` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double NOT NULL,
  `unit` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `ingredient_recipe`
--

INSERT INTO `ingredient_recipe` (`id`, `recipe_id`, `ingredient_id`, `quantity`, `unit`) VALUES
(1, 1, 28, 800, 0),
(2, 1, 21, 2, 4),
(3, 1, 24, 600, 0),
(4, 1, 36, 2, 4),
(5, 1, 35, 1, 11),
(6, 1, 18, 3, 11),
(7, 1, 19, 2, 12),
(8, 1, 20, 1, 13),
(9, 2, 23, 800, 0),
(10, 2, 21, 1, 4),
(11, 2, 22, 2, 5),
(12, 2, 18, 2, 11),
(13, 2, 8, 1, 12),
(14, 2, 19, 1, 12),
(15, 2, 20, 1, 13),
(16, 3, 26, 600, 0),
(17, 3, 36, 3, 4),
(18, 3, 15, 1, 4),
(19, 3, 21, 1, 4),
(20, 3, 2, 100, 0),
(21, 3, 19, 2, 12),
(22, 3, 20, 1, 13),
(23, 4, 24, 300, 0),
(24, 4, 36, 2, 4),
(25, 4, 53, 150, 0),
(26, 4, 21, 1, 4),
(27, 4, 18, 2, 11),
(28, 4, 19, 1, 12),
(29, 4, 20, 1, 13),
(30, 5, 54, 500, 0),
(31, 5, 29, 2, 4),
(32, 5, 8, 4, 11),
(33, 5, 7, 200, 0),
(34, 5, 1, 1, 11),
(35, 5, 49, 1, 12),
(36, 6, 5, 50, 0),
(37, 6, 1, 2, 11),
(38, 6, 22, 2, 5),
(39, 6, 4, 500, 2),
(40, 6, 6, 200, 0),
(41, 6, 19, 1, 12),
(42, 7, 27, 800, 0),
(43, 7, 21, 2, 4),
(44, 7, 35, 1, 11),
(45, 7, 23, 1, 4),
(46, 7, 18, 3, 11),
(47, 7, 19, 2, 12),
(48, 7, 1, 300, 0),
(49, 7, 9, 2, 4),
(50, 8, 26, 600, 0),
(51, 8, 1, 100, 0),
(52, 8, 9, 2, 4),
(53, 8, 40, 150, 0),
(54, 8, 24, 800, 0),
(55, 8, 18, 500, 2),
(56, 8, 19, 1, 12),
(57, 9, 2, 400, 0),
(58, 9, 28, 400, 0),
(59, 9, 23, 500, 0),
(60, 9, 21, 1, 4),
(61, 9, 36, 1, 4),
(62, 9, 22, 2, 5),
(63, 9, 18, 2, 11),
(64, 9, 19, 1, 12),
(65, 9, 6, 50, 0),
(66, 10, 2, 500, 0),
(67, 10, 28, 600, 0),
(68, 10, 23, 500, 0),
(69, 10, 21, 1, 4),
(70, 10, 5, 50, 0),
(71, 10, 1, 3, 11),
(72, 10, 4, 500, 2),
(73, 10, 6, 200, 0),
(74, 10, 19, 1, 12),
(75, 11, 41, 1, 6),
(76, 11, 26, 300, 0),
(77, 11, 3, 2, 7),
(78, 11, 6, 50, 0),
(79, 11, 9, 1, 4),
(80, 11, 16, 1, 12),
(81, 11, 51, 0.5, 4),
(82, 11, 18, 4, 11),
(83, 11, 19, 1, 13),
(84, 12, 23, 400, 0),
(85, 12, 43, 1, 4),
(86, 12, 21, 1, 4),
(87, 12, 42, 200, 0),
(88, 12, 44, 100, 0),
(89, 12, 18, 3, 11),
(90, 12, 19, 1, 13),
(91, 13, 24, 1, 1),
(92, 13, 18, 3, 11),
(93, 13, 19, 1, 12),
(94, 13, 35, 1, 12),
(95, 14, 25, 300, 0),
(96, 14, 18, 1, 11),
(97, 14, 19, 1, 12),
(98, 15, 1, 250, 0),
(99, 15, 4, 500, 2),
(100, 15, 9, 2, 4),
(101, 15, 8, 1, 11),
(102, 15, 19, 1, 13),
(103, 15, 18, 3, 11),
(104, 16, 1, 400, 0),
(105, 16, 5, 200, 0),
(106, 16, 8, 150, 0),
(107, 16, 9, 1, 4),
(108, 16, 29, 1, 1),
(109, 16, 49, 2, 12),
(110, 17, 37, 300, 0),
(111, 17, 38, 500, 0),
(112, 17, 9, 4, 4),
(113, 17, 8, 100, 0),
(114, 17, 39, 300, 2),
(115, 17, 33, 2, 11),
(116, 18, 32, 200, 0),
(117, 18, 5, 150, 0),
(118, 18, 8, 200, 0),
(119, 18, 9, 3, 4),
(120, 18, 1, 100, 0),
(121, 18, 33, 2, 11),
(122, 19, 3, 8, 7),
(123, 19, 23, 4, 4),
(124, 19, 22, 2, 5),
(125, 19, 18, 3, 11),
(126, 19, 19, 1, 13),
(127, 20, 45, 3, 4),
(128, 20, 46, 1, 4),
(129, 20, 23, 1, 4),
(130, 20, 21, 0.5, 4),
(131, 20, 22, 1, 5),
(132, 20, 52, 0.5, 4),
(133, 20, 19, 0.5, 12),
(134, 21, 1, 500, 0),
(135, 21, 47, 20, 0),
(136, 21, 19, 2, 12),
(137, 21, 18, 2, 11),
(138, 22, 1, 500, 0),
(139, 22, 4, 250, 2),
(140, 22, 47, 25, 0),
(141, 22, 5, 100, 0),
(142, 22, 8, 100, 0),
(143, 22, 9, 1, 4),
(144, 22, 33, 4, 11),
(145, 22, 19, 1, 13),
(146, 23, 31, 3, 4),
(147, 23, 30, 1, 4),
(148, 24, 30, 2, 4),
(149, 24, 4, 400, 2),
(150, 24, 50, 1, 11),
(151, 25, 29, 2, 1),
(152, 25, 8, 300, 0),
(153, 25, 49, 1, 12),
(154, 25, 51, 1, 4),
(155, 26, 48, 1, 1),
(156, 26, 8, 300, 0),
(157, 26, 51, 1, 4),
(158, 27, 29, 2, 4),
(159, 27, 30, 2, 4),
(160, 27, 31, 2, 4),
(161, 27, 48, 200, 0),
(162, 27, 50, 2, 11),
(163, 27, 51, 0.5, 4),
(164, 28, 29, 4, 4),
(165, 28, 11, 60, 0),
(166, 28, 50, 2, 11),
(167, 28, 49, 1, 12),
(168, 28, 5, 20, 0),
(169, 29, 13, 400, 0),
(170, 29, 1, 2, 11),
(171, 29, 51, 1, 4),
(172, 29, 18, 2, 11),
(173, 29, 19, 1, 12),
(174, 29, 25, 150, 0),
(175, 30, 14, 300, 0),
(176, 30, 43, 1, 4),
(177, 30, 41, 0.5, 6),
(178, 30, 10, 2, 11),
(179, 30, 46, 1, 4),
(180, 30, 18, 1, 11),
(181, 30, 17, 1, 12),
(182, 31, 15, 600, 0),
(183, 31, 21, 1, 4),
(184, 31, 5, 40, 0),
(185, 31, 4, 200, 2),
(186, 31, 19, 1, 12),
(187, 31, 20, 1, 13),
(188, 32, 26, 600, 0),
(189, 32, 16, 3, 11),
(190, 32, 7, 200, 0),
(191, 32, 21, 1, 4),
(192, 32, 18, 2, 11),
(193, 32, 19, 1, 12),
(194, 32, 20, 1, 13),
(195, 33, 26, 500, 0),
(196, 33, 10, 3, 11),
(197, 33, 50, 2, 11),
(198, 33, 22, 2, 5),
(199, 33, 17, 2, 11),
(200, 33, 18, 2, 11),
(201, 34, 2, 300, 0),
(202, 34, 12, 100, 0),
(203, 34, 10, 3, 11),
(204, 34, 46, 1, 4),
(205, 34, 22, 1, 5),
(206, 34, 52, 1, 4),
(207, 34, 18, 1, 11),
(208, 35, 1, 250, 0),
(209, 35, 11, 150, 0),
(210, 35, 5, 150, 0),
(211, 35, 8, 150, 0),
(212, 35, 9, 3, 4),
(213, 35, 4, 100, 2),
(214, 36, 41, 1, 6),
(215, 36, 43, 1, 4),
(216, 36, 45, 1, 4),
(217, 36, 9, 2, 4),
(218, 36, 6, 100, 0),
(219, 36, 18, 2, 11),
(220, 36, 19, 1, 13),
(221, 37, 26, 400, 0),
(222, 37, 23, 2, 4),
(223, 37, 43, 1, 4),
(224, 37, 41, 0.5, 6),
(225, 37, 18, 2, 11),
(226, 37, 51, 0.5, 4),
(227, 37, 19, 1, 12),
(228, 37, 20, 1, 13),
(229, 38, 28, 500, 0),
(230, 38, 34, 400, 0),
(231, 38, 23, 400, 0),
(232, 38, 21, 1, 4),
(233, 38, 22, 2, 5),
(234, 38, 52, 2, 4),
(235, 38, 35, 1, 12),
(236, 38, 18, 2, 11),
(237, 38, 19, 1, 12),
(238, 39, 21, 6, 4),
(239, 39, 5, 50, 0),
(240, 39, 1, 1, 11),
(241, 39, 3, 4, 7),
(242, 39, 6, 100, 0),
(243, 39, 19, 1, 12),
(244, 39, 20, 1, 13),
(245, 40, 25, 300, 0),
(246, 40, 36, 2, 4),
(247, 40, 53, 150, 0),
(248, 40, 21, 1, 4),
(249, 40, 10, 3, 11),
(250, 40, 18, 2, 11);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `meal_time`
--

DROP TABLE IF EXISTS `meal_time`;
CREATE TABLE `meal_time` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `meal_time`
--

INSERT INTO `meal_time` (`id`, `name`) VALUES
(1, 'Reggeli'),
(2, 'Ebéd'),
(3, 'Vacsora'),
(4, 'Uzsonna'),
(5, 'Tízórai');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `meal_time_recipe`
--

DROP TABLE IF EXISTS `meal_time_recipe`;
CREATE TABLE `meal_time_recipe` (
  `meal_time_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `meal_time_recipe`
--

INSERT INTO `meal_time_recipe` (`meal_time_id`, `recipe_id`) VALUES
(1, 15),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 7),
(2, 8),
(2, 9),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 36),
(2, 37),
(2, 38),
(2, 40),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 12),
(3, 14),
(3, 19),
(3, 29),
(3, 31),
(3, 32),
(3, 33),
(3, 34),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(4, 5),
(4, 13),
(4, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 20),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28),
(4, 35),
(5, 16),
(5, 19),
(5, 22),
(5, 23),
(5, 27);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_07_28_093400_create_base_tables', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rating`
--

DROP TABLE IF EXISTS `rating`;
CREATE TABLE `rating` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `score` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `recipe_id`, `score`) VALUES
(1, 2, 9, 2),
(2, 2, 22, 5),
(3, 2, 33, 1),
(4, 2, 38, 4),
(5, 3, 1, 4),
(6, 3, 7, 4),
(7, 3, 8, 3),
(8, 3, 15, 4),
(9, 3, 40, 4),
(10, 4, 4, 4),
(11, 4, 19, 2),
(12, 4, 28, 2),
(13, 4, 30, 5),
(14, 5, 5, 2),
(15, 5, 16, 4),
(16, 5, 35, 5),
(17, 5, 36, 3),
(18, 5, 39, 5);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `recipe`
--

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `prep_time` smallint(5) UNSIGNED NOT NULL,
  `difficulty` tinyint(3) UNSIGNED NOT NULL,
  `servings` tinyint(3) UNSIGNED NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `recipe`
--

INSERT INTO `recipe` (`id`, `title`, `description`, `prep_time`, `difficulty`, `servings`, `thumbnail`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Gulyásleves', 'Hagyományos magyar gulyásleves marhahússal, burgonyával és pirospaprikával.', 120, 1, 6, 'images/recipes/default/soup_thumbnail.svg', 2, '2026-02-14 00:00:00', '2026-02-14 00:00:00'),
(2, 'Paradicsomleves', 'Könnyű, olaszos paradicsomleves fokhagymával és egy csipet cukorral.', 30, 0, 4, 'images/recipes/default/soup_thumbnail.svg', 1, '2026-03-02 00:00:00', '2026-03-02 00:00:00'),
(3, 'Húsleves', 'Gazdag csirkehúsleves sok zöldséggel és cérnametélttel, ahogy a nagymama főzte.', 90, 1, 6, 'images/recipes/default/soup_thumbnail.svg', 1, '2026-01-18 00:00:00', '2026-02-03 00:00:00'),
(4, 'Zöldségleves', 'Egyszerű, gyors zöldségleves burgonyával, répával és zöldborsóval.', 40, 0, 4, 'images/recipes/default/soup_thumbnail.svg', 5, '2026-05-21 00:00:00', '2026-05-21 00:00:00'),
(5, 'Gyümölcsleves', 'Hideg meggyes-almás gyümölcsleves tejföllel és fahéjjal, nyári napokra.', 30, 0, 4, 'images/recipes/default/soup_thumbnail.svg', 2, '2026-07-09 00:00:00', '2026-07-09 00:00:00'),
(6, 'Sajtleves', 'Krémes sajtleves vajas rántással és fokhagymával.', 25, 0, 4, 'images/recipes/default/soup_thumbnail.svg', 1, '2026-02-27 00:00:00', '2026-02-27 00:00:00'),
(7, 'Pörkölt', 'Hagyományos sertéspörkölt házi galuskával.', 90, 1, 4, 'images/recipes/default/main_course_thumbnail.svg', 1, '2026-01-05 00:00:00', '2026-01-05 00:00:00'),
(8, 'Rántott csirke', 'Ropogós rántott csirkemell házi hasábburgonyával.', 45, 1, 4, 'images/recipes/default/main_course_thumbnail.svg', 2, '2026-04-11 00:00:00', '2026-04-12 00:00:00'),
(9, 'Bolognai spagetti', 'Olasz klasszikus: spagetti darált marhahúsos paradicsomszósszal.', 50, 1, 4, 'images/recipes/default/pasta_thumbnail.svg', 4, '2026-06-30 00:00:00', '2026-06-30 00:00:00'),
(10, 'Lasagne', 'Rétegezett lasagne darált hússal, paradicsomszósszal és besamellel.', 90, 2, 6, 'images/recipes/default/pasta_thumbnail.svg', 1, '2026-03-23 00:00:00', '2026-03-23 00:00:00'),
(11, 'Caesar saláta', 'Római saláta sült csirkemellel, pirított kenyérkockával és reszelt sajttal.', 25, 0, 2, 'images/recipes/default/salad_thumbnail.svg', 5, '2026-08-02 00:00:00', '2026-08-02 00:00:00'),
(12, 'Görög saláta', 'Friss saláta paradicsommal, uborkával, hagymával, fetával és olívabogyóval.', 15, 0, 4, 'images/recipes/default/salad_thumbnail.svg', 5, '2026-07-15 00:00:00', '2026-07-15 00:00:00'),
(13, 'Sült krumpli', 'Ropogós, sütőben sült burgonya köretnek vagy nassolnivalónak.', 45, 0, 4, 'images/recipes/default/side_dish_thumbnail.svg', 4, '2026-09-04 00:00:00', '2026-09-04 00:00:00'),
(14, 'Párolt rizs', 'Egyszerű, puha párolt rizs, a legtöbb főételhez illő köret.', 25, 0, 4, 'images/recipes/default/side_dish_thumbnail.svg', 1, '2026-01-26 00:00:00', '2026-01-26 00:00:00'),
(15, 'Palacsinta', 'Vékony, hagyományos palacsinta, kedvünk szerint töltve.', 30, 1, 6, 'images/recipes/default/dessert_thumbnail.svg', 2, '2026-03-08 00:00:00', '2026-05-19 00:00:00'),
(16, 'Almás pite', 'Omlós tésztás almás pite fahéjas töltelékkel.', 75, 1, 10, 'images/recipes/default/dessert_thumbnail.svg', 3, '2026-10-12 00:00:00', '2026-10-12 00:00:00'),
(17, 'Tiramisu', 'Olasz desszert kávéba mártott babapiskótával és mascarponés krémmel.', 40, 1, 8, 'images/recipes/default/dessert_thumbnail.svg', 3, '2026-04-27 00:00:00', '2026-04-27 00:00:00'),
(18, 'Csokoládés süti', 'Szaftos, sűrű csokis brownie, kockákra vágva.', 40, 0, 12, 'images/recipes/default/dessert_thumbnail.svg', 1, '2026-02-09 00:00:00', '2026-02-09 00:00:00'),
(19, 'Bruschetta', 'Pirított kenyér friss paradicsommal, fokhagymával és olívaolajjal.', 15, 0, 4, 'images/recipes/default/starter_thumbnail.svg', 5, '2026-06-06 00:00:00', '2026-06-06 00:00:00'),
(20, 'Guacamole', 'Mexikói avokádókrém lime-mal, paradicsommal és hagymával, mártogatósnak.', 15, 0, 4, 'images/recipes/default/starter_thumbnail.svg', 4, '2026-08-19 00:00:00', '2026-08-19 00:00:00'),
(21, 'Házi kenyér', 'Ropogós héjú, egyszerű fehér kenyér házi sütéshez.', 180, 2, 10, 'images/recipes/default/bakery_thumbnail.svg', 3, '2026-05-03 00:00:00', '2026-05-10 00:00:00'),
(22, 'Kakaós csiga', 'Puha, kelt tésztás kakaós csiga, mint a pékségben.', 120, 1, 12, 'images/recipes/default/bakery_thumbnail.svg', 3, '2026-09-21 00:00:00', '2026-09-21 00:00:00'),
(23, 'Narancsos smoothie', 'Frissítő narancsos-banános smoothie hozzáadott cukor nélkül.', 10, 0, 2, 'images/recipes/default/drink_thumbnail.svg', 1, '2026-07-28 00:00:00', '2026-07-28 00:00:00'),
(24, 'Banános turmix', 'Krémes, tejes banánturmix egy kis mézzel, gyors reggelire.', 10, 0, 2, 'images/recipes/default/drink_thumbnail.svg', 1, '2026-04-02 00:00:00', '2026-04-02 00:00:00'),
(25, 'Almabefőtt', 'Fahéjas almabefőtt télire, sütemények töltelékének is jó.', 60, 1, 6, 'images/recipes/default/preserve_thumbnail.svg', 2, '2026-09-13 00:00:00', '2026-09-13 00:00:00'),
(26, 'Eperbefőtt', 'Egész szem eperből készült befőtt, ahogy a nagymama csinálta.', 45, 1, 6, 'images/recipes/default/preserve_thumbnail.svg', 2, '2026-06-17 00:00:00', '2026-06-17 00:00:00'),
(27, 'Gyümölcssaláta', 'Színes, friss gyümölcssaláta mézes-citromos öntettel.', 15, 0, 4, 'images/recipes/default/fruit_thumbnail.svg', 1, '2026-08-25 00:00:00', '2026-08-25 00:00:00'),
(28, 'Mézes-diós sült alma', 'Sütőben sült alma mézes-diós töltelékkel és fahéjjal.', 40, 0, 4, 'images/recipes/default/fruit_thumbnail.svg', 3, '2026-11-02 00:00:00', '2026-11-02 00:00:00'),
(29, 'Sült hal', 'Serpenyőben sült fehér halfilé citrommal és párolt rizzsel.', 35, 1, 2, 'images/recipes/default/main_course_thumbnail.svg', 4, '2026-10-05 00:00:00', '2026-10-05 00:00:00'),
(30, 'Rák saláta', 'Ázsiai garnélarák saláta uborkával, szójás-lime-os öntettel.', 25, 1, 2, 'images/recipes/default/salad_thumbnail.svg', 5, '2026-06-23 00:00:00', '2026-07-01 00:00:00'),
(31, 'Zellerkrémleves', 'Selymes zellerkrémleves vajjal és egy kevés tejjel.', 35, 0, 4, 'images/recipes/default/soup_thumbnail.svg', 1, '2026-01-31 00:00:00', '2026-01-31 00:00:00'),
(32, 'Mustáros csirke', 'Szaftos csirkemell mustáros-tejfölös mártásban.', 40, 1, 4, 'images/recipes/default/main_course_thumbnail.svg', 4, '2026-05-12 00:00:00', '2026-05-12 00:00:00'),
(33, 'Szezámmagos csirke', 'Ázsiai stílusú mézes-szójás csirke pirított szezámmaggal.', 35, 1, 4, 'images/recipes/default/main_course_thumbnail.svg', 4, '2026-03-29 00:00:00', '2026-03-29 00:00:00'),
(34, 'Földimogyorós tészta', 'Gyors ázsiai tészta földimogyorós-szójás szósszal és egy kis chilivel.', 25, 0, 3, 'images/recipes/default/pasta_thumbnail.svg', 4, '2026-10-20 00:00:00', '2026-10-20 00:00:00'),
(35, 'Diós süti', 'Puha, diós kevert sütemény, kávé mellé tökéletes.', 50, 1, 12, 'images/recipes/default/dessert_thumbnail.svg', 2, '2026-04-18 00:00:00', '2026-04-18 00:00:00'),
(36, 'Keto saláta', 'Laktató, alacsony szénhidráttartalmú saláta sajttal, tojással és avokádóval.', 20, 0, 2, 'images/recipes/default/salad_thumbnail.svg', 1, '2026-09-30 00:00:00', '2026-09-30 00:00:00'),
(37, 'Low-carb csirke', 'Grillezett csirkemell friss zöldségekkel, köret nélkül.', 25, 0, 2, 'images/recipes/default/main_course_thumbnail.svg', 5, '2026-07-22 00:00:00', '2026-07-22 00:00:00'),
(38, 'Chilis bab', 'Csípős, mexikói ihletésű chilis bab darált marhahússal.', 60, 1, 4, 'images/recipes/default/main_course_thumbnail.svg', 1, '2026-02-20 00:00:00', '2026-03-11 00:00:00'),
(39, 'Francia hagymaleves', 'Klasszikus francia hagymaleves sajtos pirítóssal.', 60, 1, 4, 'images/recipes/default/soup_thumbnail.svg', 1, '2026-10-27 00:00:00', '2026-10-27 00:00:00'),
(40, 'Zöldséges rizs', 'Ázsiai pirított rizs sárgarépával, zöldborsóval és szójaszósszal.', 25, 0, 4, 'images/recipes/default/side_dish_thumbnail.svg', 5, '2026-08-11 00:00:00', '2026-08-11 00:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('zzfZzKFXkdXREV3OfEIjykGhMmwGiHk6qmb2E2Xc', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJJcWliTG4wakNsUlJCdWlBUGxMN0xrUjRDVGNRZXc0OTYycGc4MEdIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwva3VrdGFcL3B1YmxpYyIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1795548628);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `step`
--

DROP TABLE IF EXISTS `step`;
CREATE TABLE `step` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(1000) NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `step_category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `step`
--

INSERT INTO `step` (`id`, `description`, `position`, `recipe_id`, `step_category_id`) VALUES
(1, 'A marhahúst megmossuk, majd kb. 2 cm-es kockákra vágjuk.', 1, 1, 1),
(2, 'A hagymát apróra vágjuk, a burgonyát és a répát meghámozzuk, felkockázzuk.', 2, 1, 1),
(3, 'Az olajon megdinszteljük a hagymát, rádobjuk a húst, és fehéredésig pirítjuk.', 3, 1, 3),
(4, 'Lehúzzuk a tűzről, elkeverjük benne a pirospaprikát, majd felöntjük vízzel.', 4, 1, 3),
(5, 'Sózzuk, borsozzuk, és fedő alatt kb. másfél órán át főzzük, amíg a hús megpuhul.', 5, 1, 3),
(6, 'Hozzáadjuk a burgonyát és a répát, és további 20 percig főzzük.', 6, 1, 3),
(7, 'Forrón tálaljuk, friss kenyérrel az igazi.', 7, 1, 5),
(8, 'A paradicsomot megmossuk és felkockázzuk, a hagymát és a fokhagymát felaprítjuk.', 1, 2, 1),
(9, 'Az olajon megdinszteljük a hagymát és a fokhagymát.', 2, 2, 3),
(10, 'Hozzáadjuk a paradicsomot, és 10 percig pároljuk, amíg szétesik.', 3, 2, 3),
(11, 'Felöntjük 5 dl vízzel, sózzuk, borsozzuk, cukrozzuk, és 15 percig főzzük.', 4, 2, 3),
(12, 'Botmixerrel simára turmixoljuk.', 5, 2, 2),
(13, 'Melegen, tálkákba szedve tálaljuk.', 6, 2, 5),
(14, 'A csirkét megmossuk, a répát és a zellert meghámozzuk, nagyobb darabokra vágjuk.', 1, 3, 1),
(15, 'A húst 2 liter hideg vízben feltesszük főni, és a habját leszedjük.', 2, 3, 3),
(16, 'Hozzáadjuk a zöldségeket, az egész hagymát, a sót és a borsot.', 3, 3, 3),
(17, 'Gyöngyöző forrásban, lassan főzzük kb. 1 órán át.', 4, 3, 3),
(18, 'A tésztát külön, sós vízben kifőzzük.', 5, 3, 3),
(19, 'A tésztát tányérba tesszük, ráöntjük a levest, mellé húst és zöldséget szedünk.', 6, 3, 5),
(20, 'A zöldségeket megpucoljuk és felkockázzuk.', 1, 4, 1),
(21, 'Olajon megpirítjuk a hagymát és a répát, mehet rá a krumpli, a borsó és 1,5 l víz.', 2, 4, 3),
(22, 'Sózzuk, borsozzuk, és kb. 20 perc alatt puhára főzzük.', 3, 4, 3),
(23, 'A meggyet kimagozzuk, az almát meghámozzuk és felkockázzuk.', 1, 5, 1),
(24, 'A gyümölcsöt 1 liter vízzel, a cukorral és a fahéjjal feltesszük főni.', 2, 5, 3),
(25, 'A tejfölt simára keverjük a liszttel, és kevés forró levet adunk hozzá.', 3, 5, 2),
(26, 'A tejfölös keveréket a leveshez öntjük, és egyszer felforraljuk.', 4, 5, 3),
(27, 'Kihűtjük, és jól behűtve tálaljuk.', 5, 5, 5),
(28, 'A sajtot lereszeljük, a fokhagymát meghámozzuk és összezúzzuk.', 1, 6, 1),
(29, 'A vajat megolvasztjuk, belekeverjük a lisztet, és világos rántást készítünk.', 2, 6, 3),
(30, 'Hozzáadjuk a fokhagymát, majd csomómentesen felöntjük a tejjel és 5 dl vízzel.', 3, 6, 3),
(31, 'Sózzuk, és pár percig főzzük, amíg kicsit besűrűsödik.', 4, 6, 3),
(32, 'Lehúzzuk a tűzről, és addig keverjük benne a sajtot, amíg teljesen elolvad.', 5, 6, 3),
(33, 'Forrón tálaljuk.', 6, 6, 5),
(34, 'A húst 2-3 cm-es kockákra vágjuk, a hagymát apróra, a paradicsomot kockára.', 1, 7, 1),
(35, 'Az olajon üvegesre dinszteljük a hagymát, majd lehúzzuk a tűzről.', 2, 7, 3),
(36, 'Belekeverjük a pirospaprikát, hozzáadjuk a húst, a paradicsomot és a sót.', 3, 7, 3),
(37, 'Fedő alatt kb. egy órát pároljuk, ha elfő a leve, pótoljuk egy kis vízzel.', 4, 7, 3),
(38, 'A lisztből, a tojásokból, egy csipet sóból és 2 dl vízből galuskatésztát keverünk.', 5, 7, 2),
(39, 'Galuskaszaggatóval forrásban lévő sós vízbe szaggatjuk, és kifőzzük.', 6, 7, 3),
(40, 'A pörköltet a galuskával tálaljuk.', 7, 7, 5),
(41, 'A csirkemellet felszeleteljük, kicsit kiklopfoljuk, és megsózzuk.', 1, 8, 1),
(42, 'A szeleteket sorban lisztbe, felvert tojásba, majd zsemlemorzsába forgatjuk.', 2, 8, 2),
(43, 'Bő, forró olajban mindkét oldalukat aranybarnára sütjük.', 3, 8, 4),
(44, 'A burgonyát meghámozzuk és hasábokra vágjuk.', 4, 8, 1),
(45, 'A hasábokat ugyanabban az olajban ropogósra sütjük, majd megsózzuk.', 5, 8, 4),
(46, 'A rántott húst a sült krumplival együtt tálaljuk.', 6, 8, 5),
(47, 'A hagymát, a fokhagymát és a répát apróra vágjuk, a paradicsomot felkockázzuk.', 1, 9, 1),
(48, 'Az olajon megdinszteljük a zöldségeket, majd hozzáadjuk a darált húst.', 2, 9, 3),
(49, 'Ha a hús kifehéredett, hozzáadjuk a paradicsomot és a sót, és 30 percig főzzük.', 3, 9, 3),
(50, 'Közben a spagettit sós vízben al dentére főzzük, majd leszűrjük.', 4, 9, 3),
(51, 'Tésztára szedjük a szószt, és jó sok reszelt sajtot szórunk rá.', 5, 9, 5),
(52, 'A darált húst a hagymával megpirítjuk, majd a paradicsommal 20 percig főzzük.', 1, 10, 3),
(53, 'A vajból és a lisztből rántást készítünk, felöntjük a tejjel, és sűrűre főzzük.', 2, 10, 3),
(54, 'Tepsibe rétegezzük a lasagnelapokat, a húsos szószt és a besamelt.', 3, 10, 2),
(55, 'A tetejére besamel kerül, ezt megszórjuk a reszelt sajttal.', 4, 10, 2),
(56, '180 fokon kb. 40 percig sütjük, amíg a teteje aranybarna lesz.', 5, 10, 4),
(57, 'Pár perc pihentetés után szeletekre vágva tálaljuk.', 6, 10, 5),
(58, 'A salátát megmossuk, szárazra csepegtetjük és falatnyi darabokra tépjük.', 1, 11, 1),
(59, 'A csirkemellet sózzuk, kevés olajon átsütjük, majd felszeleteljük.', 2, 11, 4),
(60, 'A kenyeret felkockázzuk, és serpenyőben ropogósra pirítjuk.', 3, 11, 4),
(61, 'Az öntethez a tojássárgáját, a mustárt, a citrom levét és az olajat kikeverjük.', 4, 11, 2),
(62, 'A salátára rakjuk a csirkét és a kenyérkockát, meglocsoljuk, sajtot reszelünk rá.', 5, 11, 5),
(63, 'A paradicsomot és az uborkát nagyobb kockákra, a hagymát vékony karikákra vágjuk.', 1, 12, 1),
(64, 'Mehet rá az olívabogyó, a morzsolt feta, egy kis só és olaj.', 2, 12, 5),
(65, 'A burgonyát meghámozzuk, és egyforma hasábokra vágjuk.', 1, 13, 1),
(66, 'Tálban összeforgatjuk az olajjal, a sóval és a pirospaprikával.', 2, 13, 2),
(67, 'Tepsibe terítjük, és 200 fokon kb. 35 percig sütjük, félidőben átforgatjuk.', 3, 13, 4),
(68, 'A megmosott rizst kevés olajon üvegesre pirítjuk.', 1, 14, 3),
(69, 'Rá a dupla mennyiségű víz, só, és lefedve, kis lángon 18 perc. Nem kevergetjük!', 2, 14, 3),
(70, 'Villával átlazítjuk, és kész.', 3, 14, 5),
(71, 'A lisztet, a tojásokat, a cukrot és a sót a tej felével csomómentesre keverjük.', 1, 15, 2),
(72, 'Hozzáadjuk a maradék tejet és az olajat, majd 20 percig pihentetjük.', 2, 15, 2),
(73, 'Forró serpenyőben vékony lapokat sütünk, mindegyiket mindkét oldalán.', 3, 15, 4),
(74, 'Mehet bele lekvár, kakaó vagy túró, kinek mi a kedvence.', 4, 15, 5),
(75, 'A lisztet elmorzsoljuk a hideg vajjal, és a tojással, 80 g cukorral összegyúrjuk.', 1, 16, 2),
(76, 'A tésztát két részre osztjuk, és 30 percre hűtőbe tesszük.', 2, 16, 2),
(77, 'Az almát lereszeljük, kinyomkodjuk, és elkeverjük a maradék cukorral és a fahéjjal.', 3, 16, 1),
(78, 'Az egyik lapot tepsibe tesszük, rásimítjuk a tölteléket, és befedjük a másikkal.', 4, 16, 2),
(79, '180 fokon kb. 40 percig sütjük.', 5, 16, 4),
(80, 'Kihűlés után szeletekre vágva tálaljuk.', 6, 16, 5),
(81, 'A kávét lefőzzük, és teljesen kihűtjük.', 1, 17, 1),
(82, 'A tojássárgákat a cukorral habosra keverjük, majd hozzákeverjük a mascarponét.', 2, 17, 2),
(83, 'A tojásfehérjéket kemény habbá verjük, és óvatosan a krémhez forgatjuk.', 3, 17, 2),
(84, 'A piskótákat egyenként a kávéba mártjuk, és egy tál aljára rakjuk.', 4, 17, 2),
(85, 'Rásimítjuk a krém felét, majd megismételjük a piskóta- és krémréteget.', 5, 17, 2),
(86, 'Egy éjszakára hűtőbe tesszük, tálalás előtt kakaót szitálunk a tetejére.', 6, 17, 5),
(87, 'A csokoládét és a vajat vízgőz felett összeolvasztjuk, majd kicsit hűlni hagyjuk.', 1, 18, 2),
(88, 'A tojásokat a cukorral habosra keverjük, és hozzáöntjük a csokis keveréket.', 2, 18, 2),
(89, 'Beleszitáljuk a lisztet és a kakaóport, és épp csak összekeverjük.', 3, 18, 2),
(90, 'Sütőpapíros tepsibe öntjük, és 180 fokon kb. 25 percig sütjük.', 4, 18, 4),
(91, 'Ha kihűlt, kockákra vágjuk. A közepe maradjon kicsit ragacsos!', 5, 18, 5),
(92, 'A paradicsomot apró kockákra vágjuk, sózzuk, és elkeverjük 2 evőkanál olajjal.', 1, 19, 1),
(93, 'A kenyérszeleteket serpenyőben vagy sütőben ropogósra pirítjuk.', 2, 19, 4),
(94, 'A még meleg kenyeret bedörzsöljük a félbevágott fokhagymával.', 3, 19, 2),
(95, 'Rákanalazzuk a paradicsomot, meglocsoljuk a maradék olajjal, és azonnal tálaljuk.', 4, 19, 5),
(96, 'Az avokádókat félbevágjuk, kimagozzuk, és a húsukat egy tálba kanalazzuk.', 1, 20, 1),
(97, 'Villával pürésítjük, és rögtön rácsavarjuk a lime levét, hogy ne barnuljon meg.', 2, 20, 2),
(98, 'A paradicsomot, a hagymát, a fokhagymát és a chilit nagyon apróra vágjuk.', 3, 20, 1),
(99, 'Az egészet összekeverjük az avokádóval, és megsózzuk.', 4, 20, 2),
(100, 'Tortilla chipsszel vagy friss zöldségekkel tálaljuk.', 5, 20, 5),
(101, 'Az élesztőt 3 dl langyos vízben feloldjuk.', 1, 21, 2),
(102, 'A lisztet összekeverjük a sóval, hozzáöntjük az élesztős vizet és az olajat.', 2, 21, 2),
(103, '10 percig dagasztjuk, amíg sima, rugalmas tésztát kapunk.', 3, 21, 2),
(104, 'Letakarva, meleg helyen 1 órát kelesztjük, amíg duplájára nő.', 4, 21, 2),
(105, 'Cipót formázunk belőle, és még 40 percig kelni hagyjuk.', 5, 21, 2),
(106, 'Előmelegített sütőben 220 fokon kb. 35 percig sütjük.', 6, 21, 4),
(107, 'Hagyjuk kihűlni, mielőtt felvágjuk, különben ragacsos lesz a belseje.', 7, 21, 5),
(108, 'Az élesztőt a langyos tejben egy kanál cukorral felfuttatjuk.', 1, 22, 2),
(109, 'A liszthez adjuk a tejet, a tojást, a sót és a vaj felét, és megdagasztjuk.', 2, 22, 2),
(110, 'Letakarva, meleg helyen 1 órát kelesztjük.', 3, 22, 2),
(111, 'Téglalappá nyújtjuk, megkenjük a maradék vajjal, és megszórjuk a cukros kakaóval.', 4, 22, 2),
(112, 'Szorosan feltekerjük, 3 cm-es szeletekre vágjuk, és tepsibe sorakoztatjuk.', 5, 22, 2),
(113, '180 fokon kb. 25 percig sütjük.', 6, 22, 4),
(114, 'Langyosan a legjobb, egy bögre tejjel.', 7, 22, 5),
(115, 'Kifacsarjuk a narancsokat, és a banánnal együtt simára turmixoljuk.', 1, 23, 2),
(116, 'Rögtön igyuk meg, mert állás közben szétválik.', 2, 23, 5),
(117, 'A banánt feldaraboljuk, és a tejjel meg a mézzel habosra turmixoljuk.', 1, 24, 2),
(118, 'Hidegen a legfinomabb.', 2, 24, 5),
(119, 'Az üvegeket és a tetejüket alaposan kimossuk, és forró vízzel kiöblítjük.', 1, 25, 1),
(120, 'Az almát meghámozzuk, kimagozzuk és cikkekre vágjuk.', 2, 25, 1),
(121, '1 liter vizet felforralunk a cukorral, a fahéjjal és a citrom levével.', 3, 25, 3),
(122, 'Beletesszük az almát, és 5 percig főzzük.', 4, 25, 3),
(123, 'Az almát az üvegekbe szedjük, felöntjük a sziruppal, és szorosan lezárjuk.', 5, 25, 2),
(124, 'Az üvegeket fejjel lefelé fordítva, letakarva hagyjuk kihűlni.', 6, 25, 2),
(125, 'Hűvös helyen tároljuk, és desszertként vagy töltelékként tálaljuk.', 7, 25, 5),
(126, 'Az epret megmossuk, és lecsípjük a zöld szárát.', 1, 26, 1),
(127, 'Az üvegeket alaposan kimossuk, és forró vízzel kiöblítjük.', 2, 26, 1),
(128, 'Az epret az üvegekbe rakjuk.', 3, 26, 2),
(129, '7 dl vizet felforralunk a cukorral és a citrom levével.', 4, 26, 3),
(130, 'A forró sziruppal felöntjük az epret, és az üvegeket szorosan lezárjuk.', 5, 26, 2),
(131, 'Az üvegeket egy fazék vízben 10 percig forraljuk, és a vízben hagyjuk kihűlni.', 6, 26, 3),
(132, 'Hűvös helyen tároljuk, palacsintához vagy desszertekhez tálaljuk.', 7, 26, 5),
(133, 'A gyümölcsöket megpucoljuk, és falatnyi darabokra vágjuk.', 1, 27, 1),
(134, 'A mézet elkeverjük a citrom levével, és a gyümölcsökre öntjük.', 2, 27, 2),
(135, 'Átforgatjuk, és hűtőben pihentetjük egy kicsit.', 3, 27, 5),
(136, 'Az almákat megmossuk, és almavájóval kivájjuk a magházukat.', 1, 28, 1),
(137, 'A diót apróra vágjuk, és összekeverjük a mézzel és a fahéjjal.', 2, 28, 2),
(138, 'Az almákat megtöltjük a diós keverékkel, és mindegyik tetejére kis vajat teszünk.', 3, 28, 2),
(139, '180 fokon kb. 25 percig sütjük, amíg az alma megpuhul.', 4, 28, 4),
(140, 'Melegen, a kisült levével meglocsolva tálaljuk.', 5, 28, 5),
(141, 'A rizst kétszeres mennyiségű sós vízben lefedve puhára pároljuk.', 1, 29, 3),
(142, 'A halfilét leöblítjük, papírtörlővel szárazra itatjuk, és megsózzuk.', 2, 29, 1),
(143, 'Vékonyan megforgatjuk a lisztben.', 3, 29, 2),
(144, 'Forró olajon oldalanként 3-4 percig sütjük.', 4, 29, 4),
(145, 'A rizzsel és citromkarikákkal tálaljuk, a halat meglocsoljuk citromlével.', 5, 29, 5),
(146, 'A rákot sós vízben 2-3 percig főzzük, majd hideg vízben lehűtjük és megpucoljuk.', 1, 30, 3),
(147, 'Az uborkát vékonyan felszeleteljük, a salátát falatnyira tépjük.', 2, 30, 1),
(148, 'Az öntethez a szójaszószt, a lime levét és az olajat összekeverjük.', 3, 30, 2),
(149, 'A rákot a zöldségekkel összeforgatjuk, meglocsoljuk, és szezámmaggal megszórjuk.', 4, 30, 5),
(150, 'A zellert meghámozzuk és felkockázzuk, a hagymát apróra vágjuk.', 1, 31, 1),
(151, 'A vajon megdinszteljük a hagymát, majd hozzáadjuk a zellert.', 2, 31, 3),
(152, 'Felöntjük 8 dl vízzel, sózzuk, és kb. 25 percig főzzük, amíg a zeller megpuhul.', 3, 31, 3),
(153, 'Hozzáöntjük a tejet, és botmixerrel krémesre turmixoljuk.', 4, 31, 2),
(154, 'Frissen őrölt borssal megszórva, melegen tálaljuk.', 5, 31, 5),
(155, 'A csirkemellet csíkokra vágjuk, sózzuk, borsozzuk, a hagymát apróra vágjuk.', 1, 32, 1),
(156, 'Az olajon fehéredésig sütjük a húst, majd kivesszük a serpenyőből.', 2, 32, 4),
(157, 'Ugyanott megdinszteljük a hagymát, és felöntjük 1 dl vízzel.', 3, 32, 3),
(158, 'Belekeverjük a mustárt és a tejfölt, visszatesszük a húst, és 10 percig főzzük.', 4, 32, 3),
(159, 'A szafttal együtt, rizzsel vagy burgonyával tálaljuk.', 5, 32, 5),
(160, 'A csirkemellet falatnyi kockákra vágjuk, a fokhagymát összezúzzuk.', 1, 33, 1),
(161, 'A szójaszószt, a mézet és a fokhagymát összekeverjük.', 2, 33, 2),
(162, 'Az olajon a húst minden oldalán aranybarnára sütjük.', 3, 33, 4),
(163, 'Ráöntjük a szószt, és addig forgatjuk, amíg besűrűsödik és bevonja a húst.', 4, 33, 3),
(164, 'Szezámmagot szórunk rá, rizzsel az igazi.', 5, 33, 5),
(165, 'A tésztát sós vízben kifőzzük, és leszűrjük.', 1, 34, 3),
(166, 'A földimogyorót szárazon megpirítjuk, és durvára vágjuk.', 2, 34, 1),
(167, 'A szójaszószt, a lime levét, a zúzott fokhagymát és az olajat összekeverjük.', 3, 34, 2),
(168, 'A meleg tésztát összeforgatjuk a szósszal és a felkarikázott chilivel.', 4, 34, 2),
(169, 'A tetejére szórjuk a földimogyorót, és melegen tálaljuk.', 5, 34, 5),
(170, 'A diót durvára daráljuk, a vajat szobahőmérsékletűre hagyjuk.', 1, 35, 1),
(171, 'A vajat a cukorral habosra keverjük, majd egyenként hozzáadjuk a tojásokat.', 2, 35, 2),
(172, 'Hozzákeverjük a lisztet, a tejet és a diót.', 3, 35, 2),
(173, 'Kivajazott tepsibe simítjuk, és 180 fokon kb. 30 percig sütjük.', 4, 35, 4),
(174, 'Kihűlés után szeletekre vágva tálaljuk.', 5, 35, 5),
(175, 'A tojásokat 10 percig keményre főzzük, majd lehűtjük és meghámozzuk.', 1, 36, 3),
(176, 'A salátát feltépjük, az uborkát, az avokádót, a sajtot és a tojást felvágjuk.', 2, 36, 1),
(177, 'Mindent tálra rendezünk, sózzuk, meglocsoljuk olajjal, és azonnal tálaljuk.', 3, 36, 5),
(178, 'A csirkemellet sózzuk, borsozzuk, és meglocsoljuk a citrom levével.', 1, 37, 1),
(179, 'Grillserpenyőben, kevés olajon oldalanként 5-6 percig sütjük, majd felszeleteljük.', 2, 37, 4),
(180, 'A paradicsomot és az uborkát felkockázzuk, a salátát falatnyira tépjük.', 3, 37, 1),
(181, 'A zöldségeket meglocsoljuk a maradék olajjal, és a csirkével együtt tálaljuk.', 4, 37, 5),
(182, 'A hagymát, a fokhagymát és a chilit apróra vágjuk.', 1, 38, 1),
(183, 'Az olajon megdinszteljük, majd hozzáadjuk a darált húst, és morzsásra pirítjuk.', 2, 38, 3),
(184, 'Megszórjuk a pirospaprikával, hozzáadjuk a paradicsomot és a sót.', 3, 38, 3),
(185, 'Fél órát főzzük, aztán mehet bele a leszűrt bab még 10 percre.', 4, 38, 3),
(186, 'Tejföllel vagy reszelt sajttal is nagyon jó.', 5, 38, 5),
(187, 'A hagymát meghámozzuk, és vékony félkarikákra szeleteljük.', 1, 39, 1),
(188, 'A vajon lassú tűzön, gyakran kevergetve kb. 30 percig karamellizáljuk.', 2, 39, 3),
(189, 'Megszórjuk a liszttel, felöntjük 1 liter vízzel, fűszerezzük, és 15 percig főzzük.', 3, 39, 3),
(190, 'A kenyérszeletekre reszelt sajtot szórunk, és sütőben ráolvasztjuk.', 4, 39, 4),
(191, 'A levest tányérba merjük, és a sajtos pirítóst a tetejére tesszük.', 5, 39, 5),
(192, 'A rizst előre megfőzzük, és hagyjuk teljesen kihűlni (a tegnapi rizs a legjobb).', 1, 40, 3),
(193, 'A sárgarépát apró kockákra, a hagymát vékony csíkokra vágjuk.', 2, 40, 1),
(194, 'Wokban, forró olajon 3-4 percig pirítjuk a répát, a hagymát és a borsót.', 3, 40, 3),
(195, 'Hozzáadjuk a rizst, és erős lángon, folyamatos kevergetéssel átpirítjuk.', 4, 40, 3),
(196, 'Meglocsoljuk a szójaszósszal, és jól összeforgatjuk.', 5, 40, 2),
(197, 'Melegen, köretként vagy önálló ételként tálaljuk.', 6, 40, 5);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `step_category`
--

DROP TABLE IF EXISTS `step_category`;
CREATE TABLE `step_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `step_category`
--

INSERT INTO `step_category` (`id`, `name`, `thumbnail`) VALUES
(1, 'Előkészítés', 'images/steps/preparation.svg'),
(2, 'Elkészítés', 'images/steps/making.svg'),
(3, 'Főzés', 'images/steps/cooking.svg'),
(4, 'Sütés', 'images/steps/baking.svg'),
(5, 'Tálalás', 'images/steps/serving.svg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(254) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `password`, `is_admin`, `avatar`) VALUES
(1, 'admin@kukta.hu', 'kukta', '$2y$12$fLPnZwjOYH.EI94qkVuiKOpZwNsmReRaargO8Hyq3Xc6cPpIAgsSi', 1, NULL),
(2, 'nagy.anna@gmail.com', 'nagyanna', '$2y$12$fLPnZwjOYH.EI94qkVuiKOpZwNsmReRaargO8Hyq3Xc6cPpIAgsSi', 0, NULL),
(3, 'molnar.era@gmail.com', 'molnarera', '$2y$12$fLPnZwjOYH.EI94qkVuiKOpZwNsmReRaargO8Hyq3Xc6cPpIAgsSi', 0, NULL),
(4, 'balogh.peter@gmail.com', 'baloghpeter', '$2y$12$fLPnZwjOYH.EI94qkVuiKOpZwNsmReRaargO8Hyq3Xc6cPpIAgsSi', 0, NULL),
(5, 'varga.zsofia@gmail.com', 'vargazsofia', '$2y$12$fLPnZwjOYH.EI94qkVuiKOpZwNsmReRaargO8Hyq3Xc6cPpIAgsSi', 0, NULL);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- A tábla indexei `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- A tábla indexei `cuisine`
--
ALTER TABLE `cuisine`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `cuisine_recipe`
--
ALTER TABLE `cuisine_recipe`
  ADD PRIMARY KEY (`cuisine_id`,`recipe_id`),
  ADD KEY `cuisine_recipe_recipe_id_foreign` (`recipe_id`);

--
-- A tábla indexei `diet`
--
ALTER TABLE `diet`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `diet_recipe`
--
ALTER TABLE `diet_recipe`
  ADD PRIMARY KEY (`diet_id`,`recipe_id`),
  ADD KEY `diet_recipe_recipe_id_foreign` (`recipe_id`);

--
-- A tábla indexei `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- A tábla indexei `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorite_user_id_recipe_id_unique` (`user_id`,`recipe_id`),
  ADD KEY `favorite_recipe_id_foreign` (`recipe_id`);

--
-- A tábla indexei `food_type`
--
ALTER TABLE `food_type`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `food_type_recipe`
--
ALTER TABLE `food_type_recipe`
  ADD PRIMARY KEY (`food_type_id`,`recipe_id`),
  ADD KEY `food_type_recipe_recipe_id_foreign` (`recipe_id`);

--
-- A tábla indexei `free_from`
--
ALTER TABLE `free_from`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `free_from_recipe`
--
ALTER TABLE `free_from_recipe`
  ADD PRIMARY KEY (`free_from_id`,`recipe_id`),
  ADD KEY `free_from_recipe_recipe_id_foreign` (`recipe_id`);

--
-- A tábla indexei `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ingredient_name_unique` (`name`);

--
-- A tábla indexei `ingredient_recipe`
--
ALTER TABLE `ingredient_recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_recipe_recipe_id_foreign` (`recipe_id`),
  ADD KEY `ingredient_recipe_ingredient_id_foreign` (`ingredient_id`);

--
-- A tábla indexei `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- A tábla indexei `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `meal_time`
--
ALTER TABLE `meal_time`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `meal_time_recipe`
--
ALTER TABLE `meal_time_recipe`
  ADD PRIMARY KEY (`meal_time_id`,`recipe_id`),
  ADD KEY `meal_time_recipe_recipe_id_foreign` (`recipe_id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- A tábla indexei `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rating_user_id_recipe_id_unique` (`user_id`,`recipe_id`),
  ADD KEY `rating_recipe_id_foreign` (`recipe_id`);

--
-- A tábla indexei `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_user_id_foreign` (`user_id`);

--
-- A tábla indexei `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_foreign` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- A tábla indexei `step`
--
ALTER TABLE `step`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `step_recipe_id_position_unique` (`recipe_id`,`position`),
  ADD KEY `step_step_category_id_foreign` (`step_category_id`);

--
-- A tábla indexei `step_category`
--
ALTER TABLE `step_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `step_category_thumbnail_unique` (`thumbnail`);

--
-- A tábla indexei `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`),
  ADD UNIQUE KEY `user_name_unique` (`name`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `cuisine`
--
ALTER TABLE `cuisine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `diet`
--
ALTER TABLE `diet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT a táblához `food_type`
--
ALTER TABLE `food_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT a táblához `free_from`
--
ALTER TABLE `free_from`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT a táblához `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT a táblához `ingredient_recipe`
--
ALTER TABLE `ingredient_recipe`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT a táblához `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `meal_time`
--
ALTER TABLE `meal_time`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `rating`
--
ALTER TABLE `rating`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT a táblához `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT a táblához `step`
--
ALTER TABLE `step`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT a táblához `step_category`
--
ALTER TABLE `step_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `cuisine_recipe`
--
ALTER TABLE `cuisine_recipe`
  ADD CONSTRAINT `cuisine_recipe_cuisine_id_foreign` FOREIGN KEY (`cuisine_id`) REFERENCES `cuisine` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cuisine_recipe_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `diet_recipe`
--
ALTER TABLE `diet_recipe`
  ADD CONSTRAINT `diet_recipe_diet_id_foreign` FOREIGN KEY (`diet_id`) REFERENCES `diet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diet_recipe_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorite_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `food_type_recipe`
--
ALTER TABLE `food_type_recipe`
  ADD CONSTRAINT `food_type_recipe_food_type_id_foreign` FOREIGN KEY (`food_type_id`) REFERENCES `food_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `food_type_recipe_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `free_from_recipe`
--
ALTER TABLE `free_from_recipe`
  ADD CONSTRAINT `free_from_recipe_free_from_id_foreign` FOREIGN KEY (`free_from_id`) REFERENCES `free_from` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `free_from_recipe_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `ingredient_recipe`
--
ALTER TABLE `ingredient_recipe`
  ADD CONSTRAINT `ingredient_recipe_ingredient_id_foreign` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`),
  ADD CONSTRAINT `ingredient_recipe_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `meal_time_recipe`
--
ALTER TABLE `meal_time_recipe`
  ADD CONSTRAINT `meal_time_recipe_meal_time_id_foreign` FOREIGN KEY (`meal_time_id`) REFERENCES `meal_time` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meal_time_recipe_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rating_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Megkötések a táblához `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `step`
--
ALTER TABLE `step`
  ADD CONSTRAINT `step_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `step_step_category_id_foreign` FOREIGN KEY (`step_category_id`) REFERENCES `step_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
