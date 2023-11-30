 <?php
include '../Backend/DB.php';
d
try {
    $db = new DB();
    $db->connect();

    // Kiểm tra nếu có dữ liệu được gửi từ form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Kiểm tra xem trường tên thể loại có được điền hay không
        if (isset($_POST['txtCatName']) && !empty($_POST['txtCatName'])) {
            $ten_tloai = $_POST['txtCatName']; // Đổi tên biến thành $ten_tloai

            // Thực hiện truy vấn thêm dữ liệu thể loại
            $data = array('ten_tloai' => $ten_tloai);
            $table = "theloai";
            $db->insertData($table, $data);

            // Chuyển hướng về trang danh sách thể loại hoặc thực hiện hành động khác
            header("Location: category.php");
            exit;
        } else {
            throw new Exception("Tên thể loại không được để trống.");
        }
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
}

// Đóng kết nối sau khi hoàn thành mọi thao tác
if (isset($db)) {
    $db->close();
}

?>

<?php include 'Components/admin_header.php'?>
<main class="container mt-5 mb-5">
    <div class="row">
        <div class="col-sm">
            <h3 class="text-center text-uppercase fw-bold">Thêm mới thể loại</h3>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="input-group mt-3 mb-3">
                    <span class="input-group-text" id="lblCatName">Tên thể loại</span>
                    <input type="text" class="form-control" name="txtCatName" required>
                </div>

                <div class="form-group float-end">
                    <input type="submit" value="Thêm" class="btn btn-success">
                    <a href="category.php" class="btn btn-warning">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include 'Components/admin_footer.php'?>
