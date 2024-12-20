<?php
include 'connect_pdo.php'; 

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
        $_SESSION['full_name'] = $student['full_name'];

        // Chuyển hướng đến trang home cho user
        header("Location: ../Views/html/studentHomePage.html");
        exit; 
    } elseif ($teacher && $password == $teacher['password']) {
        // Lưu thông tin admin
        $_SESSION['user_id'] = $teacher['id'];
        $_SESSION['username'] = $teacher['username'];
        $_SESSION['full_name'] = $teacher['full_name'];

        // Chuyển hướng đến trang 
        header("Location: ../Views/html/teacherHomePage.html");
        exit; 
    } else {
        // Sai thông tin đăng nhập
        $error_message = "Tên đăng nhập hoặc mật khẩu sai!";
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['ajax']) && $_GET['ajax'] == 'true') {
    // Trả về dữ liệu người dùng qua AJAX
    if (isset($_SESSION['full_name'])) {
        echo json_encode([
            'status' => 'success',
            'full_name' => $_SESSION['full_name'],
            'username' => $_SESSION['username']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Người dùng chưa đăng nhập']);
    }
    exit;
}

include('../Views/html/signin.html'); 
?>