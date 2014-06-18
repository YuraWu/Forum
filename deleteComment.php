<?php 
	include('db.php');
	session_start();
	$comment_ID = $_POST["comment_ID"];
	$user_ID = 0;
	if(isset($_SESSION['user_id'])){ 
		$user_ID = $_SESSION['user_id'];
	}
	$comment = mysql_query("select * from answer_comment where ID = '$comment_ID'");
	if(mysql_num_rows($comment)){
		$comment_row = mysql_fetch_array($comment);
		if($user_ID == $comment_row['author_ID']){
			$answer_ID = $comment_row["answer_ID"];
			mysql_query("delete from answer_comment where ID = '$comment_ID'");
			$query = mysql_query("select * from answer_cnt where answer_ID = '$answer_ID' ");
			if(mysql_num_rows($query)){
				$row = mysql_fetch_array($query);
				$commentCnt = $row['commentCnt'] - 1;
				echo $commentCnt;
				mysql_query("update answer_cnt set commentCnt = '$commentCnt' where answer_ID = '$answer_ID' ");
			}
		}else{
			echo "noPower";
		}	
	}else{
		echo "noComment";
	}
?>