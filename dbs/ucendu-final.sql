-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 26, 2017 lúc 10:22 AM
-- Phiên bản máy phục vụ: 10.1.28-MariaDB
-- Phiên bản PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ucendu-final`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_10_10_021717_create_reading_level_users_table', 1),
(2, '2017_10_10_021854_create_reading_password_resets_table', 1),
(3, '2017_10_10_023622_create_reading_type_lessons_table', 1),
(4, '2017_10_10_025453_create_reading_level_lessons_table', 1),
(5, '2017_10_10_025540_create_reading_type_questions_table', 1),
(6, '2017_10_10_032403_create_reading_learning_type_questions_table', 1),
(7, '2017_10_10_032633_create_reading_question_learnings_table', 1),
(8, '2017_10_10_032817_create_reading_practice_lessons_table', 1),
(9, '2017_10_10_034722_create_reading_mini_test_lessons_table', 1),
(10, '2017_10_10_035050_create_reading_mix_test_lessons_table', 1),
(11, '2017_10_10_035322_create_reading_full_test_lessons_table', 1),
(12, '2017_10_10_035557_create_reading_question_lessons_table', 1),
(13, '2017_10_10_040217_create_reading_type_question_detail_of_lessons_table', 1),
(14, '2017_10_10_040915_create_reading_question_and_answer_lessons_table', 1),
(15, '2017_10_10_041019_create_reading_result_lessons_table', 1),
(16, '2017_10_24_165222_create_reading_status_learning_of_users_table', 1),
(17, '2017_10_26_144538_create_users_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_full_test_lessons`
--

CREATE TABLE `reading_full_test_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_user_id` int(10) UNSIGNED NOT NULL,
  `content_lesson_first` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_highlight_first` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_lesson_second` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_highlight_second` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_lesson_third` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_highlight_third` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_feature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_quiz_first` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_answer_quiz_first` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_quiz_second` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_answer_quiz_second` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_quiz_third` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_answer_quiz_third` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_questions` int(11) NOT NULL,
  `limit_time` int(11) NOT NULL DEFAULT '60',
  `order_lesson` int(11) NOT NULL,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_learning_type_questions`
--

CREATE TABLE `reading_learning_type_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_question_id` int(10) UNSIGNED NOT NULL,
  `title_section` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `step_section` int(11) NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa-cog',
  `view_layout` tinyint(4) NOT NULL DEFAULT '1',
  `content_section` text COLLATE utf8mb4_unicode_ci,
  `left_content` text COLLATE utf8mb4_unicode_ci,
  `right_content` text COLLATE utf8mb4_unicode_ci,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_level_lessons`
--

CREATE TABLE `reading_level_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `introduction` text COLLATE utf8mb4_unicode_ci,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_level_users`
--

CREATE TABLE `reading_level_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reading_level_users`
--

