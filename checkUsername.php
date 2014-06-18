<?php 
	error_reporting(0);
	include('db.php');
	$username = $_GET[name];
	$query = mysql_query("select * from user where username = '$username'");
	if(mysql_num_rows($query)){
		echo true;
	}else{
		echo false;
	}
?>