-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 11 déc. 2022 à 18:05
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `backendfirstapp`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'aaaaab', 'aaab', '2022-08-15 09:09:52', '2022-08-22 07:29:30');

-- --------------------------------------------------------

--
-- Structure de la table `codes`
--

CREATE TABLE `codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `codes`
--

INSERT INTO `codes` (`id`, `user_id`, `code`, `expire_at`, `created_at`, `updated_at`) VALUES
(1, 4, '370249', '2022-08-19 07:54:11', '2022-08-19 06:54:11', '2022-08-19 06:54:11'),
(2, 4, '245516', '2022-08-19 07:55:13', '2022-08-19 06:55:13', '2022-08-19 06:55:13'),
(3, 4, '375007', '2022-08-19 07:58:39', '2022-08-19 06:58:39', '2022-08-19 06:58:39'),
(4, 4, '164578', '2022-08-19 08:00:47', '2022-08-19 07:00:47', '2022-08-19 07:00:47');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` double(8,2) NOT NULL,
  `lieuLivraison` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prixTotal` double(8,2) NOT NULL,
  `typeLivraison` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modePayment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `deliveryPrice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_products`
--

CREATE TABLE `commande_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_product` bigint(20) UNSIGNED NOT NULL,
  `id_commande` bigint(20) UNSIGNED NOT NULL,
  `qte` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `refFacture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double(8,2) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commande_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_08_02_072627_create_categories_table', 1),
(6, '2022_08_02_072718_create_products_table', 1),
(7, '2022_08_03_073753_create_orders_table', 1),
(8, '2022_08_03_073828_create_sub_categories_table', 1),
(9, '2022_08_03_073845_create_commandes_table', 1),
(10, '2022_08_03_073903_create_factures_table', 1),
(11, '2022_08_03_080046_create_commande_products_table', 1),
(12, '2022_08_03_083342_create_order_products_table', 1),
(13, '2022_08_08_080443_create_codes_table', 1),
(14, '2022_08_09_072023_create_verify_mails_table', 1),
(15, '2022_08_12_091840_create_product_images_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qte` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_product` bigint(20) UNSIGNED NOT NULL,
  `id_order` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `ref`, `name`, `description`, `sub_category_id`, `provider_id`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(50, 'eeett', 'eeett', 'eeett', 1, 1, 45.00, 45, '2022-08-16 09:19:51', '2022-08-16 09:19:51'),
(51, 'zzezze', 'zzzzzze', 'eeeez', 1, 1, 44.00, 44, '2022-08-16 09:21:11', '2022-08-16 09:21:11'),
(52, '2233556', 'ppppppppppeeeereedddrsj', 'pppppppp', 1, 1, 20.00, 15, '2022-08-16 09:21:19', '2022-08-16 09:21:19'),
(53, '2233556', 'pppppppp', 'pppppppp', 1, 1, 20.00, 15, '2022-08-16 09:21:48', '2022-08-16 09:21:48'),
(54, '2233556', 'ppppppppp', 'pppppppp', 1, 1, 20.00, 15, '2022-08-16 09:22:50', '2022-08-16 09:22:50'),
(55, 'eeer', 'eeer', 'eer', 1, 1, 4.00, 4, '2022-08-16 09:23:15', '2022-08-16 09:23:15'),
(56, 'rrre', 'rrre', 'rrre', 1, 1, 45.00, 45, '2022-08-16 09:24:30', '2022-08-16 09:24:30'),
(57, 'eere', 'eere', 'eere', 1, 1, 45.00, 45, '2022-08-16 09:25:45', '2022-08-16 09:25:45'),
(58, 'rrttttt', 'rrrrrrrrt', 'eeeeer', 1, 1, 77.00, 77, '2022-08-16 09:27:30', '2022-08-16 09:27:30');

-- --------------------------------------------------------

--
-- Structure de la table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `picture`, `created_at`, `updated_at`) VALUES
(1, 1, '191264220815101017.jpg', '2022-08-15 09:10:17', '2022-08-15 09:10:17'),
(2, 1, '680835220815101017.jpg', '2022-08-15 09:10:17', '2022-08-15 09:10:17'),
(3, 1, '940011220815101017.jpg', '2022-08-15 09:10:17', '2022-08-15 09:10:17'),
(4, 19, '847708220816075716.jpg', '2022-08-16 06:57:16', '2022-08-16 06:57:16'),
(5, 19, '831588220816075716.jpg', '2022-08-16 06:57:16', '2022-08-16 06:57:16'),
(6, 19, '625581220816075716.jpg', '2022-08-16 06:57:16', '2022-08-16 06:57:16'),
(7, 38, '257391220816100815.jpg', '2022-08-16 09:08:15', '2022-08-16 09:08:15'),
(8, 38, '210483220816100816.jpg', '2022-08-16 09:08:16', '2022-08-16 09:08:16'),
(9, 38, '504642220816100816.jpg', '2022-08-16 09:08:16', '2022-08-16 09:08:16'),
(10, 40, '829227220816100958.jpg', '2022-08-16 09:09:58', '2022-08-16 09:09:58'),
(11, 40, '899726220816100958.jpg', '2022-08-16 09:09:58', '2022-08-16 09:09:58'),
(12, 40, '071917220816100958.jpg', '2022-08-16 09:09:58', '2022-08-16 09:09:58'),
(13, 46, '929913220816101511.jpg', '2022-08-16 09:15:11', '2022-08-16 09:15:11'),
(14, 46, '344192220816101511.jpg', '2022-08-16 09:15:11', '2022-08-16 09:15:11'),
(15, 46, '433391220816101511.jpg', '2022-08-16 09:15:11', '2022-08-16 09:15:11'),
(16, 47, '560568220816101644.jpg', '2022-08-16 09:16:44', '2022-08-16 09:16:44'),
(17, 47, '792932220816101644.jpg', '2022-08-16 09:16:44', '2022-08-16 09:16:44'),
(18, 47, '386391220816101644.jpg', '2022-08-16 09:16:44', '2022-08-16 09:16:44'),
(19, 52, '384251220816102119.jpg', '2022-08-16 09:21:19', '2022-08-16 09:21:19'),
(20, 52, '456478220816102119.jpg', '2022-08-16 09:21:19', '2022-08-16 09:21:19'),
(21, 52, '492681220816102119.jpg', '2022-08-16 09:21:19', '2022-08-16 09:21:19'),
(22, 53, '317708220816102148.jpg', '2022-08-16 09:21:48', '2022-08-16 09:21:48'),
(23, 53, '262135220816102148.jpg', '2022-08-16 09:21:48', '2022-08-16 09:21:48'),
(24, 53, '415293220816102149.jpg', '2022-08-16 09:21:49', '2022-08-16 09:21:49'),
(25, 54, '153096220816102250.jpg', '2022-08-16 09:22:50', '2022-08-16 09:22:50');

