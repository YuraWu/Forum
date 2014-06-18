<?php 
	include("db.php");
	session_start();
	$message_ID = $_POST['message_ID'];
	$person_ID = $_POST['person_ID'];
	if(isset($_SESSION['user_id'])){
		$user_ID = $_SESSION['user_id'];
		$message = mysql_query("select * from message where ID = '$message_ID'");
		if(mysql_num_rows($message)){
			$message_row = mysql_fetch_array($message);
			if($person_ID != $user_ID){
				echo "noPower";
			}elseif($person_ID != $message_row['toUser_ID']){
				echo "noMessageOfPerson";
			}else{
				mysql_query("delete from message where ID = '$message_ID'");
				$message_query = mysql_query("select * from message where toUser_ID = '$person_ID' order by date desc");
				if(mysql_num_rows($message_query)){
					$floor = (int)mysql_num_rows($message_query);
?>
					<div class="personIndex-messageBoard-messageLabel">
						留言(<?php echo $floor?>)
					</div>
				<?php
					while($message_row = mysql_fetch_array($message_query)){
						$fromUser_ID = $message_row['fromUser_ID'];
						$toUser_ID = $message_row['toUser_ID'];
						$content = $message_row['content'];
						$date = $message_row['date'];
						$fromUser_row = mysql_fetch_array(mysql_query("select * from user where ID = '$fromUser_ID'"));
				?>
						<div class="personIndex-messageBoard-message">
							<div class="personIndex-messageBoard-message-portrait">
								<div class="middle-portrait" title="<?php echo $fromUser_row['username'];?>">
								<?php 
									$fromUser_portrait = mysql_query("select * from user_portrait where user_ID = '$fromUser_ID'");
									if(mysql_num_rows($fromUser_portrait)){
								?>
									<a href="personIndex.php?ID=<?php echo $fromUser_ID?>"><img src="<?php echo mysql_fetch_array($fromUser_portrait)['img_path'];?>"></a>
								<?php		
									} else {
								?>
									<a href="personIndex.php?ID=<?php echo $fromUser_ID?>"><img src="portrait/default.png"></a>
								<?php }?>
								</div>
							</div>
							<div class="personIndex-messageBoard-message-info">
								<input class="message-ID none" value="<?php echo $message_row['ID']?>">
								<div class="floor"><?php echo $floor--;?>楼</div>
								<input class="requireLogin message-delete" userID="<?php echo $toUser_ID?>" type="button" value="删除">
								<div class="content"><?php echo $content;?></div>
								<div class="date"><?php echo $date." by ";?><a href="personIndex.php?ID=<?php echo $fromUser_ID?>"><?php echo $fromUser_row['username'];?></a></div>
							</div>
						</div>
			<?php 
					}
				}else{
			?>
				<div class="personIndex-messageBoard-messageLabel">还没有留言，赶快抢1楼吧</div>
		<?php 	}
			}
		}else{
			echo "invalidID";
		}
		?>
<?php
	}else{
		echo "noUser";
	}
?>