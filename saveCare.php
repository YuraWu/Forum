<?php 
	include('db.php');
	session_start();
	$question_ID = $_POST["question_ID"];
	$operation = $_POST['operation'];
	date_default_timezone_set('PRC');
	$dateTime = date('Y-m-d H:i:s',time());
	if(isset($_SESSION['user_id'])){
		$user_ID = $_SESSION['user_id'];
		if($operation == 'save'){
			mysql_query("insert into question_care values('$user_ID','$question_ID','$dateTime')");
			$question_cnt_row = mysql_fetch_array(mysql_query("select * from question_cnt where question_ID = '$question_ID' "));
			$careCnt = $question_cnt_row['careCnt'] + 1;
			echo $careCnt;
			mysql_query("update question_cnt set careCnt = '$careCnt' where question_ID = '$question_ID'");
		}
		elseif($operation == 'cancel'){
			mysql_query("delete from question_care where question_ID ='$question_ID' and user_ID = '$user_ID'");
			$question_cnt_row = mysql_fetch_array(mysql_query("select * from question_cnt where question_ID = '$question_ID' "));
			$careCnt = $question_cnt_row['careCnt'] - 1;
			echo $careCnt;
			mysql_query("update question_cnt set careCnt = '$careCnt' where question_ID = '$question_ID'");
		}
	}else{
		echo "noUser";
	}
?>