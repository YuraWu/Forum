<?php 
	include('db.php');
	session_start();
	$content = $_GET["content"];
	$answer_ID = $_GET["answer_ID"];
	date_default_timezone_set('PRC');
	$createDate = date('Y-m-d H:i:s',time());
	$result = array();
	if(isset($_SESSION['user_id'])){
		$user_ID = $_SESSION['user_id'];
		$user = mysql_query("select * from user where ID = '$user_ID'");
		$user_row = mysql_fetch_array($user);
		$username = $user_row['username'];
		mysql_query("insert into answer_comment values('0','$content','$user_ID','$answer_ID','$createDate')");
		$query = mysql_query("select * from answer_cnt where answer_ID = '$answer_ID'");
		if(mysql_num_rows($query)){
			$row = mysql_fetch_array($query);
			$commentCnt = $row['commentCnt'] + 1;
			array_push($result,$commentCnt);
			mysql_query("update answer_cnt set commentCnt = '$commentCnt' where answer_ID = '$answer_ID'");
		}
		$comment_row = mysql_fetch_array(mysql_query("select max(ID) from answer_comment"));
		$comment_ID = $comment_row['max(ID)'];
		$html = "<div class='questionInfo-commentContent'>$content</div>
			<div class='date'>
			$createDate by 
			<a href='personIndex.php?ID=$user_ID'>
				$username
			</a>
			<input type='button' class='comment-delete requirelogin' userID='$user_ID' value='删除评论'>
			<input type='text' class='comment-id none' value='$comment_ID' >
		</div>";
		array_push($result,$html);
	}else{
		array_push($result, "noUser");
	}
	echo json_encode($result);
?>

