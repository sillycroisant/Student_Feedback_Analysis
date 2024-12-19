<?php
include 'db_account.php'; 

session_start(); 

$error_message = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']); 
    $password = $_POST['password'];

    // 1. Kiểm tra trong cơ sở dữ liệu users
    $stmt_teacher = $pdo->prepare("SELECT * FROM teacher WHERE username = ?");
    $stmt_teacher->execute([$username]);
    $teacher = $stmt_teacher->fetch();

    // 2. Kiểm tra trong cơ sở dữ liệu admin
    $stmt_student = $pdo->prepare("SELECT * FROM student WHERE username = ?");
    $stmt_student->execute([$username]);
    $student = $stmt_student->fetch();

    // 3. Xác thực tài khoản
    if ($student && $password == $student['password']) {
        // Lưu thông tin người dùng
        $_SESSION['user_id'] = $student['id'];
        $_SESSION['username'] = $student['username'];

        // Chuyển hướng đến trang home cho user
        header("Location: ../app/Views/html/studentHomePage.html");
        exit; 
    } elseif ($teacher && $password == $teacher['password']) {
        // Lưu thông tin admin
        $_SESSION['user_id'] = $teacher['id'];
        $_SESSION['username'] = $teacher['username'];

        // Chuyển hướng đến trang 
        header("Location: ../app/Views/html/teacherHomePage.html");
        exit; 
    } else {
        // Sai thông tin đăng nhập
        $error_message = "Tên đăng nhập hoặc mật khẩu sai!";
    }
}

include('../app/Views/html/signin.html'); 
?>