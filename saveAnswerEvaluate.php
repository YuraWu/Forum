<?php
	error_reporting(0);
	include('db.php');
	session_start();
	$answer_ID = $_POST["answer_ID"];
	$type = $_POST["type"];
	date_default_timezone_set('PRC');
	$dateTime = date('Y-m-d H:i:s',time());
	if(isset($_SESSION['user_id'])){
		$user_ID = $_SESSION['user_id']; 
		mysql_query("insert into answer_evaluate values ('$answer_ID','$type','$user_ID','$dateTime')");
		$query = mysql_query("select * from answer_cnt where answer_ID = '$answer_ID'");
		if(mysql_num_rows($query)){
			$row = mysql_fetch_array($query);
			if($type == 'praise'){
				$praiseCnt = $row['praiseCnt'] + 1;
				echo $praiseCnt;
				mysql_query("update answer_cnt set praiseCnt = '$praiseCnt' where answer_ID = '$answer_ID'");
			}elseif($type == 'degrade'){
				$degradeCnt = $row['degradeCnt'] + 1;
				echo $degradeCnt;
				mysql_query("update answer_cnt set degradeCnt = '$degradeCnt' where answer_ID = '$answer_ID'");
			}
		}
	}else{
		echo "noUser";
	}
	mysql_close();
?>