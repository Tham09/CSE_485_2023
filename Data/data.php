<?php
class DB
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    // Hàm khởi tạo
    public function __construct()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "btth011";
    }

    // Phương thức để thiết lập kết nối
    public function connect()
    {
        if ($this->conn && $this->conn->ping()) {
            return;
        }

        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Kiểm tra kết nối
        if ($this->conn->connect_error) {
            throw new Exception("Kết nối không thành công: " . $this->conn->connect_error);
        }
    }

    // Phương thức để đóng kết nối
    public function close()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    // Phương thức để lấy đối tượng kết nối
    public function getConnection()
    {
        return $this->conn;
    }

    // Phương thức thực hiện truy vấn thêm dữ liệu
    public function insertData($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", $data) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        if (!$this->conn->query($sql)) {
            throw new Exception("Lỗi thêm dữ liệu: " . $this->conn->error);
        }
    }

    // Phương thức thực hiện truy vấn sửa dữ liệu
    public function updateData($table, $data, $condition)
    {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = '$value', ";
        }
        $setClause = rtrim($setClause, ", ");
        $sql = "UPDATE $table SET $setClause WHERE $condition";

        if (!$this->conn->query($sql)) {
            throw new Exception("Lỗi sửa dữ liệu: " . $this->conn->error);
        }
    }

    // Phương thức thực hiện truy vấn xóa dữ liệu
    public function deleteData($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";

        if (!$this->conn->query($sql)) {
            throw new Exception("Lỗi xóa dữ liệu: " . $this->conn->error);
        }
    }

    // Phương thức thực hiện truy vấn lấy dữ liệu
    public function selectData($table, $columns = "*", $condition = "")
    {
        $sql = "SELECT $columns FROM $table";
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        $result = $this->conn->query($sql);

        if (!$result) {
            throw new Exception("Lỗi truy vấn: " . $this->conn->error);
        }

        return $result;
    }
}

// Sử dụng class DB
$db = new DB();
try {
    $db->connect();
    // Thực hiện các thao tác với cơ sở dữ liệu ở đây
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
} finally {
    $db->close();
}
?>