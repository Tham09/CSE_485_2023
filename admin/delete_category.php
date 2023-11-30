<?php
include '../Data/data.php';

try {
    $db = new DB();
    $db->connect();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        // Lấy mã thể loại từ tham số URL
        $ma_tloai = $_GET['id'];

        // Thực hiện truy vấn xóa dữ liệu
        $table = "theloai";
        $condition = "ma_tloai = $ma_tloai";
        $db->deleteData($table, $condition);

        // Chuyển hướng về trang danh sách thể loại
        header("Location: category.php");
        exit;
    } else {
        // Nếu không có mã thể loại truyền vào, có thể xử lý theo ý muốn
        throw new Exception("Không có mã thể loại được chọn để xóa");
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
}

// Đóng kết nối sau khi hoàn thành mọi thao tác
if (isset($db)) {
    $db->close();
}
?>
