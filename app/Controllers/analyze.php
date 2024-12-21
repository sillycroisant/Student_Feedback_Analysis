<?php

// Kết nối đến cơ sở dữ liệu
include "../Models/connect_mysqli.php";

session_start(); // Bắt đầu session để sử dụng $_SESSION
$full_name = $_SESSION['full_name'];

$sql = "
SELECT 
    ten_giang_vien,
    ten_hoc_phan,
    COUNT(DISTINCT nguoi_danh_gia) AS so_nguoi_danh_gia,
    SUM(cau_hoi_1) AS tong_cau_hoi_1,
    SUM(cau_hoi_2) AS tong_cau_hoi_2,
    SUM(cau_hoi_3) AS tong_cau_hoi_3,
    SUM(cau_hoi_4) AS tong_cau_hoi_4,
    SUM(cau_hoi_5) AS tong_cau_hoi_5,
    SUM(cau_hoi_6) AS tong_cau_hoi_6,
    SUM(cau_hoi_7) AS tong_cau_hoi_7,
    SUM(cau_hoi_8) AS tong_cau_hoi_8,
    SUM(cau_hoi_9) AS tong_cau_hoi_9,
    SUM(cau_hoi_10) AS tong_cau_hoi_10,
    (SUM(cau_hoi_1) + SUM(cau_hoi_2) + SUM(cau_hoi_3) + SUM(cau_hoi_4) + SUM(cau_hoi_5)) AS tong_5_cau_hoi,
    (SUM(cau_hoi_1) + SUM(cau_hoi_2) + SUM(cau_hoi_3) + SUM(cau_hoi_4) + SUM(cau_hoi_5) + SUM(cau_hoi_6) + SUM(cau_hoi_7) + SUM(cau_hoi_8) + SUM(cau_hoi_9) + SUM(cau_hoi_10)) AS tong_10_cau_hoi
FROM result
WHERE ten_giang_vien = ?
GROUP BY ten_giang_vien, ten_hoc_phan
";

// $result_general = $conn->query($sql);

