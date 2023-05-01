<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sach</title>
</head>
<body>
<?php
include('trangdau.html');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Baocao";

require_once "mysql.php";

$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // Hiển thị danh sách sách
        while($row = mysqli_fetch_assoc($result)) {
            echo "<h2>" . $row["title"] . "</h2>";
            echo "<p> id: " . $row["id"]. "</p>";
            echo "<p>Tác giả: " . $row["author"] . "</p>";
            echo "<p>Nhà xuất bản: " . $row["publisher"] . "</p>";
            echo "<p>Giá: $" . $row["price"] . "</p>";
            echo "<a href='mua.php?id=" . $row["id"] . "'>Mua sách</a>";
        }
    } else {
        echo "Không có sách nào.";
    }
} else {
    echo "Lỗi truy vấn: " . mysqli_error($conn);
}
function muasach(){
    return '<a href="mua.php">Mua sách</a>';
}
include('trangcuoi.html');
?>
</body>
</html>