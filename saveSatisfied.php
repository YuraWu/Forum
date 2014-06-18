<?php 
	session_start();
	$answer_ID = $_POST["answer_ID"];
	if(isset($_SESSION['user_id'])){
		$user_ID = $_SESSION['user_id'];
		include('db.php');
		$answer_query = mysql_query("select * from answer where ID = '$answer_ID'");
		if(mysql_num_rows($answer_query)){
			$answer_row = mysql_fetch_array($answer_query);
			$question_ID = $answer_row['question_ID'];
			$question_query = mysql_query("select * from question where ID = '$question_ID'");
			$question_row = mysql_fetch_array($question_query);
			$question_author_ID = $question_row['author_ID'];
			if($user_ID == $question_author_ID){
				mysql_query("update answer_cnt set beSatisfied = '1' where answer_ID = '$answer_ID'");
				$question_cnt_row = mysql_fetch_array(mysql_query("select * from question_cnt where question_ID = '$question_ID'"));
				$normalAnswerCnt = $question_cnt_row['normalAnswerCnt'] - 1;
				$satisfiedAnswerCnt = $question_cnt_row['satisfiedAnswerCnt'] + 1;
				mysql_query("update question_cnt set normalAnswerCnt = '$normalAnswerCnt',satisfiedAnswerCnt = '$satisfiedAnswerCnt' where question_ID = '$question_ID'");
				$answer_author_ID = $answer_row['author_ID'];
				$answer_author_point_row = mysql_fetch_array(mysql_query("select * from user_point where user_ID = '$answer_author_ID'"));
				$answer_author_point = $answer_author_point_row['point'] + $question_row['point'];
				mysql_query("update user_point set point = '$answer_author_point' where user_ID = '$answer_author_ID'");
			}else{
				echo "noPower";
			}
		}else{
			echo "noAnswer";
		}
	}else{
		echo "nouser";
	}
?>