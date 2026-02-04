-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 04 fév. 2026 à 16:44
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `plateforme-events`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'URL-friendly',
  `description` text COLLATE utf8mb4_general_ci,
  `color` varchar(7) COLLATE utf8mb4_general_ci DEFAULT '#667eea' COMMENT 'Code couleur hexadécimal',
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Font Awesome icon class',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Arts & Créativité', 'arts-creativite', 'Ateliers artistiques et créatifs', '#e74c3c', 'fa-palette', 1, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(2, 'Développement Personnel', 'dev-personnel', 'Croissance et bien-être personnel', '#3498db', 'fa-brain', 1, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(3, 'Sport & Fitness', 'sport-fitness', 'Activités physiques et sportives', '#2ecc71', 'fa-running', 1, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(4, 'Cuisine & Gastronomie', 'cuisine-gastronomie', 'Ateliers culinaires', '#f39c12', 'fa-utensils', 1, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(5, 'Technologie & Numérique', 'tech-numerique', 'Informatique et nouvelles technologies', '#9b59b6', 'fa-laptop-code', 1, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(6, 'Culture & Conférences', 'culture-conferences', 'Événements culturels et conférences', '#1abc9c', 'fa-book-open', 1, '2026-02-02 09:00:18', '2026-02-02 09:00:18');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'URL-friendly',
  `type` enum('atelier','evenement') COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Type de contenu',
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `short_description` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Résumé court pour listing',
  `date_start` datetime NOT NULL,
  `date_end` datetime DEFAULT NULL COMMENT 'Optionnel pour événements multi-jours',
  `duration` int DEFAULT NULL COMMENT 'Durée en minutes',
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Adresse ou lieu',
  `location_city` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `location_postal_code` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_online` tinyint(1) DEFAULT '0',
  `online_link` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Lien visio si en ligne',
  `capacity` int NOT NULL DEFAULT '20' COMMENT 'Nombre de places total',
  `available_spots` int NOT NULL DEFAULT '20' COMMENT 'Places restantes',
  `min_participants` int DEFAULT '1' COMMENT 'Minimum de participants',
  `price` decimal(10,2) DEFAULT '0.00',
  `currency` varchar(3) COLLATE utf8mb4_general_ci DEFAULT 'EUR',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Nom du fichier image',
  `category_id` int DEFAULT NULL,
  `organizer_id` int DEFAULT NULL COMMENT 'Admin qui a créé l''événement',
  `status` enum('draft','published','cancelled','completed','full') COLLATE utf8mb4_general_ci DEFAULT 'draft',
  `is_featured` tinyint(1) DEFAULT '0' COMMENT 'Mise en avant',
  `views_count` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `slug`, `type`, `description`, `short_description`, `date_start`, `date_end`, `duration`, `location`, `location_city`, `location_postal_code`, `is_online`, `online_link`, `capacity`, `available_spots`, `min_participants`, `price`, `currency`, `image`, `category_id`, `organizer_id`, `status`, `is_featured`, `views_count`, `created_at`, `updated_at`) VALUES
(2, 'Yoga Matinal en Plein', 'yoga-matinal-en-plein', 'atelier', 'Séance de yoga pour bien commencer la journée, en pleine nature.', 'Réveillez votre corps avec le yoga', '2026-03-20 08:00:00', '2026-03-20 09:30:00', 90, 'Parc de la Tête d\'Or', 'Lyondvdsqd', '', 0, 'uploads/events/arthi.jpg', 25, 17, 1, 15.00, 'EUR', 'public/uploads/events/event_6981b2ade4f090.36382668.jpg', NULL, NULL, 'published', 0, 0, '2026-02-02 09:00:18', '2026-02-03 08:32:45'),
(3, 'Cuisine Japonaise : Sushis', 'cuisine-japonaise-sushis', 'atelier', 'Apprenez à préparer vos propres sushis avec un chef professionnel.', 'Atelier cuisine : maîtrisez l\'art des sushis', '2026-04-05 18:30:00', '2026-04-05 21:00:00', 150, 'École de Cuisine Le Gourmet, 8 avenue Victor Hugo', 'Marseille', '', 0, NULL, 12, 2, 1, 65.00, 'EUR', 'public/uploads/events/event_6981b262c33017.28403138.jpg', 4, NULL, 'published', 1, 0, '2026-02-02 09:00:18', '2026-02-03 08:55:30'),
(4, 'Conférence : Intelligence Artificielle', 'conf-erence-intelligence-artificielle', 'evenement', 'Conférence sur les dernières avancées de l\'IA et son impact sur la société.', 'Découvrez l\'avenir de l\'IA avec des experts', '2026-05-10 19:00:00', '2026-05-10 22:00:00', 180, 'Auditorium TechHub, 45 rue de la Innovation', 'Nantes', '', 0, NULL, 200, 149, 1, 0.00, 'EUR', 'public/uploads/events/event_6981ea3d7cdd44.50753471.jpg', 5, NULL, 'published', 1, 10, '2026-02-02 09:00:18', '2026-02-04 07:47:47'),
(5, 'Festival d\'Été : Musique et Arts !!', 'festival-d-et-e-musique-et-arts', 'evenement', 'Trois jours de musique, performances artistiques et gastronomie.', 'Le plus grand festival de l\'été !', '2026-07-15 10:00:00', '2026-07-17 23:59:00', NULL, 'Esplanade du Parc Central', 'Bordeaux', '', 0, NULL, 5000, 4235, 1, 45.00, 'EUR', 'public/uploads/events/event_6981ea16237602.47177211.jpg', 6, NULL, 'published', 1, 5, '2026-02-02 09:00:18', '2026-02-03 12:29:10'),
(6, 'Atelier de peinture sur vitre', 'atelier-de-peinture-sur-vitre', 'atelier', 'nvbjkdfbgoogfbidkq', 'au cafe entre amis pour peindre !', '2026-09-20 19:00:00', '2026-09-20 22:00:00', NULL, '3 rue Angel', 'angers', '49100', 0, NULL, 18, 20, 1, 25.00, 'EUR', NULL, NULL, NULL, 'draft', 0, 0, '2026-02-02 14:09:31', '2026-02-02 14:09:31'),
(7, 'dev ops', 'dev-ops', 'atelier', 'vdvsqds', 'vdscqx', '2026-02-20 01:33:00', '2026-02-20 04:00:00', NULL, 'FVDFdf', 'sq', 'ezasq', 0, '', 20, 20, 1, 20.00, 'EUR', 'public/uploads/events/event_6981b3a8a137f6.09994532.jpg', 5, NULL, 'published', 0, 0, '2026-02-02 14:12:05', '2026-02-03 08:36:56'),
(8, 'atelier GRAND et petit', 'atelier-grand-et-petit', 'atelier', 'bfvdsqq<', 'TGRFEDZSAQ', '2026-09-29 10:00:00', '2026-09-29 12:00:00', NULL, 'bfdcsx', 'FEZZSAQ', 'FEDZSAQ', 0, '', 20, 20, 1, 20.00, 'EUR', 'public/uploads/events/event_6981b28d0eb6e9.91142295.jpg', NULL, NULL, 'published', 0, 0, '2026-02-02 14:26:20', '2026-02-03 08:32:13'),
(9, 'Cuisine Familiale', 'cuisine-familiale', 'atelier', 'vdcsxqw', 'vfdcsxw', '2022-02-20 22:22:00', '2022-02-20 00:22:00', NULL, '15 rue derouet', 'A1A', 'szas', 0, '', 20, 20, 1, 20.00, 'EUR', 'public/uploads/events/event_698311377710c1.43285202.jpg', 4, NULL, 'published', 0, 0, '2026-02-02 14:32:09', '2026-02-04 09:28:23'),
(10, 'Art contemporain et moderne art', 'art-contemporain-et-moderne-art', 'atelier', 'gfez', '', '2026-02-20 20:00:00', '2026-02-20 22:00:00', NULL, 'vfds', '', '', 0, '', 20, 19, 1, 10.00, 'EUR', 'public/uploads/events/event_6981f2930c05c8.81105291.jpg', 1, NULL, 'published', 0, 0, '2026-02-02 15:40:38', '2026-02-04 07:48:06'),
(11, 'Cours body combat', 'cours-body-combat', 'atelier', 'dss', 'fddsq', '2026-02-20 12:00:00', '2026-02-20 15:00:00', NULL, '12 rue poupoi', 'Angers', '49610', 0, '', 20, 20, 1, 10.00, 'EUR', 'public/uploads/events/event_6981f2592d2754.58799318.jpg', 3, NULL, 'published', 0, 0, '2026-02-02 16:36:46', '2026-02-03 13:04:25'),
(12, 'Conference Ekhart Tollé', 'conference-ekhart-toll-e', 'atelier', 'gbfvdc', 'gfd', '2026-02-20 22:22:00', '2026-02-20 22:58:00', NULL, '15 rue japeo', '', '', 0, '', 20, 20, 1, 10.00, 'EUR', 'public/uploads/events/event_6981f244a10cb5.05316540.jpg', 4, NULL, 'published', 0, 0, '2026-02-02 16:43:20', '2026-02-03 13:04:04'),
(13, 'CUISINE TAI', 'cuisine-tai', 'atelier', 'FDS', '', '2026-02-20 19:00:00', '2026-02-20 22:00:00', NULL, 'FDSQ', '', '', 0, '', 20, 20, 1, 30.00, 'EUR', 'public/uploads/events/event_6981b23caa2c55.77067026.jpg', 4, NULL, 'published', 0, 0, '2026-02-03 08:21:10', '2026-02-03 08:55:14'),
(14, 'Meditation pleine conscience', 'meditation-pleine-conscience', 'atelier', '', '', '2026-02-20 20:00:00', '2026-02-20 22:00:00', NULL, 'fvdsq', '', '', 0, '', 20, 20, 1, 30.00, 'EUR', 'public/uploads/events/event_6981b168339f08.49130993.jpg', 2, NULL, 'published', 0, 0, '2026-02-03 08:27:20', '2026-02-03 08:27:20'),
(15, 'Evenement pop art', 'evenement-pop-art', 'evenement', '', '', '2026-02-20 19:00:00', '2026-02-20 22:00:00', NULL, '12 rue andy waroll', '', '', 0, '', 50, 50, 1, 20.00, 'EUR', 'public/uploads/events/event_6981c2644447b6.24517672.jpg', 1, NULL, 'published', 0, 3, '2026-02-03 09:39:48', '2026-02-03 09:40:50');

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

CREATE TABLE `favorites` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `reservation_number` varchar(20) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Ex: RES-2024-00123',
  `status` enum('pending','confirmed','cancelled','attended','no_show') COLLATE utf8mb4_general_ci DEFAULT 'confirmed',
  `number_of_seats` int DEFAULT '1' COMMENT 'Nombre de places réservées',
  `amount_paid` decimal(10,2) DEFAULT '0.00',
  `payment_status` enum('pending','paid','refunded') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `payment_method` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'CB, PayPal, etc.',
  `reserved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_general_ci,
  `user_notes` text COLLATE utf8mb4_general_ci COMMENT 'Notes de l''utilisateur',
  `admin_notes` text COLLATE utf8mb4_general_ci COMMENT 'Notes internes admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `event_id`, `reservation_number`, `status`, `number_of_seats`, `amount_paid`, `payment_status`, `payment_method`, `reserved_at`, `confirmed_at`, `cancelled_at`, `cancellation_reason`, `user_notes`, `admin_notes`, `created_at`, `updated_at`) VALUES
(3, 4, 2, 'RES-2026-00003', 'confirmed', 1, 15.00, 'paid', NULL, '2026-02-02 09:00:18', '2026-02-02 10:00:18', NULL, NULL, NULL, NULL, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(4, 2, 3, 'RES-2026-00004', 'confirmed', 1, 65.00, 'paid', NULL, '2026-02-02 09:00:18', '2026-02-02 10:00:18', NULL, NULL, NULL, NULL, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(5, 7, 4, 'RES-2026-00005', 'confirmed', 1, 0.00, 'pending', 'CB', '2026-02-04 07:47:47', NULL, NULL, NULL, '', NULL, '2026-02-04 07:47:47', '2026-02-04 07:47:47'),
(6, 7, 10, 'RES-2026-00006', 'confirmed', 1, 10.00, 'pending', 'CB', '2026-02-04 07:48:06', NULL, NULL, NULL, '', NULL, '2026-02-04 07:48:06', '2026-02-04 07:48:06');

--
-- Déclencheurs `reservations`
--
DELIMITER $$
CREATE TRIGGER `decrease_spots_after_reservation` AFTER INSERT ON `reservations` FOR EACH ROW BEGIN
    IF NEW.status = 'confirmed' THEN
        UPDATE events 
        SET available_spots = available_spots - NEW.number_of_seats
        WHERE id = NEW.event_id;
        
        -- Mettre à jour le statut 'full' si plus de places
        UPDATE events 
        SET status = 'full'
        WHERE id = NEW.event_id AND available_spots <= 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `generate_reservation_number` BEFORE INSERT ON `reservations` FOR EACH ROW BEGIN
    DECLARE next_number INT;
    DECLARE reservation_num VARCHAR(20);
    
    -- Récupérer le dernier numéro
    SELECT COALESCE(MAX(CAST(SUBSTRING(reservation_number, 10) AS UNSIGNED)), 0) + 1
    INTO next_number
    FROM reservations
    WHERE YEAR(reserved_at) = YEAR(CURRENT_TIMESTAMP);
    
    -- Générer le numéro : RES-2024-00001
    SET reservation_num = CONCAT('RES-', YEAR(CURRENT_TIMESTAMP), '-', LPAD(next_number, 5, '0'));
    SET NEW.reservation_number = reservation_num;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `increase_spots_after_cancellation` AFTER UPDATE ON `reservations` FOR EACH ROW BEGIN
    IF OLD.status = 'confirmed' AND NEW.status = 'cancelled' THEN
        UPDATE events 
        SET available_spots = available_spots + OLD.number_of_seats,
            status = CASE 
                WHEN status = 'full' THEN 'published'
                ELSE status
            END
        WHERE id = OLD.event_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `reservation_id` int DEFAULT NULL COMMENT 'Lien avec la réservation',
  `rating` int NOT NULL COMMENT 'Note de 1 à 5',
  `comment` text COLLATE utf8mb4_general_ci,
  `is_approved` tinyint(1) DEFAULT '0' COMMENT 'Modération',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `event_id`, `reservation_id`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(2, 3, 2, NULL, 4, 'Très bonne expérience, cadre magnifique.', 1, '2026-02-02 09:00:18', '2026-02-02 09:00:18');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'admin, user, visitor',
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'admin', 'Administrateur - Accès complet', '2026-02-02 09:00:18'),
(2, 'user', 'Utilisateur connecté - Peut réserver', '2026-02-02 09:00:18'),
(3, 'visitor', 'Visiteur - Consultation uniquement', '2026-02-02 09:00:18');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Hash bcrypt',
  `first_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role_id` int NOT NULL DEFAULT '2' COMMENT 'Par défaut : user',
  `is_active` tinyint(1) DEFAULT '1',
  `email_verified` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `phone`, `role_id`, `is_active`, `email_verified`, `last_login`, `created_at`, `updated_at`) VALUES
(2, 'john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Doe', NULL, 2, 1, 1, NULL, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(3, 'marie_dupont', 'marie@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Marie', 'Dupont', NULL, 2, 1, 1, NULL, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(4, 'pierre_martin', 'pierre@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pierre', 'Martin', NULL, 2, 1, 1, NULL, '2026-02-02 09:00:18', '2026-02-02 09:00:18'),
(6, 'admin', 'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Test', NULL, 1, 1, 1, '2026-02-04 10:07:56', '2026-02-03 13:45:47', '2026-02-04 09:07:56'),
(7, 'prudy', 'prudy@gmail.com', '$2y$10$U9HOG2zTvH7yubFBsvDXhOYhHfOv4d2P6IU.YPKgcGWJDGYQjQGXi', NULL, NULL, NULL, 2, 1, 0, '2026-02-04 08:34:11', '2026-02-04 07:34:02', '2026-02-04 07:34:11');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_events_full`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `v_events_full` (
`available_spots` int
,`capacity` int
,`category_color` varchar(7)
,`category_icon` varchar(50)
,`category_id` int
,`category_name` varchar(100)
,`created_at` timestamp
,`currency` varchar(3)
,`date_end` datetime
,`date_start` datetime
,`description` text
,`duration` int
,`fill_rate` decimal(17,2)
,`id` int
,`image` varchar(255)
,`is_featured` tinyint(1)
,`is_online` tinyint(1)
,`location` varchar(255)
,`location_city` varchar(100)
,`location_postal_code` varchar(10)
,`min_participants` int
,`online_link` varchar(500)
,`organizer_id` int
,`organizer_name` varchar(50)
,`price` decimal(10,2)
,`reserved_spots` bigint
,`short_description` varchar(500)
,`slug` varchar(255)
,`status` enum('draft','published','cancelled','completed','full')
,`time_status` varchar(8)
,`title` varchar(255)
,`type` enum('atelier','evenement')
,`updated_at` timestamp
,`views_count` int
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_event_stats`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `v_event_stats` (
`cancelled_count` decimal(23,0)
,`confirmed_count` decimal(23,0)
,`event_id` int
,`title` varchar(255)
,`total_reservations` bigint
,`total_revenue` decimal(32,2)
,`total_seats_booked` decimal(32,0)
,`type` enum('atelier','evenement')
);

-- --------------------------------------------------------

--
-- Structure de la vue `v_events_full`
--
DROP TABLE IF EXISTS `v_events_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_events_full`  AS SELECT `e`.`id` AS `id`, `e`.`title` AS `title`, `e`.`slug` AS `slug`, `e`.`type` AS `type`, `e`.`description` AS `description`, `e`.`short_description` AS `short_description`, `e`.`date_start` AS `date_start`, `e`.`date_end` AS `date_end`, `e`.`duration` AS `duration`, `e`.`location` AS `location`, `e`.`location_city` AS `location_city`, `e`.`location_postal_code` AS `location_postal_code`, `e`.`is_online` AS `is_online`, `e`.`online_link` AS `online_link`, `e`.`capacity` AS `capacity`, `e`.`available_spots` AS `available_spots`, `e`.`min_participants` AS `min_participants`, `e`.`price` AS `price`, `e`.`currency` AS `currency`, `e`.`image` AS `image`, `e`.`category_id` AS `category_id`, `e`.`organizer_id` AS `organizer_id`, `e`.`status` AS `status`, `e`.`is_featured` AS `is_featured`, `e`.`views_count` AS `views_count`, `e`.`created_at` AS `created_at`, `e`.`updated_at` AS `updated_at`, `c`.`name` AS `category_name`, `c`.`color` AS `category_color`, `c`.`icon` AS `category_icon`, `u`.`username` AS `organizer_name`, (`e`.`capacity` - `e`.`available_spots`) AS `reserved_spots`, round((((`e`.`capacity` - `e`.`available_spots`) / `e`.`capacity`) * 100),2) AS `fill_rate`, (case when (`e`.`date_start` < now()) then 'past' when (`e`.`date_start` > now()) then 'upcoming' else 'today' end) AS `time_status` FROM ((`events` `e` left join `categories` `c` on((`e`.`category_id` = `c`.`id`))) left join `users` `u` on((`e`.`organizer_id` = `u`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `v_event_stats`
--
DROP TABLE IF EXISTS `v_event_stats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_event_stats`  AS SELECT `e`.`id` AS `event_id`, `e`.`title` AS `title`, `e`.`type` AS `type`, count(`r`.`id`) AS `total_reservations`, sum(`r`.`number_of_seats`) AS `total_seats_booked`, sum((case when (`r`.`status` = 'confirmed') then 1 else 0 end)) AS `confirmed_count`, sum((case when (`r`.`status` = 'cancelled') then 1 else 0 end)) AS `cancelled_count`, sum(`r`.`amount_paid`) AS `total_revenue` FROM (`events` `e` left join `reservations` `r` on((`e`.`id` = `r`.`event_id`))) GROUP BY `e`.`id` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_active` (`is_active`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `organizer_id` (`organizer_id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_date_start` (`date_start`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_category` (`category_id`),
  ADD KEY `idx_featured` (`is_featured`);
ALTER TABLE `events` ADD FULLTEXT KEY `idx_search` (`title`,`description`);

--
-- Index pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_event_favorite` (`user_id`,`event_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_event` (`event_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_number` (`reservation_number`),
  ADD UNIQUE KEY `unique_user_event` (`user_id`,`event_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_event` (`event_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_reservation_number` (`reservation_number`),
  ADD KEY `idx_reserved_at` (`reserved_at`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_event_review` (`user_id`,`event_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `idx_event` (`event_id`),
  ADD KEY `idx_rating` (`rating`),
  ADD KEY `idx_approved` (`is_approved`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_role` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
