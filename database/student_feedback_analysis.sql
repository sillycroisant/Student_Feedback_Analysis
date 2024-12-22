-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 12:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_feedback_analysis`
--

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `idtoconnect` int(11) NOT NULL,
  `q1` varchar(255) NOT NULL,
  `q2` varchar(255) NOT NULL,
  `q3` varchar(255) NOT NULL,
  `q4` varchar(255) NOT NULL,
  `q5` varchar(255) NOT NULL,
  `q6` varchar(255) NOT NULL,
  `q7` varchar(255) NOT NULL,
  `q8` varchar(255) NOT NULL,
  `q9` varchar(255) NOT NULL,
  `q10` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`idtoconnect`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `created_at`) VALUES
(1, 'Nội dung môn học có rõ ràng và được trình bày một cách logic không?', 'Khối lượng bài giảng có phù hợp với thời lượng của môn học không?', 'Mức độ hữu ích của môn học đối với kiến thức và kỹ năng thực tế của bạn như thế nào?', 'Tài liệu học tập (giáo trình, tài liệu tham khảo, bài giảng) có đáp ứng nhu cầu học tập của bạn không?', 'Môn học có tạo động lực học tập và nghiên cứu thêm không?', 'Giảng viên có trình bày bài giảng một cách dễ hiểu và mạch lạc không?', 'Giảng viên có sử dụng các phương pháp giảng dạy sáng tạo và hấp dẫn không?', 'Giảng viên có hỗ trợ và giải đáp thắc mắc của sinh viên hiệu quả không?', 'Thái độ và tác phong giảng dạy của giảng viên có chuyên nghiệp và thân thiện không?', 'Mức độ hài lòng tổng thể của bạn đối với giảng viên của môn học này là bao nhiêu?', '2024-12-19 12:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` int(11) NOT NULL,
  `ten_giang_vien` varchar(255) NOT NULL,
  `ten_hoc_phan` varchar(255) NOT NULL,
  `nguoi_danh_gia` varchar(255) NOT NULL,
  `cau_hoi_1` int(11) NOT NULL CHECK (`cau_hoi_1` between 1 and 5),
  `cau_hoi_2` int(11) NOT NULL CHECK (`cau_hoi_2` between 1 and 5),
  `cau_hoi_3` int(11) NOT NULL CHECK (`cau_hoi_3` between 1 and 5),
  `cau_hoi_4` int(11) NOT NULL CHECK (`cau_hoi_4` between 1 and 5),
  `cau_hoi_5` int(11) NOT NULL CHECK (`cau_hoi_5` between 1 and 5),
  `cau_hoi_6` int(11) NOT NULL CHECK (`cau_hoi_6` between 1 and 5),
  `cau_hoi_7` int(11) NOT NULL CHECK (`cau_hoi_7` between 1 and 5),
  `cau_hoi_8` int(11) NOT NULL CHECK (`cau_hoi_8` between 1 and 5),
  `cau_hoi_9` int(11) NOT NULL CHECK (`cau_hoi_9` between 1 and 5),
  `cau_hoi_10` int(11) NOT NULL CHECK (`cau_hoi_10` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `full_name`, `username`, `password`, `created_at`) VALUES
(1, 'Trần Đức Phát', 'tranducphat', 'tranducphat', '2024-12-19 03:13:49'),
(2, 'Lê Quang Hoàng', 'lequanghoang', 'lequanghoang', '2024-12-19 03:16:26'),
(3, 'Nguyễn Văn Huy', 'nguyenvanhuy', 'nguyenvanhuy', '2024-12-19 03:16:26');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `subject` set('Giải tích','Vật Lí','Anh Văn') DEFAULT 'Giải tích',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `full_name`, `subject`, `username`, `password`, `created_at`) VALUES
(1, 'Giảng Viên 1', 'Giải tích', 'giangvien1', 'giangvien1', '2024-12-19 02:41:56'),
(2, 'Giảng Viên 2', 'Giải tích,Vật Lí', 'giangvien2', 'giangvien2', '2024-12-19 02:44:11'),
(3, 'Giảng Viên 3', 'Giải tích,Vật Lí,Anh Văn', 'giangvien3', 'giangvien3', '2024-12-19 03:08:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`idtoconnect`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
