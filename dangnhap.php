<?php
	$page_title ="Đăng nhập";
	include ('trangdau.html');
	require_once "mysql.php";
	function ecscape_data($data)	{
		global $conn;
		if(ini_get('magic_quotes_gpc')){
			$data = stripslashes($data);
		}
		return mysqli_real_escape_string($conn, $data);
	}
	if(isset($_POST['submit'])){
		$msg =NULL;
		//Kiểm tra username
		$temp=$_POST['username'];
		if(empty($temp)){
			$u= FALSE;
			$msg .= "<p>Bạn chưa nhập tên đăng nhập!</p>";
		}else{
			$u=trim(ecscape_data($temp));
		}
		//Kiểm tra password
		$temp=$_POST['password'];
		if(empty($temp)){
			$p = FALSE;
			$msg .= "<p>Bạn chưa nhập mật khẩu</p>";
		}else{
			$p = trim(ecscape_data($temp));
		}
		//Lấy user_id, first_name và lastname của người dùng
		if ($u && $p) {
			$query = "SELECT CONCAT(first_name, ' ' , last_name) as name, user_id FROM USERS 
				  	  WHERE (username='$u' and password=PASSWORD('$p'))";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			if($row){
				// lưu biến trên COOKIE
				//setcookie('name', $row[0], time()+3600,'/');
				//setcookie('user_id', $row[1], time()+3600,'/');
				// Lưu biến trên SESSION
				session_name('YourVisitID');
				session_start();
				$_SESSION['name'] = $row[0];
				$_SESSION['user_id'] = $row[1];
				header("Location: http://localhost" . $server['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/loggedin.php");
				exit();
			}else{
				$msg .= "<p>Tên đăng nhập và mật khẩu không chính xác</p>";
			}
		}else{
			$msg .= "<p>Hãy thử lại</p>";
		}
		mysqli_close($conn);
		if(isset($msg))	{
			echo "<font color='red'>" . $msg . "</font>";
		}
	}
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
	<fieldset>
		<legend>Nhập vào thông tin của bạn</legend>
		<p>
			<b>Tên đăng nhập:</b> 
			<input type="text" name="username" size="20" maxlength="20" value="<?php if(isset($_POST['username'])) 
				echo $_POST['username']; ?>" /> 
		</p>
		<p>	<b>Mật khẩu:</b> <input type="password" name="password" size="20" maxlength="20" /> </p>
		
	</fieldset>
	<div align="center"> <input type="submit" name="submit" value="Đăng nhập" /> </div>
	<div class="con2" > 
	<td> <a type="submit" href="thaydoimatkhau.php"> Thay đổi mật khẩu </a> </td>
                              <td>  <a href="dangky.php"> Đăng ký </a></div> </td>
</form>
<?php
	include('trangcuoi.html');
?>