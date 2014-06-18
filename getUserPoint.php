<?php
	session_start();
	if(isset($_SESSION['user_id'])){
		$user_id = $_SESSION['user_id'];
		include('db.php');
		$user_point = mysql_query("select * from user_point where user_ID = '$user_id'");
		if(mysql_num_rows($user_point)){
			$user_point_row = mysql_fetch_array($user_point);
			$point = $user_point_row['point'];
			echo $point;
		}
	}else{
		echo "noUser";
	}
?>
