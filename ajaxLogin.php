<?php
	session_start();
	include("db.php");
	$username = $_GET["username"];
	$password = $_GET["password"];
	$result = array();
	$query_username = mysql_query("select * from user where username = '$username'");
	if(!mysql_num_rows($query_username)){
		array_push($result,"usernameUnexited");
		array_push($result,"0");
	}else{
		$query_password = mysql_query("select * from user where username = '$username' and password = '$password'");
		if($row = mysql_fetch_array($query_password)){
			$ID = $row['ID'];
			$_SESSION['user_id'] = $row['ID'];
	        $_SESSION['username'] = $row['username'];
	        setcookie('user_id',$row['ID'],time()+(60*60*24*30));
	        setcookie('username',$row['username'],time()+(60*60*24*30));
	        array_push($result,"<div>$username</div>
				<div id='user-menu'>
					<div class='user-item'><a href='personIndex.php?ID=$ID'>个人中心</a></div>
					<div class='user-item'><a href='editQuestion.php'>提问</a></div>
					<div class='user-item'><a id='logout'>注销</a></div>
				</div>");
	        array_push($result, $row['ID']);
	    }else{
	    	array_push($result,"passwordError");
			array_push($result,"0");
	    }
	}
	echo json_encode($result);
?>