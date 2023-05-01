<?php
	$servername = "localhost";
	$username_mysql = "root";
	$password_mysql = "";
	$dbname = "Baocao";

	// Kết nối tới cơ sở dữ liệu
	$conn = mysqli_connect($servername, $username_mysql, $password_mysql, $dbname);

	// Kiểm tra kết nối
	if (!$conn) {
    	die("Kết nối không thành công: " . mysqli_connect_error());
	}

?>