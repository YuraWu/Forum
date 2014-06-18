<?php
	session_start();
	header("Content-Type:text/html;charset=utf-8");
	$ID = $_POST['ID'];
	include('db.php');
	$user_ID = 0;
	if(isset($_SESSION['user_id'])){ 
		$user_ID = $_SESSION['user_id'];
	}
	$answer = mysql_query("select * from answer where ID = '$ID' ");
	if(mysql_num_rows($answer)){
		$answer_row = mysql_fetch_array($answer);
		if($user_ID == $answer_row['author_ID']){
			$user_point = mysql_query("select * from user_point where user_ID = '$user_ID' ");
			$user_point_row = mysql_fetch_array($user_point);
			$point = $user_point_row['point'] - 5;
			if($point < 0){
				echo "noPoint";
			}else{
				$question_ID = $answer_row['question_ID'];
				$answer_cnt = mysql_query("select * from answer_cnt where answer_ID = '$ID'");
				$answer_cnt_row = mysql_fetch_array($answer_cnt);
				$question_cnt = mysql_query("select * from question_cnt where question_ID = '$question_ID'");
				$question_cnt_row = mysql_fetch_array($question_cnt);
				$question_cnt_answer = $question_cnt_row['answerCnt'] - 1;
				mysql_query("update question_cnt set answerCnt = '$question_cnt_answer' where question_ID = '$question_ID'");
				if($answer_cnt_row['beSatisfied']){
					$question_cnt_satifiedAnswer = $question_cnt_row['satisfiedAnswerCnt'] - 1;
					echo "满意回答 ".$question_cnt_satifiedAnswer;
					mysql_query("update question_cnt set satisfiedAnswerCnt = '$question_cnt_satifiedAnswer' where question_ID = '$question_ID'");
				}else{
					$question_cnt_normalAnswer = $question_cnt_row['normalAnswerCnt'] - 1;
					echo "其他回答 ".$question_cnt_normalAnswer;
					mysql_query("update question_cnt set normalAnswerCnt = '$question_cnt_normalAnswer' where question_ID = '$question_ID'");
				}
				mysql_query("delete from answer_cnt where answer_ID = '$ID' ");
				mysql_query("delete from answer_comment where answer_ID = '$ID' ");
				mysql_query("delete from answer_evaluate where answer_ID = '$ID' ");
				mysql_query("delete from answer where ID = '$ID' ");
				mysql_query("update user_point set point = '$point' where user_ID = '$user_ID'");
			}
		}else{
			echo "noPower";
		}
	}else{
		echo "noAnswer";
	}
?>