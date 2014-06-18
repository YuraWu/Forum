<?php
	error_reporting(0);
	include('db.php');
	session_start();
	$question_ID = $_POST["question_ID"];
	$type = $_POST["type"];
	$operation = $_POST["operation"];
	date_default_timezone_set('PRC');
	$dateTime = date('Y-m-d H:i:s',time());
	if(isset($_SESSION['user_id'])){
		$user_ID = $_SESSION['user_id']; 
		if($operation == 'save'){
			mysql_query("insert into question_evaluate values ('$question_ID','$type','$user_ID','$dateTime')");
			$query = mysql_query("select * from question_cnt where question_ID = '$question_ID'");
			if(mysql_num_rows($query)){
				$row = mysql_fetch_array($query);
				if($type == 'praise'){
					$praiseCnt = $row['praiseCnt'] + 1;
					echo $praiseCnt;
					mysql_query("update question_cnt set praiseCnt = '$praiseCnt' where question_ID = '$question_ID'");
				}elseif($type == 'degrade'){
					$degradeCnt = $row['degradeCnt'] + 1;
					echo $degradeCnt;
					mysql_query("update question_cnt set degradeCnt = '$degradeCnt' where question_ID = '$question_ID'");
				}
			}
		}
		else if($operation == 'cancel'){
			mysql_query("delete from question_evaluate where question_ID ='$question_ID' and user_ID = '$user_ID' and evaluateType = '$type'");
			$query = mysql_query("select * from question_cnt where question_ID = '$question_ID'");
			if(mysql_num_rows($query)){
				$row = mysql_fetch_array($query);
				if($type == 'praise'){
					$praiseCnt = $row['praiseCnt'];
					if($praiseCnt > 0)
						$praiseCnt = $praiseCnt - 1;
					echo $praiseCnt;
					mysql_query("update question_cnt set praiseCnt = '$praiseCnt' where question_ID = '$question_ID'");
				}elseif($type == 'degrade'){
					$degradeCnt = $row['degradeCnt'];
					if($degradeCnt > 0)
						$degradeCnt = $degradeCnt - 1;
					echo $degradeCnt;
					mysql_query("update question_cnt set degradeCnt = '$degradeCnt' where question_ID = '$question_ID'");
				}
			}
		}
	}else{
		echo "noUser";
	}
	mysql_close();
?>