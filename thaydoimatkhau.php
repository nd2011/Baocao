<?php
	session_name('YourVisitID');
	session_start();
	$page_title = "Thay đổi mật khẩu";
	include('trangdau.html');
	require_once 'mysql.php'; //kết nối đến database "vidu2" trong MySQL
	//hàm xử lý khi chuỗi nhập có ký tự đặc biết như: ', "" để cập nhật vào dữ liệu
	function escape_data($data){
		global $conn;
		if(ini_get('magic_quotes_gpc')){
			$data = stripslashes($data);// Loại bỏ dấu '/'
		}
		return mysqli_real_escape_string($conn, $data); //Loại bỏ ký tự đặc biệt
	}
	
	if(isset($_POST['submit'])){
		// Kiểm tra nhập dữ liệu
		$msg = NULL;
		if(empty($_POST['username'])){
			$u =FALSE;
			$msg .= "<p>Bạn chưa nhập tên đăng ký!</p>";
		}else{
			$u = trim(escape_data($_POST['username']));
		}
		if(empty($_POST['password'])){
			$p=FALSE;
			$msg .= "<p>Bạn chưa nhập mật khẩu hiện tại!</p>";
		}else{
			$p = trim(escape_data($_POST['password']));
		}
		if(empty($_POST['password1'])){
			$np=FALSE;
			$msg .= "<p>Bạn chưa nhập mật khẩu mới!</p>";
		}else{
			if($_POST['password1']==$_POST['password2']){
				$np = trim(escape_data($_POST['password1']));	
			}else {
				$np=FALSE;
				$msg .= "Mật khẩu mới không khớp với giá trị xác nhận";
			} 
		}
		// Xử lý cập nhật mật khẩu
		if( $u && $p && $np){
			$query ="SELECT user_id from users where (username='$u' and password=PASSWORD('$p')) ";
			$result = mysqli_query($conn, $query);
			$num = mysqli_num_rows($result);
			if ($num == 1) {
				$row = mysqli_fetch_array($result, MYSQLI_NUM);
				$query = "UPDATE users SET password=PASSWORD('$np') WHERE user_id=$row[0] ";
				$result = mysqli_query($conn, $query);
				//Kiểm tra đã tác động đến CSDL
				if (mysqli_affected_rows($conn)==1) {
					echo "<p><b> Mật khẩu thay đổi thành công </b></p>";
					include('template/footer.inc');
					exit();
				}	
				else $msg .= "Mật khẩu của bạn không thể thay đổi được. Xin vui lòng liên hệ nhà quản trị!";
			}else $msg .= "Tên đăng nhập hoặc mật khẩu của bạn không đúng " ;
		}else $msg .= "<p>Hãy thử lại</p>";
		
		if(isset($msg)) echo "<font color='red'>" . $msg . "</font>"; //In thông báo lỗi
	}
	mysqli_close($conn); //Đóng kết nối
?>
<!-- FORM NHẬP DỮ LIỆU -->
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
	<fieldset>
		<legend>Nhập vào thông tin của bạn</legend>
		
		<p>
			<b>Tên đăng nhập:</b> 
			<input type="text" name="username" size="20" maxlength="20" value="<?php if(isset($_POST['username'])) 
				echo $_POST['username']; ?>" /> 
		</p>
		<p>	<b>Mật khẩu hiện tại:</b> <input type="password" name="password" size="20" maxlength="20" /> </p>
		<p>	<b>Mật khẩu mới:</b> <input type="password" name="password1" size="20" maxlength="20" /> </p>
		<p>	<b>Xác nhận mật khẩu mới:</b> <input type="password" name="password2" size="20" maxlength="20" /> </p>
	</fieldset>
	<div align="center"> <input type="submit" name="submit" value="Đăng ký" /> </div>
</form>
<?php
	include('trangcuoi.html');
?>