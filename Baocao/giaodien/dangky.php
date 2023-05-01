<?php
	session_name('YourVisitID');
	session_start();
	$page_title ="Đăng ký";
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
	if (isset($_POST['submit'])){
		$msg = NULL;
		//Kiểm tra First_Name
		If(empty($_POST['first_name'])){
			$fn = FALSE;
			$msg  .="<p>Bạn chưa nhập tên họ</p>";
		}
		else $fn=trim(escape_data($_POST['first_name']));
		//Kiểm tra Last_Name
		If(empty($_POST['last_name'])){
			$ln = FALSE;
			$msg  .="<p>Bạn chưa nhập tên</p>";
		}
		else $ln=trim(escape_data($_POST['last_name']));
		//Kiểm tra Email
		If(empty($_POST['email'])){
			$e = FALSE;
			$msg  .="<p>Bạn chưa nhập Email</p>";
		}
		else $e=trim(escape_data($_POST['email']));
		//Kiểm tra UserName
		If(empty($_POST['username'])){
			$u = FALSE;
			$msg  .="<p>Bạn chưa nhập tên đăng nhập</p>";
		}
		else $u=trim(escape_data($_POST['username']));
		//Kiểm tra password
		If(empty($_POST['password1'])){
			$p = FALSE;
			$msg  .="<p>Bạn chưa nhập mật khậu!</p>";
		}
		else{
			if($_POST['password1'] == $_POST['password2'] ) $p = trim(escape_data($_POST['password1']));
			else{
				$p = FALSE;
				$msg .= "<p>Mật khẩu không khớp với phần xác nhận!</p>";
			}
		} 

		//--- Xử lý cập nhật dữ liệu Database
		if ($fn && $ln && $e && $u && $p) {
			
			$query = "Select username from users where UserName='$u'";
			$result = mysqli_query($conn, $query);
			$num = mysqli_num_rows($result);
			if ($num ==0){
				$query = "INSERT INTO users (username, first_name, last_name, email, password, registration_date) 
							VALUES ('$u', '$fn', '$ln', '$e', PASSWORD('$p'), NOW() )";
				$result = mysqli_query($conn, $query);
				if ($result){
					echo "<p><b>Bạn đã được đăng ký</b></p>";
					include('trangcuoi.html');
					exit();
				} else{
					$msg .= "<p>Bạn không thể đăng ký do lỗi hệ thống. Chúng tôi xin lỗi vì sự cố này </p><p>" 
							. mysqli_error($conn) . " </p>" ;
				}
			} else $msg ="Tên đăng nhập đã được đăng ký";
			
		} else{
			$msg .= "<p> Hãy thử lại. </p>";
		}
		// In thông báo lỗi
		if (isset($msg)) {
			echo "<font color='red'>" . $msg . "</font>";
		}
	}
	mysqli_close($conn);
?>
<!-- FORM NHẬP DỮ LIỆU -->
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
	<fieldset>
		<legend>Nhập vào thông tin của bạn</legend>
		<p>
			<b>Họ và tên đệm:</b> 
			<input type="text" name="first_name" size="15" maxlength="15" value="<?php if(isset($_POST['first_name'])) 
				echo $_POST['first_name']; ?>" /> 
		</p>
		<p>
			<b>Tên:</b> 
			<input type="text" name="last_name" size="30" maxlength="30" value="<?php if(isset($_POST['last_name'])) 
				echo $_POST['last_name']; ?>" /> 
		</p>
		<p>
			<b>Địa chỉ Email:</b> 
			<input type="text" name="email" size="40" maxlength="40" value="<?php if(isset($_POST['email'])) 
				echo $_POST['email']; ?>" /> 
		</p>
		<p>
			<b>Tên đăng nhập:</b> 
			<input type="text" name="username" size="20" maxlength="20" value="<?php if(isset($_POST['username'])) 
				echo $_POST['username']; ?>" /> 
		</p>
		<p>	<b>Mật khẩu:</b> <input type="password" name="password1" size="20" maxlength="20" /> </p>
		<p>	<b>Xác nhận mật khẩu:</b> <input type="password" name="password2" size="20" maxlength="20" /> </p>
	</fieldset>
	<div align="center"> <input type="submit" name="submit" value="Đăng ký" /> </div>
	
</form>
<?php
	
	include('trangcuoi.html');
?>