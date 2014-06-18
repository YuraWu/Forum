<?php 
	error_reporting(0);
	include('db.php');
	$content = $_GET[data];
	$query = mysql_query("select * from tag");
	$result = array();
	while($row = mysql_fetch_array($query)){
		if(strpos($content,$row['name']) !== false){
			$tag = array($row['ID'],$row['name']);
			array_push($result, $tag);
		}
	}
	echo json_encode($result);
?>