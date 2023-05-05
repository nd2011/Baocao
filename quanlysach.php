<?php include('trangdau.html');?>
<!DOCTYPE html>
<html>
<head>
    <title>Quản lý sách</title>
</head>
<body>
    <h1>Quản lý sách</h1>

    <h2>Thêm sách mới</h2>
    <form action="crud.php" method="POST">
        <input type="text" name="title" placeholder="Tiêu đề">
        <br>
        <input type="text" name="author" placeholder="Tác giả">
        <br>
        <textarea name="description" placeholder="Mô tả"></textarea>
        <br>
        <button type="submit" name="create">Thêm sách</button>
    </form>

</html>
<?php include('trangcuoi.html');?>