<?php
	error_reporting(0);
	session_start();
	if($_POST['submit']){
		if(isset($_SESSION['user_id'])){
			$home_url = 'personIndex.php?ID='.$_SESSION['user_id'];
	    	header('Location: '.$home_url);
	    }else{
			include("db.php");
			$username = $_POST["username"];
			$password = $_POST["password"];
			$query_username = mysql_query("select * from user where username = '$username'");
			if(!mysql_num_rows($query_username)){
				echo "usernameUnexited";
			}else{
				$query_password = mysql_query("select * from user where username = '$username' and password = '$password'");
				if($row = mysql_fetch_array($query_password)){
					$_SESSION['user_id']=$row['ID'];
			        $_SESSION['username']=$row['username'];
			        setcookie('user_id',$row['ID'],time()+(60*60*24*30));
			        setcookie('username',$row['username'],time()+(60*60*24*30));
			        $home_url = 'personIndex.php?ID='.$row['ID'];
	    			header('Location: '.$home_url);
			    }else{
			    	echo "passwordError";
			    }
			}
	    }
	}else{
		if(isset($_SESSION['user_id'])){
			echo "hasUser";
	    }else{
			include("db.php");
			$username = $_POST["username"];
			$password = $_POST["password"];
			$query_username = mysql_query("select * from user where username = '$username'");
			if(!mysql_num_rows($query_username)){
				echo "usernameUnexited";
			}else{
				$query_password = mysql_query("select * from user where username = '$username' and password = '$password'");
				if($row = mysql_fetch_array($query_password)){
					echo "success";
			    }else{
			    	echo "passwordError";
			    }
			}
	    }
	}
    if($_GET['action'] == "logout"){
	    unset($_SESSION['user_id']);
	    unset($_SESSION['username']);
	    $home_url = 'index.php';
	    header('Location: '.$home_url);
	    exit;
	}
?>