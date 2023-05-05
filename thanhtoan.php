<?php
session_start();
include('trangdau.html');
require_once "mysql.php";

// Kiểm tra đơn hàng
if (isset($_SESSION['user_id'])) {
    $user_id_escaped = mysqli_real_escape_string($conn, $_SESSION['user_id']);
}

if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $total_price = 0;
    $quantity = 0;

    // Tính tổng số lượng đặt hàng và tổng giá trị đơn hàng
    foreach ($_SESSION['cart'] as $book_id => $book_quantity) {
        $book_id = mysqli_real_escape_string($conn, $book_id);
        $book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id=$book_id"));
        $price = $book['price'];
        if (is_array($book_quantity)) {
            $qty = array_sum($book_quantity);
            $quantity += $qty;
            $total_price += $price * $qty;
        } else {
            $book_quantity = mysqli_real_escape_string($conn, $book_quantity);
            $quantity += $book_quantity; 
            $total_price += $price * $book_quantity;
        }
    }

    // Thêm đơn hàng vào database
    $name_escaped = mysqli_real_escape_string($conn, $name);
    $phone_escaped = mysqli_real_escape_string($conn, $phone);
    $address_escaped = mysqli_real_escape_string($conn, $address);
    $sql = "INSERT INTO orders (user_id, total_price, quantity, name, phone_number, address) VALUES ('$user_id_escaped', '$total_price', '$quantity', '$name_escaped', '$phone_escaped', '$address_escaped')";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        // Lấy ID của đơn hàng vừa thêm vào
        $order_id = mysqli_insert_id($conn);

        // Thêm sản phẩm vào bảng order_items
        foreach ($_SESSION['cart'] as $book_id => $book_quantity) {
            $book_id = mysqli_real_escape_string($conn, $book_id);
            $book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id=$book_id"));
            $price = $book['price'];
            if (is_array($book_quantity)) {
                foreach ($book_quantity as $key => $value) {
                    $value = mysqli_real_escape_string($conn, $value);
                    $sql = "INSERT INTO order_items (order_id, book_id, quantity, price) VALUES ('$order_id', '$book_id', '$value', '$price')";
                    mysqli_query($conn, $sql);
                }
            } else {
                $book_quantity = mysqli_real_escape_string($conn, $book_quantity);
                $sql = "INSERT INTO order_items (order_id, book_id, quantity, price) VALUES ('$order_id', '$book_id', '$book_quantity', '$price')";
                mysqli_query($conn, $sql);
            }
        }
    }
        // Xóa giỏ hàng
    unset($_SESSION['cart']);

    // Hiển thị thông báo đặt hàng thành công và thông tin đơn hàng
    echo "<div class='container'>";
    echo "<h3 class='text-center'>Đặt hàng thành công!</h3>";
    echo "<p class='text-center'>Mã đơn hàng của bạn là: <strong>{$order_id}</strong></p>";
    echo "<p class='text-center'>Tổng số lượng sản phẩm: <strong>{$quantity}</strong></p>";
    echo "<p class='text-center'>Tổng giá trị đơn hàng: <strong>{$total_price}đ</strong></p>";
    echo "<p class='text-center'>Thông tin giao hàng:</p>";
    echo "<ul>";
    echo "<li><strong>Họ tên:</strong> {$name}</li>";
    echo "<li><strong>Số điện thoại:</strong> {$phone}</li>";
    echo "<li><strong>Địa chỉ:</strong> {$address}</li>";
    echo "</ul>";
    echo "</div>";
} else {
echo "Đặt hàng thất bại!";
}

include('trangcuoi.html');
?>