INSERT INTO `reading_level_users` (`id`, `level`, `admin_responsibility`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 0, 1, '2017-10-26 08:10:57', '2017-10-26 08:10:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_mini_test_lessons`
--

CREATE TABLE `reading_mini_test_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_user_id` int(10) UNSIGNED NOT NULL,
  `type_question_id` int(11) DEFAULT NULL,
  `content_lesson` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_highlight` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_feature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_quiz` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_answer_quiz` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_questions` int(11) NOT NULL,
  `order_lesson` int(11) NOT NULL,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_mix_test_lessons`
--

CREATE TABLE `reading_mix_test_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_user_id` int(10) UNSIGNED NOT NULL,
  `content_lesson` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_highlight` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_feature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_quiz` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_answer_quiz` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_questions` int(11) NOT NULL,
  `limit_time` int(11) NOT NULL DEFAULT '20',
  `order_lesson` int(11) NOT NULL,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_password_resets`
--

CREATE TABLE `reading_password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_practice_lessons`
--

CREATE TABLE `reading_practice_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_user_id` int(10) UNSIGNED NOT NULL,
  `content_lesson` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_highlight` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_feature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_quiz` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_answer_quiz` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_questions` int(11) NOT NULL,
  `order_lesson` int(11) NOT NULL,
  `type_question_id` int(11) DEFAULT NULL,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_question_and_answer_lessons`
--

CREATE TABLE `reading_question_and_answer_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `reply_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `content_cmt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `private` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_question_learnings`
--

CREATE TABLE `reading_question_learnings` (
  `id` int(10) UNSIGNED NOT NULL,
  `learning_type_question_id` int(10) UNSIGNED NOT NULL,
  `type_question_id` int(10) UNSIGNED NOT NULL,
  `question_custom_id` int(10) UNSIGNED NOT NULL,
  `answer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_question_lessons`
--

CREATE TABLE `reading_question_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `lesson_id` int(10) UNSIGNED NOT NULL,
  `type_lesson_id` int(11) DEFAULT NULL,
  `type_question_id` int(10) UNSIGNED NOT NULL,
  `question_custom_id` int(10) UNSIGNED NOT NULL,
  `answer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_result_lessons`
--

CREATE TABLE `reading_result_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `lesson_id` int(10) UNSIGNED NOT NULL,
  `type_lesson_id` int(11) DEFAULT NULL,
  `correct_answer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `list_answered` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highest_correct` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_status_learning_of_users`
--

CREATE TABLE `reading_status_learning_of_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type_question_id` int(10) UNSIGNED NOT NULL,
  `type_lesson_id` int(10) UNSIGNED NOT NULL,
  `step_current` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_type_lessons`
--

CREATE TABLE `reading_type_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_lesson` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_type_questions`
--

CREATE TABLE `reading_type_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_lesson_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_type_question_detail_of_lessons`
--

CREATE TABLE `reading_type_question_detail_of_lessons` (
  `id` int(10) UNSIGNED NOT NULL,
  `lesson_id` int(10) UNSIGNED NOT NULL,
  `type_lesson_id` int(11) DEFAULT NULL,
  `type_question_id` int(10) UNSIGNED NOT NULL,
  `total_questions_of_type` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_user_id` tinyint(4) NOT NULL DEFAULT '0',
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(4) NOT NULL DEFAULT '0',
  `admin_responsibility` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `level_user_id`, `fullname`, `address`, `city`, `district`, `phone`, `dob`, `avatar`, `activated`, `admin_responsibility`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ucendu', 'ucendu@gmail.com', '$2y$10$jVqo2U0OIFwQfz2CUTMDQuJtKmeJNGF0wWbHXig5BpnZpcvXnWMt6', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'default.jpg', 1, 0, 1, 'kvuRLtw78Lk7impRTsMIu4kdV7Effr83Bi9EHIka', '2017-10-26 08:11:13', '2017-10-26 08:11:13');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_full_test_lessons`
--
ALTER TABLE `reading_full_test_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_learning_type_questions`
--
ALTER TABLE `reading_learning_type_questions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_level_lessons`
--
ALTER TABLE `reading_level_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reading_level_lessons_level_unique` (`level`);

--
-- Chỉ mục cho bảng `reading_level_users`
--
ALTER TABLE `reading_level_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reading_level_users_level_unique` (`level`);

--
-- Chỉ mục cho bảng `reading_mini_test_lessons`
--
ALTER TABLE `reading_mini_test_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_mix_test_lessons`
--
ALTER TABLE `reading_mix_test_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_password_resets`
--
ALTER TABLE `reading_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reading_password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `reading_practice_lessons`
--
ALTER TABLE `reading_practice_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_question_and_answer_lessons`
--
ALTER TABLE `reading_question_and_answer_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_question_learnings`
--
ALTER TABLE `reading_question_learnings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_question_lessons`
--
ALTER TABLE `reading_question_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_result_lessons`
--
ALTER TABLE `reading_result_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_status_learning_of_users`
--
ALTER TABLE `reading_status_learning_of_users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_type_lessons`
--
ALTER TABLE `reading_type_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reading_type_lessons_type_lesson_unique` (`type_lesson`);

--
-- Chỉ mục cho bảng `reading_type_questions`
--
ALTER TABLE `reading_type_questions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reading_type_question_detail_of_lessons`
--
ALTER TABLE `reading_type_question_detail_of_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `reading_full_test_lessons`
--
ALTER TABLE `reading_full_test_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_learning_type_questions`
--
ALTER TABLE `reading_learning_type_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_level_lessons`
--
ALTER TABLE `reading_level_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_level_users`
--
ALTER TABLE `reading_level_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `reading_mini_test_lessons`
--
ALTER TABLE `reading_mini_test_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_mix_test_lessons`
--
ALTER TABLE `reading_mix_test_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_password_resets`
--
ALTER TABLE `reading_password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_practice_lessons`
--
ALTER TABLE `reading_practice_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_question_and_answer_lessons`
--
ALTER TABLE `reading_question_and_answer_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_question_learnings`
--
ALTER TABLE `reading_question_learnings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_question_lessons`
--
ALTER TABLE `reading_question_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_result_lessons`
--
ALTER TABLE `reading_result_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_status_learning_of_users`
--
ALTER TABLE `reading_status_learning_of_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_type_lessons`
--
ALTER TABLE `reading_type_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_type_questions`
--
ALTER TABLE `reading_type_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reading_type_question_detail_of_lessons`
--
ALTER TABLE `reading_type_question_detail_of_lessons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
