<?php 
	$name = $_POST['name'];
	$userID = $_POST['userID'];
	date_default_timezone_set('PRC');
	$createDate = date('Y-m-d H:i:s',time());
	include('db.php');
	$query = mysql_query("select * from tag where name='$name'");
	if(mysql_num_rows($query)){
		$tag_row = mysql_fetch_array($query);
		echo $tag_row['ID'];
	}else{
		mysql_query("insert into tag values ('0','$name','$userID','$createDate') ");
		$tag_row = mysql_fetch_array(mysql_query("select * from tag where name = '$name' and author_ID = '$userID'"));
		echo $tag_row['ID'];
	}
?>
