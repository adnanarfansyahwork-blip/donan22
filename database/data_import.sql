-- =====================================================
-- DONAN22 DATA IMPORT FILE
-- =====================================================
-- This file contains INSERT statements for restoring data
-- Run AFTER: php artisan migrate
-- 
-- Import via phpMyAdmin or mysql command line:
-- mysql -u username -p database_name < database/data_import.sql
-- =====================================================

-- Disable foreign key checks during import
SET FOREIGN_KEY_CHECKS = 0;

-- Clear existing data (optional - uncomment if needed)
-- TRUNCATE TABLE download_links;
-- TRUNCATE TABLE monetized_links;
-- TRUNCATE TABLE posts;
-- TRUNCATE TABLE post_types;
-- TRUNCATE TABLE categories;
-- TRUNCATE TABLE administrators;

-- =====================================================
-- ADMINISTRATORS
-- =====================================================
INSERT INTO `administrators` (`id`, `name`, `email`, `password`, `role`, `avatar`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@donan22.com', '$2y$12$e4HoLRk.nPcAEEqSpzSrTeojvMdtVWUYrJDi0VcWrFYxN/Ga.qfYy', 'admin', 'administrators/admin-avatar.png', 1, '2025-09-27 17:28:19', '2025-10-04 22:33:02'),
(2, 'Superdonan22', 'superdonan22@donan22.com', '$2y$12$e4HoLRk.nPcAEEqSpzSrTeojvMdtVWUYrJDi0VcWrFYxN/Ga.qfYy', 'admin', 'administrators/superdonan22-avatar.png', 1, '2025-10-04 19:20:05', '2025-10-04 19:20:05'),
(3, 'adnandewa', 'adnandewa@donan22.com', '$2y$12$e4HoLRk.nPcAEEqSpzSrTeojvMdtVWUYrJDi0VcWrFYxN/Ga.qfYy', 'admin', 'administrators/adnandewa-avatar.png', 1, '2025-10-04 20:47:10', '2025-10-04 20:47:10'),
(4, 'editor', 'editor@donan22.com', '$2y$12$nFzKFWwT4.lRR1xH8JqQR.h0QhHvJmL.U0B0HyE7VrJz8YnJYqMKS', 'editor', NULL, 1, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(5, 'moderator', 'moderator@donan22.com', '$2y$12$vGxLKHPR6NqKZF5Y.DhHxeWJSJ.CK1PaJq7aWZ3x5F7qQfBb.2P9.', 'moderator', NULL, 1, '2025-09-27 17:28:19', '2025-09-27 17:28:19')
ON DUPLICATE KEY UPDATE 
    name = VALUES(name),
    email = VALUES(email),
    role = VALUES(role);

-- =====================================================
-- CATEGORIES
-- =====================================================
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `meta_title`, `meta_description`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Game PC', 'game-pc', 'PC games for Windows and Mac', 'fas fa-gamepad', 'PC Games - Download Latest Games', 'Download the latest PC games for Windows and Mac', 1, 1, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(2, 'Software', 'software', 'Software applications and programs', 'fas fa-download', 'Software Downloads', 'Download the latest software applications', 1, 2, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(3, 'Blog', 'blog', 'Blog articles and tutorials', 'fas fa-blog', 'Blog - Tips & Tutorials', 'Read our latest blog articles and tutorials', 1, 3, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(4, 'Mobile Apps', 'mobile-apps', 'Android and iOS applications', 'fas fa-mobile-alt', 'Mobile Apps - Android & iOS', 'Download the latest mobile applications', 1, 4, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(5, 'Windows Software', 'windows-software', 'Software for Windows OS', 'fab fa-windows', 'Windows Software Downloads', 'Download the latest Windows software', 1, 5, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(6, 'Mac Software', 'mac-software', 'Software for macOS', 'fab fa-apple', 'Mac Software Downloads', 'Download the latest macOS software', 1, 6, '2025-09-27 17:28:19', '2025-09-27 17:28:19')
ON DUPLICATE KEY UPDATE 
    name = VALUES(name),
    slug = VALUES(slug),
    description = VALUES(description);

-- =====================================================
-- POST TYPES
-- =====================================================
INSERT INTO `post_types` (`id`, `name`, `slug`, `description`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Software', 'software', 'Software applications and programs for PC', 'fas fa-download', 1, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(2, 'Games', 'games', 'PC games, mobile games, and console games', 'fas fa-gamepad', 1, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(3, 'Blog', 'blog', 'Step-by-step tutorials and guides', 'fas fa-book', 1, '2025-09-27 17:28:19', '2025-10-08 02:56:20'),
(4, 'Mobile Apps', 'mobile-apps', 'Android and iOS applications', 'fas fa-mobile-alt', 1, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(5, 'Windows Software', 'windows-software', 'Windows specific applications', 'fab fa-windows', 1, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(6, 'Mac Software', 'mac-software', 'macOS specific applications', 'fab fa-apple', 1, '2025-09-27 17:28:19', '2025-09-27 17:28:19'),
(7, 'Game', 'game', 'PC and mobile games', 'fas fa-gamepad', 1, '2025-09-27 19:01:48', '2025-09-27 19:01:48'),
(8, 'Mobile App', 'mobile-app', 'Android and iOS applications', 'fas fa-mobile-alt', 1, '2025-09-27 19:01:48', '2025-09-27 19:01:48'),
(9, 'Guide', 'guide', 'How-to guides and documentation', 'fas fa-book', 1, '2025-09-27 19:01:48', '2025-09-27 19:01:48')
ON DUPLICATE KEY UPDATE 
    name = VALUES(name),
    slug = VALUES(slug),
    description = VALUES(description);

-- =====================================================
-- SETTINGS
-- =====================================================
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Donan22', NOW(), NOW()),
(2, 'site_description', 'Download Software, Games, and Apps', NOW(), NOW()),
(3, 'google_site_verification', '57FjeBMKdUbN9FCNyR8ChLgsWir5KB4IWo21JzdPLPw', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
    value = VALUES(value);

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- IMPORTANT NOTES:
-- =====================================================
-- For POSTS and DOWNLOAD_LINKS data:
-- 1. Open donanlaravel.sql in a text editor
-- 2. Find the INSERT INTO `posts` statements (around line 1577)
-- 3. Find the INSERT INTO `download_links` statements (around line 194)
-- 4. Copy those INSERT statements and run them separately
--
-- Or import the full donanlaravel.sql file and it will update
-- the existing tables with the data.
-- =====================================================