-- --------------------------------------------------------

--
-- Structure de la table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `description`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'eeeee', 'eeeeeee', 1, '2022-08-15 09:10:01', '2022-08-15 09:10:01');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `address`, `matricule`, `company`, `service`, `city`, `cin`, `phone`, `picture`, `role`, `enabled`, `email_verified`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'amine azaiezz', 'prov@gmail.com', NULL, '$2y$10$yBlUkcwUjPUlfZ1bkw.b6O6RMmA71/Q5TJhfL5UOZrt9MNVr1T4D2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '220815100825.jpg', '3', 0, 1, NULL, '2022-08-15 09:08:25', '2022-08-15 09:08:25'),
(2, 'amine azaiezz', 'admin@gmail.com', NULL, '$2y$10$dy9rJ3UYOcRvvCL82vfYOe.zMBDDa3OXAzKD6LUxTSe1rLBfS8AHW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '220815100837.jpg', '1', 0, 1, NULL, '2022-08-15 09:08:37', '2022-08-15 09:08:37'),
(3, 'amine az22', 'aadmin@gmail.com', NULL, '$2y$10$7lx1pONV7IjrGnaMFzu1jelGcG.1P2XE1FDyLDPOby2VRTEGQkxb2', '1231231122', '1231231122', '111122', '12312311122', '12311122', '12365411122', '1232111122', NULL, '1', 0, 1, NULL, '2022-08-17 08:17:44', '2022-08-18 09:23:02'),
(4, 'amine azaiezz', 'amineazaiez@icloud.com', NULL, '$2y$10$lg0op25b97y0.LjVXmuG5OjbT6sJMW6FtYOakTMbocR3KXY3eBUYe', 'jawhra sousse', 'null', 'ISITCOM', 'Etudiant', 'Sousse', 'null', '23123123', '220830113949.jpg', '1', 0, 1, NULL, '2022-08-19 06:40:00', '2022-08-30 10:39:49'),
(6, 'azaiez', 'amineazaiez505@gmail.com', '2022-08-19 07:53:32', '$2y$10$zNzAKM2X2YIjSXt/VBsAzuAyhusHPNSaT7FiOYJ1KK876ACgmSf1G', '55555555', '555555555', '55555555', '555555', '5555555', '555555', '555555', 'avatar.png', '2', 0, 0, NULL, '2022-08-19 07:52:27', '2022-08-19 07:53:32');

-- --------------------------------------------------------

--
-- Structure de la table `verify_mails`
--

CREATE TABLE `verify_mails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `verify_mails`
--

INSERT INTO `verify_mails` (`id`, `user_id`, `token`, `expire_at`, `created_at`, `updated_at`) VALUES
(2, 6, '5318', '2022-08-19 08:52:27', '2022-08-19 07:52:27', '2022-08-19 07:52:27');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande_products`
--
ALTER TABLE `commande_products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factures_commande_id_foreign` (`commande_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_cin_unique` (`cin`);

--
-- Index pour la table `verify_mails`
--
ALTER TABLE `verify_mails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `codes`
--
ALTER TABLE `codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_products`
--
ALTER TABLE `commande_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `verify_mails`
--
ALTER TABLE `verify_mails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_commande_id_foreign` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
