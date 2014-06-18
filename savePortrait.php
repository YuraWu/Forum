<?php 
	header("Content-Type:text/html;charset=utf-8");
	session_start();
	$person_ID = $_POST['ID'];
	if(isset($_SESSION['user_id'])){
		$user_ID = $_SESSION['user_id'];
		// if ($_FILES["image"]["error"] > 0)
		//   {
		//   echo "Error: " . $_FILES["image"]["error"] . "<br />";
		//   }
		// else
		//   {
		//   echo "Upload: " . $_FILES["image"]["name"] . "<br />";
		//   echo "Type: " . $_FILES["image"]["type"] . "<br />";
		//   echo "Size: " . ($_FILES["image"]["size"] / 1024) . " Kb<br />";
		//   echo "Stored in: " . $_FILES["image"]["tmp_name"];
		//   }
		if($user_ID == $person_ID){
			if (($_FILES["image"]["type"] == "image/gif")
			|| ($_FILES["image"]["type"] == "image/jpeg")
			|| ($_FILES["image"]["type"] == "image/png")){
				include('db.php');
				$filepath = "portrait/".$person_ID.".png";
				if(is_uploaded_file($_FILES['image']['tmp_name'])){
					move_uploaded_file($_FILES['image']['tmp_name'],$filepath);
					$query = mysql_query("select * from user_portrait where user_ID = $person_ID");
					if(mysql_num_rows($query) == 0){
						mysql_query("insert into user_portrait values('$person_ID','$filepath')");
					}
					$home_url = "personIndex.php?ID=$person_ID";
					header('Location: '.$home_url);
				}
			}else{
				echo "文件格式有误,需要jpg/gif/png文件";
			}
		}else{
			echo "没有权限";
		}
	}else{
		echo "没有登录";
	}
?>
<a href="personIndex.php?ID=<?php echo $person_ID;?>">点击返回</a>