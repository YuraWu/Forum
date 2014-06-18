
<html>
<head>
	<link rel="stylesheet" type="text/css" href="static/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/common.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/editQuestion.css"/>
	<meta charset="utf-8">
	<script type="text/javascript" src="static/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="static/js/header.js"></script>
	<script type="text/javascript" src="static/js/editQuestion.js"></script>
	<?php require("model.php");
		editor_require();
	?>
</head>
<body>
	<div class="iframe-holder" id="editQuestion-defineTag">
		<div class="editQuestion-defineTag-panel">
			<input class="iframe-close" id="editQuestion-defineTag-close"type="button" value="关闭"/>
			<form class="editQuestion-form">
				<div class="textline">
					<div class="textinput">
						<input class="inactive-input" id="editQuestion-defineTag-name" type="text" name="addTag-name" placeholder="标签名" size="23">
					</div>
				</div>
				<div class="error" id="tag-error"></div>
				<div class="buttonline">
					<div class="buttoninput">
						<input id="editQuestion-defineTag-submit" type="button" name="submit" value="添加" />
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php include('common/header.php') ?>
	<div class="main">
		<?php
			if(isset($_SESSION['user_id'])){
				$user_id = $_SESSION['user_id'];
			}else{
				$user_id = 0;
			}
		?>
		<div class="editQuestion-todayMyQuestion">
			<?php
				if(isset($_SESSION['user_id'])){
					$user_id = $_SESSION['user_id'];
					date_default_timezone_set('PRC');
					$today = date("Y-m-d",time());
					include('db.php');
					$user_point = mysql_query("select * from user_point where user_ID = '$user_id'");
					if(mysql_num_rows($user_point)){
						$user_point_row = mysql_fetch_array($user_point);
						$point = $user_point_row['point'];
						$question = mysql_query("select * from question where author_ID = '$user_id'");
						if(mysql_num_rows($question)){
							$question_today_cnt = 0;
							while($question_row = mysql_fetch_array($question)){
								if(strpos($question_row['createDate'], $today) !== false){
									$question_today_cnt++;
								}
							}
							$restQuestion = (int)($point / 10) + 1 - $question_today_cnt;
							echo "您今天已经提了".$question_today_cnt."个问题,还可以提出".$restQuestion."个问题";
						}else{
							echo "您还没有提出任何问题";
						}
					}
				}else{
					$user_id = 0;
				}
			?>
		</div>
		<input class="none" id="user-id" type="text" value="<?php echo $user_id;?>">
		<div id="editQuestion-panel">
			<form class="editQuestion-form" action="saveQuestion.php" method="post">
				<div class="textline">
					<input class="inactive-input" type="text" name="editQuestion-title" id="editQuestion-title" placeholder="请概括您的问题" size="76"/>
				</div>
				<script type='text/plain' name="editQuestion-content" id="myEditor" ></script>
				<script type="text/javascript">
				    UE.getEditor('myEditor')
				</script>
				<div id="editQuestion-tagPanel"></div>
				<div class="textline">
					<div class="textinput">
						<div class="point-logo"></div>
						<input type="text" name="point" class="editQuestion-point" placeholder="悬赏积分">
					</div>
				</div>
				<div class="buttonline">
					<div class="buttoninput">
						<input type="button" name="defineMyTag" class="editQuestion-defineMyTag" value="自定义标签" />
					</div>
				</div>
				<div id="editQuestion-myTagPanel"></div>
				<div class="buttonline">
					<div class="buttoninput">
						<input type="submit" name="submit" value="提问"/></div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php include('common/footer.php');?>
</body>
</html>