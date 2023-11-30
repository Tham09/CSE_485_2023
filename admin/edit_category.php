<?php
include '../Data/data.php';

try {
    $db = new DB();
    $db->connect();

    // Lấy mã thể loại từ tham số URL
    $ma_tloai = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$ma_tloai) {
        throw new Exception("Không có mã thể loại được chọn");
    }

    // Truy vấn dữ liệu thể loại cần sửa
    $table = "theloai";
    $columns = "*";
    $condition = "ma_tloai = $ma_tloai";
    $result = $db->selectData($table, $columns, $condition);

    // Kiểm tra nếu có dữ liệu
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ten_tloai = $row['ten_tloai'];
    } else {
        throw new Exception("Không tìm thấy dữ liệu thể loại");
    }

    // Xử lý khi người dùng nhấn nút "Lưu lại"
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Kiểm tra xem dữ liệu được submit từ form sửa hay không
        if (isset($_POST['txtCatName'])) {
            $ten_tloai_moi = $_POST['txtCatName'];

            // Thực hiện truy vấn cập nhật dữ liệu thể loại
            $data = array('ten_tloai' => $ten_tloai_moi);
            $condition = "ma_tloai = $ma_tloai";
            $db->updateData($table, $data, $condition);

            // Chuyển hướng về trang danh sách thể loại
            header("Location: category.php");
            exit;
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
                <h3 class="text-center text-uppercase fw-bold">Sửa thông tin thể loại</h3>
                <form action="edit_category.php?id=<?php echo $ma_tloai; ?>" method="post">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblCatId">Mã thể loại</span>
                        <input type="text" class="form-control" name="txtCatId" readonly value="<?php echo $ma_tloai; ?>">
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblCatName">Tên thể loại</span>
                        <input type="text" class="form-control" name="txtCatName" value="<?php echo $ten_tloai; ?>">
                    </div>

                    <div class="form-group  float-end ">
                        <input type="submit" value="Lưu lại" class="btn btn-success">
                        <a href="category.php" class="btn btn-warning ">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php include 'Components/admin_footer.php'?>
