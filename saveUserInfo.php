<?php 
	include('db.php');
	$person_ID = $_POST['person_ID'];
	$sex = $_POST['sex'];
	$birthday = $_POST['birthday'];
	$constellation = $_POST['constellation'];
	$realname = $_POST['realname'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$address = $_POST['address'];
	$profession = $_POST['profession'];
	$workplace = $_POST['workplace'];
	session_start();
	if(isset($_SESSION['user_id'])){
		if($_SESSION['user_id'] == $person_ID){
			mysql_query("update user_info set sex = '$sex',birthday = '$birthday',constellation = '$constellation',realname = '$realname',email = '$email',telephone = '$telephone',address = '$address',profession = '$profession',workplace = '$workplace' where user_ID = '$person_ID' ");
		}else{
			echo "noPower";
		}
	}else{
		echo "noUser";
	}
?>