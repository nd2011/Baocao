<?php
session_start();
include('trangdau.html');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Baocao";

require_once "mysql.php";

if (isset($_GET['id'])) {
    // Sử dụng phương thức GET để lấy id sách từ URL
    $book_id = $_GET['id'];

    // Lấy thông tin sách từ database
    $sql = "SELECT * FROM books WHERE id = $book_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $price = $row['price'];
    } else {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['user_id']) && isset($_POST['quantity'])) {
            // Sử dụng phương thức POST để lấy user_id và quantity từ form
            $user_id = $_POST['user_id'];
            $quantity = $_POST['quantity'];

            // Thêm vào bảng đơn hàng
            $sql = "INSERT INTO orders (book_id, user_id, price, quantity) VALUES ('$book_id', '$user_id', '$price', '$quantity')";
            $result = mysqli_query($conn, $sql);
            if ($result) { 
                echo "<p>Đã mua sách <strong>$title</strong> thành công!</p>";
            } else {
                echo "Lỗi truy vấn: " . mysqli_error($conn);
            }
        } else {
            echo "Lỗi: Dữ liệu đầu vào không đầy đủ.";
        }
    }

} else {
    header('Location: sach.php');
    exit();
}
echo "<p>Đã mua sách <strong>$title</strong> thành công!</p>";
include('trangcuoi.html');

?>
