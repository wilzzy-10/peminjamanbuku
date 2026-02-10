-- =====================================================
-- DATABASE SCHEMA - APLIKASI PEMINJAMAN BUKU
-- 3 Role System: Admin, Petugas, User
-- =====================================================

-- =====================================================
-- 1. USERS TABLE (Tabel Pengguna)
-- =====================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` enum('user','member','petugas','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `users_email_index` (`email`),
  KEY `users_role_index` (`role`),
  KEY `users_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. CATEGORIES TABLE (Tabel Kategori Buku)
-- =====================================================
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `description` longtext COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `categories_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. BOOKS TABLE (Tabel Buku)
-- =====================================================
CREATE TABLE IF NOT EXISTS `books` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `description` longtext COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `year` int NULL DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT 1,
  `available_quantity` int NOT NULL DEFAULT 1,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `books_category_id_index` (`category_id`),
  KEY `books_isbn_index` (`isbn`),
  KEY `books_title_index` (`title`),
  CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. LOANS TABLE (Tabel Peminjaman)
-- =====================================================
CREATE TABLE IF NOT EXISTS `loans` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `loan_date` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `return_date` datetime NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` longtext COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `loans_user_id_index` (`user_id`),
  KEY `loans_book_id_index` (`book_id`),
  KEY `loans_status_index` (`status`),
  KEY `loans_due_date_index` (`due_date`),
  CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loans_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. PASSWORD RESET TOKENS TABLE (Laravel Default)
