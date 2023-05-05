<?php
session_start();
include('trangdau.html');
require_once 'mysql.php';

if(isset($_POST['create'])) {
    // Lấy thông tin sách từ form
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    // Kiểm tra nếu trường tiêu đề và tác giả không để trống thì thêm sách vào bảng books
    if (!empty($title) && !empty($author)) {
        // Thực hiện truy vấn SQL để thêm sách mới vào bảng books
        $sql = "INSERT INTO books (title, author, description) VALUES ('$title', '$author', '$description')";

        if (mysqli_query($conn, $sql)) {
            echo "Thêm sách thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Tiêu đề và tác giả không được để trống";
    }
}

mysqli_close($conn); // đóng kết nối CSDL
include('trangcuoi.html');
?>
