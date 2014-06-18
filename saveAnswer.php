<?php
	error_reporting(0);
	session_start();
	header("Content-Type:text/html;charset=utf-8");
	$content = $_GET["content"];
	$question_ID = $_GET["question_ID"];
	date_default_timezone_set('PRC');
	$createDate = date('Y-m-d H:i:s',time());
	$result = array();
	include('db.php');
	if(isset($_SESSION['user_id'])){
		$answer_author_ID = $_SESSION['user_id'];
		mysql_query("insert into answer values('0','$content','$answer_author_ID','$question_ID','$createDate')");
		$query = mysql_query("select * from answer where ID = (select max(ID) from answer)");
		if($row = mysql_fetch_array($query)){
			$answer_ID = $row['ID'];
			mysql_query("insert into answer_cnt values('$answer_ID',0,0,0,0)");
		}else{
			$answer_ID = 0;
		}
		$question_row = mysql_fetch_array(mysql_query("select * from question where ID = '$question_ID'"));
		$question_author_ID = $question_row['author_ID'];
		$question_cnt_query = mysql_query("select * from question_cnt where question_ID = $question_ID");
		if($row = mysql_fetch_array($question_cnt_query)){
			$normalAnswerCnt = $row['normalAnswerCnt'];
			$answerCnt = $row['answerCnt'];
			$normalAnswerCnt = $normalAnswerCnt + 1;
			$answerCnt = $answerCnt + 1;
			array_push($result, "其他回答 ".$normalAnswerCnt);
			mysql_query("update question_cnt set normalAnswerCnt = '$normalAnswerCnt',answerCnt = '$answerCnt' where question_ID = '$question_ID'");
		}
		$answer_author_row = mysql_fetch_array(mysql_query("select * from user where ID = '$answer_author_ID'"));
		$answer_author_point_row = mysql_fetch_array(mysql_query("select * from user_point where user_ID = '$answer_author_ID'"));
		$answer_author_name = $answer_author_row['username'];
		$point = $answer_author_point_row['point'] + 2;
		mysql_query("update user_point set point = '$point' where user_ID = '$answer_author_ID' ");

		$html = "<input type='text' class='answer-ID none' value='$answer_ID'>
			<div class='questionInfo-normalAnswer-content'>$content</div>
			<div class='questionInfo-answer-delete requireLogin' userID='$answer_author_ID'></div>
			<div class='date'>
				$createDate by 
				<a href='personIndex.php?ID=$answer_author_ID'> $answer_author_name </a>
			</div>
			<div class='buttonGroup'>
				<input class='questionInfo-comment-showbutton' type='button' value='评论 0'>
				<input class='questionInfo-comment-hidebutton none' type='button' value='收起评论'>	
				<input class='questionInfo-answer-praise' type='button' value='赞 0'>
				<input class='questionInfo-answer-degrade' type='button' value='贬 0'>
				<input class='questionInfo-answer-delete requireLogin' userID='$question_author_ID' type='button' value='删除'>
				<input class='questionInfo-answer-setSatisfied requireLogin' userID='$question_author_ID' type='button' value='满意'>
			</div>
			<div class='questionInfo-commentPanel none'>
				<div class='questionInfo-commentList'>
					<div class='questionInfo-noComment'>本回答暂无评论</div>
				</div>
				<div class='questionInfo-myComment'>
					<input class='questionInfo-myComment-showbutton' type='button' value='我来评论'>
					<input class='questionInfo-myComment-hidebutton none' type='button' value='取消评论'>
					<div class='questionInfo-myCommentArea none'>
						<textarea type='text' id='myComment-text'></textarea>
						<div class='questionInfo-myCommentSubmit'>
							<input type='text' class='answer-ID none' value='$answer_ID' >
							<input type='button' name='submit' class='myComment-submit' value='评论'>
						</div>
					</div>
				</div>
			</div>";
			array_push($result,	$html);
	}else{
		array_push($result,"noUser");
	}
	echo json_encode($result);
?>