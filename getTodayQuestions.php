<?php
	session_start();
	if(isset($_SESSION['user_id'])){
		$user_id = $_SESSION['user_id'];
		date_default_timezone_set('PRC');
		$today = date("Y-m-d",time());
		include('db.php');
		$user_point = mysql_query("select * from user_point where user_ID = '$user_id'");
		if(mysql_num_rows($user_point)){
			$user_point_row = mysql_fetch_array($user_point);
			$point = $user_point_row['point'];
			$question = mysql_query("select * from question where author_ID = '$user_id'");
			if(mysql_num_rows($question)){
				$question_today_cnt = 0;
				while($question_row = mysql_fetch_array($question)){
					if(strpos($question_row['createDate'], $today) !== false){
						$question_today_cnt++;
					}
				}
				$restQuestion = (int)($point / 10) + 1 - $question_today_cnt;
				echo $restQuestion;
			}else{
				echo 1;
			}
		}
	}else{
		$user_id = 0;
	}
?>
