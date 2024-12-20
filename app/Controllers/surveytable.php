<?php
// Kết nối cơ sở dữ liệu
include '../Models/connect_pdo.php';

$idtoconnect = 1; // ID của nhóm câu hỏi cần lấy
$query = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10 
          FROM question WHERE idtoconnect = :idtoconnect";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':idtoconnect', $idtoconnect, PDO::PARAM_INT);
$stmt->execute();
$questions = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$questions) {
    die("Không tìm thấy câu hỏi.");
}

// Biến để kiểm tra form đã được gửi
$formSubmitted = false;

// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy giá trị từ form
    $ten_giang_vien = $_POST['ten_giang_vien']; // Bạn cần thêm trường này trong form để lấy tên giảng viên
    $ten_hoc_phan = $_POST['ten_hoc_phan']; // Tương tự, thêm trường cho tên học phần
    $nguoi_danh_gia = $_POST['nguoi_danh_gia']; // Trường cho tên người đánh giá

    // Lấy các câu trả lời từ form
    $cau_hoi_1 = $_POST['q1'];
    $cau_hoi_2 = $_POST['q2'];
    $cau_hoi_3 = $_POST['q3'];
    $cau_hoi_4 = $_POST['q4'];
    $cau_hoi_5 = $_POST['q5'];
    $cau_hoi_6 = $_POST['q6'];
    $cau_hoi_7 = $_POST['q7'];
    $cau_hoi_8 = $_POST['q8'];
    $cau_hoi_9 = $_POST['q9'];
    $cau_hoi_10 = $_POST['q10'];

    // Câu lệnh SQL để chèn kết quả vào bảng 'result'
    $query = "INSERT INTO result (ten_giang_vien, ten_hoc_phan, nguoi_danh_gia, cau_hoi_1, cau_hoi_2, cau_hoi_3, cau_hoi_4, cau_hoi_5, cau_hoi_6, cau_hoi_7, cau_hoi_8, cau_hoi_9, cau_hoi_10) 
              VALUES (:ten_giang_vien, :ten_hoc_phan, :nguoi_danh_gia, :cau_hoi_1, :cau_hoi_2, :cau_hoi_3, :cau_hoi_4, :cau_hoi_5, :cau_hoi_6, :cau_hoi_7, :cau_hoi_8, :cau_hoi_9, :cau_hoi_10)";

    // Chuẩn bị câu lệnh
    $stmt = $pdo->prepare($query);

    // Liên kết các tham số
    $stmt->bindParam(':ten_giang_vien', $ten_giang_vien, PDO::PARAM_STR);
    $stmt->bindParam(':ten_hoc_phan', $ten_hoc_phan, PDO::PARAM_STR);
    $stmt->bindParam(':nguoi_danh_gia', $nguoi_danh_gia, PDO::PARAM_STR);
    $stmt->bindParam(':cau_hoi_1', $cau_hoi_1, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_2', $cau_hoi_2, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_3', $cau_hoi_3, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_4', $cau_hoi_4, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_5', $cau_hoi_5, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_6', $cau_hoi_6, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_7', $cau_hoi_7, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_8', $cau_hoi_8, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_9', $cau_hoi_9, PDO::PARAM_INT);
    $stmt->bindParam(':cau_hoi_10', $cau_hoi_10, PDO::PARAM_INT);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $success_message = "Đánh giá của bạn đã được gửi thành công!";
        $formSubmitted = true;
    } else {
        $error_message = "Có lỗi xảy ra trong quá trình gửi đánh giá.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh giá học phần</title>
    <link rel="icon" href="../../public/images/Logo.png" type="image/png">
    <link rel="stylesheet" href="../../app/Views/css/surveytable.css">
</head>
<body>
    <div class="header">
        <img alt="Logo" height="50" src="../../public/images/Logo.png" width="50" />
        <h1> HỆ THỐNG PHÂN TÍCH PHẢN HỒI NGƯỜI HỌC </h1>
    </div>
    <div class="navigation">
        <ul class="nav">
            <li><a href="../../app/Views/html/studentHomePage.html">Trang chủ</a></li>
            <li><a href="#" onclick="showSection('calendar')">Khảo sát</a></li> 
            <li><a href="../../index.html" >Đăng xuất</a></li>
        </ul>
    </div>
     <!-- //Hiển thị thông báo lỗi nếu có -->
     <?php if (!empty($error_message)): ?>
            <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <!-- //Hiển thị thông báo lỗi nếu có -->
            <?php if (!empty($success_message)): ?>
            <p style="color: green; text-align: center;"><?php echo $success_message; ?></p>
            <?php endif; ?>

    <div class="container">
          <h2>
          <i class="fas fa-clipboard-list">
          </i>
           Đánh giá lớp học phần
           </h2>
        <form action="surveytable.php" method="POST">
            <!-- Thêm các trường nhập liệu cho tên giảng viên, tên học phần, người đánh giá -->
            <label for="ten_giang_vien">Tên Giảng Viên:</label>
            <input type="text" id="ten_giang_vien" name="ten_giang_vien" required>

            <label for="ten_hoc_phan">Tên Học Phần:</label>
            <input type="text" id="ten_hoc_phan" name="ten_hoc_phan" required>

            <label for="nguoi_danh_gia">Người Đánh Giá:</label>
            <input type="text" id="nguoi_danh_gia" name="nguoi_danh_gia" required>

            <?php 
            $index = 1;
            foreach ($questions as $key => $question) { 
            ?>
                <div class="question">
                    <p><strong>Câu hỏi <?php echo $index++; ?>:</strong> <?php echo htmlspecialchars($question); ?></p>
                    <div class="options">
                    <p><label><input type="radio" name="<?php echo $key; ?>" value="5"> Rất đồng ý</label><br>
                        <label><input type="radio" name="<?php echo $key; ?>" value="4"> Đồng ý</label> <br> 
                        <label><input type="radio" name="<?php echo $key; ?>" value="2"> Đồng ý một phần</label><br>
                        <label><input type="radio" name="<?php echo $key; ?>" value="3"> Không đồng ý</label><br>
                        <label><input type="radio" name="<?php echo $key; ?>" value="1" required> Rất không đồng ý</label><br>
                    <p>
                    </div>
                </div>
            <?php } ?>
           
            <div class="submit-section">
            <?php if (!$formSubmitted) { ?>
                <button type="submit">Gửi đánh giá</button>
            <?php } ?>
            </div>
        </form>
    </div>
</body>
</html>
