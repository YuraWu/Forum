<?php
	session_start();
	header("Content-Type:text/html;charset=utf-8");
	$title = $_POST["editQuestion-title"];
	$content = $_POST["editQuestion-content"];
	$point = $_POST["point"];
	date_default_timezone_set('PRC');
	$createDate = date('Y-m-d H:i:s',time());
	$author = $_SESSION['user_id'];
	include('db.php');
	mysql_query("insert into question values('0','$title','$content','$author','$point','$createDate')");
	$query = mysql_query("select * from question where ID = (select max(ID) from question)");
	if($row = mysql_fetch_array($query)){
		$question_ID = $row['ID'];
		$tags = $_POST["questionTags"];
		mysql_query("insert into question_cnt values('$question_ID','0','0','0','0','0','0','0')");
		foreach($tags as $tag){
			echo $tag;
			mysql_query("insert into question_tag values('$question_ID','$tag')");
		}
	}
	$home_url = "questionInfo.php?ID=$question_ID ";
	header('Location: '.$home_url);
?>