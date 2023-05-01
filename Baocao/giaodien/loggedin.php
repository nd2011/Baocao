<?php
	//Trường hợp sử dụng COOKIE
	//if(!isset($_COOKIE['name'])){
	//	header("Location: http://Localhost:8080" . $server['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php");
	//	exit();
	//}
	//Trường hợp sử dụng SESSION
	session_name('YourVisitID');
	session_start();
	if(!isset($_SESSION['name'])){
		header("Location: http://Localhost" . $server['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php");
		exit();
	}
	$page_title ="Bạn đăng nhập thành công!";
	include 'trangdau.html';
	//Trường hợp sử dụng COOKIE
	//echo "<p>Bạn đã đăng nhập thành công!, {$_COOKIE['name']}! </p>";
	//Trường hợp sử dụng SESSION
	echo "<p>Bạn đã đăng nhập thành công!, {$_SESSION['name']}! </p>";
	include 'trangcuoi.html';
?>