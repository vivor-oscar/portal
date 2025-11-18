-- Migration: create notifications and notification_recipients tables
-- Run this SQL once (e.g. via phpMyAdmin or mysql CLI)

CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `message` TEXT NOT NULL,
  `target_type` ENUM('all','student','staff','individual') NOT NULL DEFAULT 'all',
  `target_role` VARCHAR(50) NOT NULL DEFAULT 'all',
  `is_read` TINYINT(1) DEFAULT 0,
  `sender_id` VARCHAR(64) DEFAULT NULL,
  `sender_name` VARCHAR(191) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `notification_recipients` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `notification_id` INT UNSIGNED NOT NULL,
  `user_type` ENUM('student','staff') NOT NULL,
  `user_id` VARCHAR(64) NOT NULL,
  `delivered_at` TIMESTAMP NULL DEFAULT NULL,
  `read_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX (`notification_id`),
  CONSTRAINT `fk_nr_notifications` FOREIGN KEY (`notification_id`) REFERENCES `notifications`(`notification_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Note: This migration assumes you have `students` and `staff` tables with
-- `student_id` and `staff_id` columns respectively. Adjust column names
-- if your schema differs.
