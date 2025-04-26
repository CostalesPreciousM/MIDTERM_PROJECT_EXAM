
-- Create the database 
CREATE DATABASE IF NOT EXISTS `school_management_system`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE=utf8mb4_general_ci;

-- Use the created database
USE `school_management_system`;

-- --------------------------------------------------------
-- Table structure for table `students`
-- --------------------------------------------------------
CREATE TABLE `students` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `student_number` varchar(20) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `subjects`
-- --------------------------------------------------------
CREATE TABLE `subjects` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(20) NOT NULL UNIQUE,
  `subject_name` varchar(100) NOT NULL,
  `units` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `sections`
-- --------------------------------------------------------
CREATE TABLE `sections` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `section_name` varchar(50) NOT NULL,
  `subject_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `student_sections`
-- --------------------------------------------------------
CREATE TABLE `student_sections` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `student_id` int(10) NOT NULL,
  `section_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`section_id`) REFERENCES `sections`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_student_subject` (`student_id`, `section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `role` enum('admin', 'user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `grades`
-- --------------------------------------------------------
CREATE TABLE `grades` (
  `grade_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `grade` decimal(5,2) NOT NULL DEFAULT 0.00, -- Default grade set to 0
  `date_recorded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`grade_id`),
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Insert data into `students` (10 students)
-- --------------------------------------------------------
INSERT INTO `students` (`id`, `first_name`, `last_name`, `email`, `student_number`) VALUES
(1, 'Justine', 'Dolor', 'justine@student.com', 'STU001'),
(2, 'Reinald', 'Marinay', 'reinald@student.com', 'STU002'),
(3, 'Khurt', 'Lopez', 'khurt@student.com', 'STU003'),
(4, 'Liza', 'Garcia', 'liza@student.com', 'STU004'),
(5, 'Javier', 'Santos', 'javier@student.com', 'STU005'),
(6, 'Olivia', 'Perez', 'olivia@student.com', 'STU006'),
(7, 'Emma', 'Reyes', 'emma@student.com', 'STU007'),
(8, 'Daniel', 'Castro', 'daniel@student.com', 'STU008'),
(9, 'Sophia', 'Mendoza', 'sophia@student.com', 'STU009'),
(10, 'Lucas', 'Torres', 'lucas@student.com', 'STU010');

-- --------------------------------------------------------
-- Insert data into `subjects`
-- --------------------------------------------------------
INSERT INTO `subjects` (`id`, `subject_code`, `subject_name`, `units`) VALUES
(1, 'IT101', 'Introduction to IT', 3),
(2, 'CS201', 'Data Structures', 4),
(3, 'MATH102', 'Discrete Math', 3),
(4, 'ENG101', 'English Communication', 2),
(5, 'BIO102', 'Biology', 3);

-- --------------------------------------------------------
-- Insert data into `sections`
-- --------------------------------------------------------
INSERT INTO `sections` (`id`, `section_name`, `subject_id`) VALUES
(1, 'IT101-A', 1),
(2, 'CS201-B', 2),
(3, 'MATH102-C', 3),
(4, 'ENG101-D', 4),
(5, 'BIO102-E', 5);

-- --------------------------------------------------------
-- Insert data into `student_sections`
-- --------------------------------------------------------
INSERT INTO `student_sections` (`id`, `student_id`, `section_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 1),
(7, 7, 2),
(8, 8, 3),
(9, 9, 4),
(10, 10, 5);

-- --------------------------------------------------------
-- Insert data into `users`
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `username`, `role`) VALUES
(1, 'Khurt', 'Lopez', 'khurtlopez@gmail.com', 'khurtlopez', 'khurtlopez', 'admin'),
(2, 'Justine', 'Dolor', 'justine@gmail.com', 'password123', 'tined', 'user'),
(3, 'Reinald', 'Marinay', 'reinald@gmail.com', 'password456', 'renren', 'user'),
(4, 'Liza', 'Garcia', 'liza@gmail.com', 'password789', 'liza123', 'user'),
(5, 'Javier', 'Santos', 'javier@gmail.com', 'password101', 'javiers', 'user'),
(6, 'Sophia', 'Mendoza', 'sophia.mendoza@gmail.com', 'sophia123', 'sophia_m', 'user'),
(7, 'Daniel', 'Castro', 'daniel.castro@gmail.com', 'daniel123', 'daniel_c', 'user'),
(8, 'Lucas', 'Torres', 'lucas.torres@gmail.com', 'lucas123', 'lucas_t', 'user'),
(9, 'Emma', 'Reyes', 'emma.reyes@gmail.com', 'emma123', 'emma_r', 'user'),
(10, 'Olivia', 'Perez', 'olivia.perez@gmail.com', 'olivia123', 'olivia_p', 'user'),
(11, 'Javier', 'Santos', 'javier.santos@gmail.com', 'javier456', 'javiersantos', 'user'),
(12, 'Mia', 'Garcia', 'mia.garcia@gmail.com', 'mia123', 'mia_g', 'user'),
(13, 'Ethan', 'Lee', 'ethan.lee@gmail.com', 'ethan123', 'ethan_l', 'user'),
(14, 'Ava', 'Kim', 'ava.kim@gmail.com', 'ava123', 'ava_k', 'user'),
(15, 'William', 'Chang', 'william.chang@gmail.com', 'william123', 'william_c', 'user');
