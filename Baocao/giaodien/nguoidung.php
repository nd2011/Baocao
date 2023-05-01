<?php

	session_name('YourVisitID');
	session_start();
	$page_title ="Xem người dùng hiện tại";
	include "trangdau.html";
	require_once "mysql.php";
	$query = "Select CONCAT(first_name, ' ' , last_name) as name, date_format(registration_date, '* %d/%m/%y') as dr, 			username FROM USERS Order By registration_date ASC";
	$result = mysqli_query($conn,$query);
	$num = mysqli_num_rows($result);
	if ($num > 0){
		
		echo "<table width='70%'' border='0' align='center' cellspacing='0' cellspacing='0'>
				<tr><td colspan='2'><h3> Hiện có $num người đã được đăng ký như sau:</h3><td></tr>
				<tr>
					<td align='left'> <b> TÊN </b> <hr/>  </td>
					<td align='left'> <b> NGÀY ĐĂNG KÝ </b> <hr/>  </td>
					<td align='left'> <b> TÊN TÀI KHOẢN</b> <hr/>  </td>
				</tr>";
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM))	{
			echo "<tr>
					<td align='left'> $row[0] </td>
					<td align='left'> $row[1] </td>
					<td align='left'> $row[2] </td>
				  </tr> \n";
		}
		echo "</table> <br/>";

		mysqli_free_result($result);//Giải phóng tài nguyên câu truy vấn
	} else{
		echo "<p> Danh sách người dùng không thể hiển thị vì lỗi hệ thống hoặc chưa có người dùng</p> <p>" . mysqli_error($conn) . "</p>";
	}
	mysqli_close($conn);
	include('trangcuoi.html');
?>