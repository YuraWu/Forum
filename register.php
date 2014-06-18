<?php
	error_reporting(0);
	session_start();
	if(!isset($_SESSION['user_id'])){
		if($_POST["submit"]){
			include("db.php");
			$username = $_POST["username"];
			$password = $_POST["password"];
			date_default_timezone_set('PRC');
			$createDate = date('Y-m-d H:i:s',time());
			$query = mysql_query("select * from user where username = '$username'");
			if(mysql_num_rows($query)){
				echo "usernameExited";
			}else{
				mysql_query("insert into user values('0','$username','$password','$registerDate')");
				$username_query = mysql_query("select * from user where username = '$username'");
				if(mysql_num_rows($username_query)){
					$user_ID = mysql_fetch_array($username_query)['ID'];
					mysql_query("insert into user_info(user_ID) values('$user_ID')");
					mysql_query("insert into user_point values('$user_ID','10')");
				}else{
					echo "unknownError";
				}
			}
			$home_url = 'index.php';
	  		header('Location: '.$home_url);
	    }
    }
?>
