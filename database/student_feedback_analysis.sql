<?php
include 'db_account.php'; // Kết nối cơ sở dữ liệu

session_start();

// Truy vấn câu hỏi từ bảng `question`
$query = "SELECT * FROM question WHERE idtoconnect = 1"; // Giả sử chỉ sử dụng câu hỏi có `idtoconnect = 1`
$stmt = $pdo->prepare($query);
$stmt->execute();
$questionData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$questionData) {
    die("Không tìm thấy câu hỏi trong cơ sở dữ liệu.");
}

// Nếu form được gửi đi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assessor = htmlspecialchars($_POST['assessor']); // Người đánh giá
    $votetype = htmlspecialchars($_POST['votetype']); // Loại đánh giá tổng thể

    // Tạo câu truy vấn INSERT
    $insert_query = "INSERT INTO result (idtoconnect, teacher, subject, assessor, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, votetype) 
                     VALUES (:idtoconnect, :teacher, :subject, :assessor, :q1, :q2, :q3, :q4, :q5, :q6, :q7, :q8, :q9, :q10, :votetype)";
    $insert_stmt = $pdo->prepare($insert_query);

    // Gắn tham số
    $insert_stmt->bindParam(':idtoconnect', $questionData['idtoconnect']);
    $insert_stmt->bindParam(':teacher', $_POST['teacher']);
    $insert_stmt->bindParam(':subject', $_POST['subject']);
    $insert_stmt->bindParam(':assessor', $assessor);
    for ($i = 1; $i <= 10; $i++) {
        $insert_stmt->bindParam(":q$i", $_POST["q$i"]);
    }
    $insert_stmt->bindParam(':votetype', $votetype);

    // Thực thi truy vấn
    if ($insert_stmt->execute()) {
        echo "<script>alert('Đánh giá của bạn đã được lưu!'); window.location='thank_you.php';</script>";
        exit;
    } else {
        die("Lỗi khi lưu đánh giá: " . implode(", ", $insert_stmt->errorInfo()));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đánh Giá</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .question {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 10px;
            color: #555;
        }
        select, input {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            margin-top: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Đánh Giá Giảng Viên</h2>
        <form method="POST">
            <label for="teacher">Tên giảng viên</label>
            <input type="text" id="teacher" name="teacher" required>

            <label for="subject">Môn học</label>
            <input type="text" id="subject" name="subject" required>

            <label for="assessor">Người đánh giá</label>
            <input type="text" id="assessor" name="assessor" required>

            <?php for ($i = 1; $i <= 10; $i++) { ?>
                <div class="question">
                    <label for="q<?php echo $i; ?>">
                        <?php echo $questionData["q$i"]; ?>
                    </label>
                    <select name="q<?php echo $i; ?>" id="q<?php echo $i; ?>" required>
                        <option value="">Chọn đánh giá</option>
                        <option value="hoàn toàn không đồng ý">Hoàn toàn không đồng ý</option>
                        <option value="không đồng ý">Không đồng ý</option>
                        <option value="không ý kiến">Không ý kiến</option>
                        <option value="đồng ý">Đồng ý</option>
                        <option value="hoàn toàn đồng ý">Hoàn toàn đồng ý</option>
                    </select>
                </div>
            <?php } ?>

            <label for="votetype">Đánh giá tổng thể</label>
            <select name="votetype" id="votetype" required>
                <option value="">Chọn đánh giá</option>
                <option value="hoàn toàn không đồng ý">Hoàn toàn không đồng ý</option>
                <option value="không đồng ý">Không đồng ý</option>
                <option value="không ý kiến">Không ý kiến</option>
                <option value="đồng ý">Đồng ý</option>
                <option value="hoàn toàn đồng ý">Hoàn toàn đồng ý</option>
            </select>

            <button type="submit">Gửi Đánh Giá</button>
        </form>
    </div>
</body>
</html>
