<?php
	session_start();
	header("Content-Type:text/html;charset=utf-8");
	$ID = $_POST['ID'];
	$user_ID = 0;
	if(isset($_SESSION['user_id'])){ 
		$user_ID = $_SESSION['user_id'];
	}
	include('db.php');
	$question = mysql_query("select * from question where ID = '$ID' ");
	if(mysql_num_rows($question)){
		$question_row = mysql_fetch_array($question);
		if($user_ID == $question_row['author_ID']){
			$user_point = mysql_query("select * from user_point where user_ID = '$user_ID' ");
			$user_point_row = mysql_fetch_array($user_point);
			$point = $user_point_row['point'] - 10;
			if($point < 0){
				echo "noPoint";
			}else{
				mysql_query("delete from question_care where question_ID = '$ID' ");
				mysql_query("delete from question_cnt where question_ID = '$ID' ");
				mysql_query("delete from question_evaluate where question_ID = '$ID' ");
				mysql_query("delete from question_tag where question_ID = '$ID' ");
				$answer = mysql_query("select * from answer where question_ID = '$ID' ");
				if(mysql_num_rows($answer)){
					while($answer_row = mysql_fetch_array($answer)){
						$answer_ID = $answer_row['ID'];
						mysql_query("delete from answer_cnt where answer_ID = '$answer_ID' ");
						mysql_query("delete from answer_comment where answer_ID = '$answer_ID' ");
					}
				}
				mysql_query("delete from answer where question_ID = '$ID'");
				mysql_query("delete from question where ID = '$ID'");
				mysql_query("update user_point set point = '$point' where user_ID = '$user_ID'");
				echo "deleteSuccess";
			}
		}
		else{
			echo "noPower";
		}
	}
	else{
		echo "noQuestion";
	}
	
?>