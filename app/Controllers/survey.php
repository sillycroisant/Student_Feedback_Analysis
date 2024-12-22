<?php

// Kết nối đến cơ sở dữ liệu
include "../Models/connect_mysqli.php";

// session_start(); // Bắt đầu session để sử dụng $_SESSION
// $full_name = $_SESSION['full_name'];

$sql = "
SELECT 
    id,
    full_name,
    subject
FROM teacher
GROUP BY full_name, subject
";

$result_general = $conn->query($sql);

// // Chuẩn bị và thực thi câu truy vấn
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("s", $full_name);
// $stmt->execute();
// $result_general = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Bảng khảo sát</title> -->
    <style>
        .table-khaosat {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        .table-khaosat th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table-khaosat th {
            background-color: #2865FF;
            text-align: center;
            color: white;
        }
        .table-khaosat .nhanxet {
            text-align: left;
        }

    </style>
</head>
<body>
    <table class="table-khaosat">
        <tr>
            <th>Số thứ tự</th>
            <th>Tên giảng viên</th>
            <th>Tên học phần</th>
            <th>Khảo sát</th>
        </tr>
        <?php
        if ($result_general->num_rows > 0) {
            $counter = 1; // Biến đếm bắt đầu từ 1
            while ($row = $result_general->fetch_assoc()) {
                // Tách môn học thành mảng
                $subjects = explode(',', $row['subject']); // Giả sử các môn học được phân cách bằng dấu phẩy

                // Lặp qua từng môn học để hiển thị thành hàng riêng
                foreach ($subjects as $subject) {
                    $subject = trim($subject); // Loại bỏ khoảng trắng thừa
                    echo "<tr>";
                    echo "<td>{$counter}</td>"; // Hiển thị số thứ tự thay vì id từ cơ sở dữ liệu
                    echo "<td>{$row['full_name']}</td>";
                    echo "<td>{$subject}</td>";
                    echo 
                        '<td>
                            <a href="../../Controllers/surveytable.php?full_name=' . urlencode($row['full_name']) . '&subject=' . urlencode($subject) . '">
                            <span>✍</span>
                            </a>
                        </td>';
                    echo "</tr>";
                    $counter++; // Tăng biến đếm
                }
            }
        } else {
            echo "<tr><td colspan='4'>Không có dữ liệu</td></tr>";
        }

        // // Sau khi hoàn thành vòng lặp cho bảng đầu tiên, sử dụng mysqli_data_seek() để quay lại đầu kết quả
        // mysqli_data_seek($result_general, 0);   
        
        ?>
    </table>
    
</body>
</html>
