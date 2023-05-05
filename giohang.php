<!DOCTYPE html>
<html>
<head>
    <title>Giỏ hàng</title>
</head>
<body>
    <?php
    ob_start();
    include('trangdau.html');
    // Khởi động session
    session_start();
    // Kết nối đến CSDL
    require_once "mysql.php";
    // Kiểm tra xóa sản phẩm khỏi giỏ hàng
    if(isset($_GET['remove'])) {
        $id = $_GET['remove'];

        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$id]);
    }

    // Kiểm tra xem giỏ hàng có sản phẩm hay không
    if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        $total_price = 0;
    ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
    // Hiển thị các sản phẩm trong giỏ hàng
    foreach($_SESSION['cart'] as $id => $product) {
        $sql = "SELECT * FROM books WHERE id = $id";
        $sql = "SELECT * FROM books";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['title'];
            $price = $row['price'];
            $quantity = $product['quantity'];
            $total = $price * $quantity;
            $total_price += $total;
            ?>
            <tr>
                <td><?php echo $name; ?></td>
                <td><?php echo $price; ?></td>
                <td>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>">
                        <input type="number" name="quantity" value="<?php echo $quantity; ?>">
                        <input type="submit" name="update_quantity" value="Cập nhật">
                    </form>
                </td>
                <td><?php echo $total; ?></td>
                <td><a href="<?php echo $_SERVER['PHP_SELF'] . '?remove=' . $id; ?>">Remove</a></td>
            </tr>
        <?php
        } // Đóng cặp dấu ngoặc graff `if`
    } // Đóng cặp dấu ngoặc graff `foreach`
    ?>

                <tr>
                    <td colspan="3">Total Price:</td>
                    <td><?php echo $total_price; ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    <?php
} else {
    echo "Giỏ của bạn trống.";
}
?>

<!-- Hiển thị danh sách sản phẩm để thêm vào giỏ hàng -->
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Lấy danh sách sản phẩm từ CSDL
        $sql = "SELECT * FROM books";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)) {
$id = $row['id'];
$name = $row['title'];
$price = $row['price'];
?>
<tr>
<td><?php echo $name; ?></td>
<td><?php echo $price; ?></td>
<td>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>">
<input type="number" name="quantity" value="1">
<input type="submit" name="add_to_cart" value="Mua hàng">
</form>
<form method="post" action="thanhtoan.php">
                <label>Chọn phương thức thanh toán:</label><br>
                <input type="radio" name="payment_method" value="credit_card"> Thanh toán bằng thẻ ngân hàng<br>
                <input type="radio" name="payment_method" value="cash"> Thanh toán bằng tiền mặt<br>
                <input type="submit" name="submit" value="Thanh toán">
</form>
</td>
<td></td>
</tr>
<?php
     } // Đóng cặp dấu ngoặc graff `while`
     mysqli_free_result($result);
     ?>
</tbody>

</table>
<?php
// Kiểm tra thêm sản phẩm vào giỏ hàng
if(isset($_POST['add_to_cart'])) {
    $id = $_GET['id'];
    $quantity = $_POST['quantity'];

    // Thêm sản phẩm vào giỏ hàng
    if(isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = array('quantity' => $quantity);
    }
    header("Location: ".$_SERVER['PHP_SELF']);
}

// Kiểm tra cập nhật số lượng sản phẩm trong giỏ hàng
if(isset($_POST['update_quantity'])) {
    $id = $_GET['id'];
    $quantity = $_POST['quantity'];

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $_SESSION['cart'][$id]['quantity'] = $quantity;
    header("Location: ".$_SERVER['PHP_SELF']);
}

// Đóng kết nối CSDL
mysqli_close($conn);

ob_end_flush();
?>
<?php include('trangcuoi.html') ?>
</body>
</html>