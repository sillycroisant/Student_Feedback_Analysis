<?php
// Cấu hình kết nối
$servername = "localhost";  // Địa chỉ máy chủ MySQL
$username = "root";         // Tên người dùng MySQL
$password = "";             // Mật khẩu MySQL (để trống nếu không có mật khẩu)
$dbname = "student_feedback_analysis";   // Tên database bạn đã tạo

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} 
// else {
//     echo "Kết nối thành công!";
// }

?>