// Chuẩn bị và thực thi câu truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $full_name);
$stmt->execute();
$result_general = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết Quả Tổng Hợp</title>
    <style>
        .table-ketqua {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        .table-ketqua th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table-ketqua th {
            background-color: #2865FF;
            text-align: center;
            color: white;
        }
        .table-ketqua .nhanxet {
            text-align: left;
        }

    </style>
</head>
<body>
    <h1>Kết Quả Với Các Câu Hỏi Về Môn Học</h1>
    <table class="table-ketqua">
        <tr>
            <!-- <th>Tên Giảng Viên</th> -->
            <th>Tên Học Phần</th>
            <th>Số người đánh giá</th>
            <th>Nội dung</th>
            <th>Khối lượng</th>
            <th>Độ hữu ích</th>
            <th>Tài liệu</th>
            <th>Tạo động lực</th>
            <!-- <th>Tổng điểm các câu hỏi về môn học</th>  -->
            <th>Nhận xét về môn học</th>
        </tr>
        <?php
        if ($result_general->num_rows > 0) {
            while ($row = $result_general->fetch_assoc()) {
                $so_nguoi_danh_gia = $row['so_nguoi_danh_gia'];
                $diem_toi_da_cau_hoi = $so_nguoi_danh_gia * 5;
                $diem_toi_da_10_cau_hoi = $so_nguoi_danh_gia * 25;
                $tong_cau_hoi_1 = $row['tong_cau_hoi_1'];
                $tong_cau_hoi_2 = $row['tong_cau_hoi_2'];
                $tong_cau_hoi_3 = $row['tong_cau_hoi_3'];
                $tong_cau_hoi_4 = $row['tong_cau_hoi_4'];
                $tong_cau_hoi_5 = $row['tong_cau_hoi_5'];
                $tong_5_cau_hoi = $row['tong_5_cau_hoi'];

                // Xác định nhận xét ( >=80% tổng điểm là đánh giá tốt, >=50% tổng điểm là đánh giá bình thường, còn lại là đánh giá không tốt )
                if ($tong_cau_hoi_1 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_1 = "Nội dung môn học trình bày rất logic, rõ ràng. <br>";
                } elseif ($tong_cau_hoi_1 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_1 = "Nội dung môn học khá rõ ràng, logic. <br>";
                } else {
                    $nhan_xet_1 = "Nội dung trình bày chưa rõ ràng, logic. <br>";
                }

                if ($tong_cau_hoi_2 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_2 = "Khối lượng bài giảng phù hợp. <br>";
                } elseif ($tong_cau_hoi_2 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_2 = "Khối lượng bài giảng khá phù hợp. <br>";
                } else {
                    $nhan_xet_2 = "Khối lượng bài giảng chưa phù hợp. <br>";
                }

                if ($tong_cau_hoi_3 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_3 = "Môn học giúp nâng cao nhiều kiến thức, kỹ năng thực tế. <br>";
                } elseif ($tong_cau_hoi_3 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_3 = "Môn học nâng cao kiến thức, kỹ năng thực tế nhưng chưa nhiều. <br>";
                } else {
                    $nhan_xet_3 = "Môn học không giúp nâng cao kiến thức, kỹ năng thực tế. <br>";
                }

                if ($tong_cau_hoi_4 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_4 = "Giáo trình, bài giảng đáp ứng nhu cầu học tập của sinh viên. <br>";
                } elseif ($tong_cau_hoi_4 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_4 = "Giáo trình, bài giảng đáp ứng một phần nhu cầu học tập của sinh viên. <br>";
                } else {
                    $nhan_xet_4 = "Giáo trình, bài giảng chưa đáp ứng nhu cầu học tập của sinh viên. <br>";
                }

                if ($tong_cau_hoi_5 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_5 = "Môn học tạo nhiều động lực học tập, nghiên cứu thêm cho sinh viên. <br>";
                } elseif ($tong_cau_hoi_5 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_5 = "Môn học tạo động lực học tập, nghiên cứu thêm cho sinh viên nhưng không nhiều. <br>";
                } else {
                    $nhan_xet_5 = "Môn học chưa tạo động lực học tập, nghiên cứu thêm cho sinh viên. <br>";
                }

                if ($tong_5_cau_hoi >= ($diem_toi_da_10_cau_hoi * 0.8)) {
                    $nhan_xet_5cau = "=> Môn học rất hay, phù hợp với sinh viên. <br>";
                } elseif ($tong_5_cau_hoi >= ($diem_toi_da_10_cau_hoi * 0.5)) { 
                    $nhan_xet_5cau = "=> Môn học khá hay nhưng cần tiếp tục cải thiện, phát triển để phù hợp với sinh viên. <br>";
                } else {
                    $nhan_xet_5cau = "=> Môn học chưa hay và phù hợp với sinh viên. <br>";
                }

                echo "<tr>";
                // echo "<td>{$row['ten_giang_vien']}</td>";
                echo "<td>{$row['ten_hoc_phan']}</td>";
                echo "<td>{$so_nguoi_danh_gia}</td>";
                echo "<td>{$tong_cau_hoi_1}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td>{$tong_cau_hoi_2}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td>{$tong_cau_hoi_3}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td>{$tong_cau_hoi_4}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td>{$tong_cau_hoi_5}/{$diem_toi_da_cau_hoi}</td>";
                // echo "<td>{$tong_5_cau_hoi}/{$diem_toi_da_10_cau_hoi}</td>";
                echo "<td class='nhanxet'>{$nhan_xet_1} {$nhan_xet_2} {$nhan_xet_3} {$nhan_xet_4} {$nhan_xet_5} {$nhan_xet_5cau}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Không có dữ liệu</td></tr>";
        }

        // Sau khi hoàn thành vòng lặp cho bảng đầu tiên, sử dụng mysqli_data_seek() để quay lại đầu kết quả
        mysqli_data_seek($result_general, 0);   
        
        ?>
    </table>

    <h1>Kết Quả Với Các Câu Hỏi Về Giảng Viên Và Nhận Xét Chung</h1>
    <table class="table-ketqua">
        <tr>
            <!-- <th>Tên Giảng Viên</th> -->
            <th>Tên Học Phần</th>
            <th>Số người đánh giá</th>
            <th>Trình bày</th>
            <th>Phương pháp</th>
            <th>Giải đáp thắc mắc</th>
            <th>Tác phong</th>
            <th>Độ hài lòng</th>
            <th>Nhận xét về giảng viên</th>
            <th>Tổng điểm chung</th> 
            <th>Nhận xét chung</th>
        </tr>
        <?php
        if ($result_general->num_rows > 0) {
            while ($row = $result_general->fetch_assoc()) {
                $so_nguoi_danh_gia = $row['so_nguoi_danh_gia'];
                $diem_toi_da_cau_hoi = $so_nguoi_danh_gia * 5;
                $diem_toi_da_10_cau_hoi = $so_nguoi_danh_gia * 50;
                $tong_cau_hoi_6 = $row['tong_cau_hoi_6'];
                $tong_cau_hoi_7 = $row['tong_cau_hoi_7'];
                $tong_cau_hoi_8 = $row['tong_cau_hoi_8'];
                $tong_cau_hoi_9 = $row['tong_cau_hoi_9'];
                $tong_cau_hoi_10 = $row['tong_cau_hoi_10'];
                $tong_10_cau_hoi = $row['tong_10_cau_hoi'];
                $phantram = ($tong_10_cau_hoi / $diem_toi_da_10_cau_hoi) * 100;

                // Xác định nhận xét ( >=80% tổng điểm là đánh giá tốt, >=50% tổng điểm là đánh giá bình thường, còn lại là đánh giá không tốt )
                if ($tong_cau_hoi_6 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_6 = "Giảng viên trình bày bài giảng rất dễ hiểu, mạch lạc. <br>";
                } elseif ($tong_cau_hoi_6 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_6 = "Giảng viên trình bày bài giảng khá dễ hiểu, mạch lạc. <br>";
                } else {
                    $nhan_xet_6 = "Giảng viên trình bày bài giảng khó hiểu, chưa mạch lạc. <br>";
                }

                if ($tong_cau_hoi_7 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_7 = "Giảng viên sử dụng phương pháp giảng dạy rất sáng tạo, hấp dẫn. <br>";
                } elseif ($tong_cau_hoi_7 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_7 = "Giảng viên sử dụng phương pháp giảng dạy ít sáng tạo, hấp dẫn. <br>";
                } else {
                    $nhan_xet_7 = "Giảng viên sử dụng phương pháp giảng dạy chưa sáng tạo, hấp dẫn. <br>";
                }

                if ($tong_cau_hoi_8 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_8 = "Giảng viên hỗ trợ, giải đáp thắc mắc của sinh viên hiệu quả, nhiệt tình. <br>";
                } elseif ($tong_cau_hoi_8 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_8 = "Giảng viên hỗ trợ, giải đáp thắc mắc của sinh viên ít hiệu quả. <br>";
                } else {
                    $nhan_xet_8 = "Giảng viên chưa hỗ trợ, giải đáp thắc mắc của sinh viên. <br>";
                }

                if ($tong_cau_hoi_9 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_9 = "Giảng viên rất chuyên nghiệp, thân thiện. <br>";
                } elseif ($tong_cau_hoi_9 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_9 = "Giảng viên khá chuyên nghiệp, thân thiện. <br>";
                } else {
                    $nhan_xet_9 = "Giảng viên chưa chuyên nghiệp, thân thiện. <br>";
                }

                if ($tong_cau_hoi_10 >= ($diem_toi_da_cau_hoi * 0.8)) {
                    $nhan_xet_10 = "=> Sinh viên rất hài lòng về giảng viên. Cần tiếp tục phát huy. <br>";
                } elseif ($tong_cau_hoi_10 >= ($diem_toi_da_cau_hoi * 0.5)) { 
                    $nhan_xet_10 = "=> Sinh viên khá hài lòng về giảng viên tuy nhiên vẫn còn một số điểm cần cải thiện, phát triển. <br>";
                } else {
                    $nhan_xet_10 = "=> Sinh viên chưa hài lòng về giảng viên. Cần xem lại nhận xét để cải thiện. <br>";
                }

                if ($tong_10_cau_hoi >= ($diem_toi_da_10_cau_hoi * 0.8)) {
                    $nhan_xet_10cau = $row['ten_giang_vien'] . " dạy học phần " . $row['ten_hoc_phan'] . " rất tốt. Cần tiếp tục phát huy cho những lần sau. <br>";
                } elseif ($tong_10_cau_hoi >= ($diem_toi_da_10_cau_hoi * 0.5)) { 
                    $nhan_xet_10cau = $row['ten_giang_vien'] . " dạy học phần " . $row['ten_hoc_phan'] . " khá tốt nhưng còn một số điểm cần lưu ý. Cần tiếp tục cải thiện cho những lần sau. <br>";
                } else {
                    $nhan_xet_10cau = $row['ten_giang_vien'] . " dạy học phần " . $row['ten_hoc_phan'] . " chưa tốt. Cần xem kỹ nhận xét để cải thiện cho những lần sau.  <br>";
                }

                echo "<tr>";
                // echo "<td>{$row['ten_giang_vien']}</td>";
                echo "<td>{$row['ten_hoc_phan']}</td>";
                echo "<td>{$so_nguoi_danh_gia}</td>";
                echo "<td>{$tong_cau_hoi_6}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td>{$tong_cau_hoi_7}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td>{$tong_cau_hoi_8}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td>{$tong_cau_hoi_9}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td>{$tong_cau_hoi_10}/{$diem_toi_da_cau_hoi}</td>";
                echo "<td class='nhanxet'>{$nhan_xet_6} {$nhan_xet_7} {$nhan_xet_8} {$nhan_xet_9} {$nhan_xet_10}</td>";
                echo "<td>{$tong_10_cau_hoi}/{$diem_toi_da_10_cau_hoi} <br> ({$phantram}%)</td>";
                echo "<td class='nhanxet'>{$nhan_xet_10cau}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Không có dữ liệu</td></tr>";
        }
        ?>
    </table>
    
</body>
</html>
