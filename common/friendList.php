<link rel="stylesheet" type="text/css" href="static/css/friendList.css"/>
<div class="friendPanel requireLogin userIDAll">
	<?php 
		session_start();
		include('db.php');
		if(isset($_SESSION['user_id'])){
			$ID = $_SESSION['user_id'];
			$user_care = mysql_query("select * from user_care where user_ID = '$ID'");
			if(mysql_num_rows($user_care)){
				while($user_care_row = mysql_fetch_array($user_care)){
					$beCaredUserID = $user_care_row['beCaredUser_ID'];
					$beCaredUser = mysql_query("select * from user where ID = '$beCaredUserID'");
					$beCaredUser_row = mysql_fetch_array($beCaredUser);
					$beCaredUsername = $beCaredUser_row['username'];
					echo "<div class='friendItem'><a href='personIndex.php?ID=$beCaredUserID'>$beCaredUsername</a></div>";
				}
			}
		}
	?>
</div>