-- =====================================================
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL PRIMARY KEY,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. SESSIONS TABLE (Laravel Default)
-- =====================================================
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL PRIMARY KEY,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. CACHE TABLE (Laravel Default)
-- =====================================================
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL PRIMARY KEY,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. CACHE LOCKS TABLE (Laravel Default)
-- =====================================================
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL PRIMARY KEY,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. JOBS TABLE (Laravel Default)
-- =====================================================
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 10. JOB BATCHES TABLE (Laravel Default)
-- =====================================================
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL PRIMARY KEY,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 11. FAILED JOBS TABLE (Laravel Default)
-- =====================================================
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 12. MIGRATIONS TABLE (Laravel Default)
-- =====================================================
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SAMPLE DATA - USERS (4 Users: 1 Admin, 1 Petugas, 2 Users)
-- =====================================================
INSERT INTO `users` (`name`, `email`, `password`, `phone`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin@peminjamanbuku.com', '$2y$12$X9p5F4L8G3Z5Q2W9E6R1uO0V3N5M9S6T4L7E8R9I5P0K8J5H6Y3', '081234567890', 'Jalan Amsterdam No. 123, Jakarta', 'admin', 'active', NOW(), NOW()),
('Petugas Perpustakaan', 'petugas@peminjamanbuku.com', '$2y$12$X9p5F4L8G3Z5Q2W9E6R1uO0V3N5M9S6T4L7E8R9I5P0K8J5H6Y3', '081234567895', 'Jalan Perpustakaan No. 200, Jakarta', 'petugas', 'active', NOW(), NOW()),
('John Doe', 'john@example.com', '$2y$12$X9p5F4L8G3Z5Q2W9E6R1uO0V3N5M9S6T4L7E8R9I5P0K8J5H6Y3', '081234567891', 'Jalan Sudirman No. 456, Jakarta', 'user', 'active', NOW(), NOW()),
('Jane Smith', 'jane@example.com', '$2y$12$X9p5F4L8G3Z5Q2W9E6R1uO0V3N5M9S6T4L7E8R9I5P0K8J5H6Y3', '081234567892', 'Jalan Gatot Subroto No. 789, Jakarta', 'user', 'active', NOW(), NOW());

-- Password untuk semua user: password123

-- =====================================================
-- SAMPLE DATA - CATEGORIES (Kategori Buku)
-- =====================================================
INSERT INTO `categories` (`name`, `description`, `created_at`, `updated_at`) VALUES
('Novel', 'Buku cerita fiksi dan novel terkemuka', NOW(), NOW()),
('Pendidikan', 'Buku-buku mengenai pendidikan dan pembelajaran', NOW(), NOW()),
('Teknologi', 'Buku tentang teknologi, IT, dan programming', NOW(), NOW()),
('Biografi', 'Cerita hidup tokoh-tokoh terkenal', NOW(), NOW()),
('Self-Help', 'Buku pengembangan diri dan motivasi', NOW(), NOW()),
('Sejarah', 'Buku tentang sejarah dunia dan nasional', NOW(), NOW());

-- =====================================================
-- SAMPLE DATA - BOOKS (7 Buku Sample)
-- =====================================================
INSERT INTO `books` (`title`, `author`, `isbn`, `description`, `category_id`, `publisher`, `year`, `quantity`, `available_quantity`, `created_at`, `updated_at`) VALUES
('Laskar Pelangi', 'Andrea Hirata', '978-979-1047-10-8', 'Novel tentang perjuangan anak-anak di Belitung', 1, 'Bentang', 2005, 5, 5, NOW(), NOW()),
('Filosofi Teras', 'Henry Manampiring', '978-623-206-106-2', 'Buku tentang filsafat stoikisme untuk kehidupan modern', 5, 'Gramedia', 2018, 3, 3, NOW(), NOW()),
('Atomic Habits', 'James Clear', '978-0735211292', 'Buku tentang bagaimana membangun kebiasaan baik', 5, 'Avery', 2018, 4, 4, NOW(), NOW()),
('Clean Code', 'Robert C. Martin', '978-0132350884', 'Panduan lengkap untuk menulis kode yang bersih', 3, 'Prentice Hall', 2008, 2, 2, NOW(), NOW()),
('Sejarah Indonesia', 'Sartono Kartodirjo', '978-979-709-002-9', 'Komprehensif mengenai sejarah bangsa Indonesia', 6, 'Yogyakarta University Press', 1992, 3, 3, NOW(), NOW()),
('Abad Pencerahan', 'Peter Gay', '978-0393347364', 'Sejarah budaya Eropa abad 18', 6, 'W.W. Norton', 1996, 2, 2, NOW(), NOW()),
('The Pragmatic Programmer', 'Andrew Hunt & David Thomas', '978-0201616224', 'Buku panduan praktis untuk programmer profesional', 3, 'Addison-Wesley', 1999, 3, 3, NOW(), NOW());

-- =====================================================
-- SAMPLE DATA - LOANS (Contoh Transaksi Peminjaman)
-- =====================================================
INSERT INTO `loans` (`user_id`, `book_id`, `loan_date`, `due_date`, `return_date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(3, 1, DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY), NULL, 'active', 'Dalam proses peminjaman', NOW(), NOW()),
(3, 2, DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY), NULL, 'active', 'Peminjaman baru', NOW(), NOW()),
(4, 3, DATE_SUB(NOW(), INTERVAL 20 DAY), DATE_SUB(NOW(), INTERVAL 13 DAY), NOW(), 'returned', 'Sudah dikembalikan', NOW(), NOW()),
(4, 4, DATE_SUB(NOW(), INTERVAL 15 DAY), DATE_SUB(NOW(), INTERVAL 8 DAY), NOW(), 'returned', 'Sudah dikembalikan tepat waktu', NOW(), NOW());

-- =====================================================
-- MIGRATION TRACKING (Untuk Laravel Migration System)
-- =====================================================
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2024_01_01_000003_create_categories_table', 2),
('2024_01_01_000004_create_books_table', 2),
('2024_01_01_000005_create_loans_table', 2),
('2024_01_01_000006_update_users_table', 3);

-- =====================================================
-- SUMMARY DATABASE SCHEMA
-- =====================================================
-- Total Tables: 12
-- - Core Application: users (5), categories (1), books (1), loans (1)
-- - Laravel System: password_reset_tokens, sessions, cache, cache_locks, jobs, job_batches, failed_jobs, migrations
--
-- ENUM Values:
-- - users.role: 'user', 'member', 'petugas', 'admin'
-- - users.status: 'active', 'inactive'
-- - loans.status: 'active', 'returned', 'overdue'
--
-- Sample Data:
-- - Users: 4 (1 admin, 1 petugas, 2 users)
-- - Categories: 6
-- - Books: 7
-- - Loans: 4
--
-- =====================================================
