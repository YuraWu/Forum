<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="static/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/common.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/personIndex.css"/>
	<link rel="stylesheet" type="text/css" href="common/timeLine/component.css" />
	<script type="text/javascript" src="static/js/modernizr.custom.js"></script>
	<script type="text/javascript" src="static/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="static/js/header.js"></script>
	<script type="text/javascript" src="static/js/personIndex.js"></script>
</head>
<body>
	<?php include('common/header.php') ?>
	<?php
		include('db.php');
		if(isset($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
		}else{
			$user_id = 0;
		}
		$person_id = $_GET['ID'];
		$person_row = mysql_fetch_array(mysql_query("select * from user where ID = '$person_id'"));
		$person_info_row = mysql_fetch_array(mysql_query("select * from user_info where user_ID = '$person_id'"));
	?>
	<div class="iframe-holder uploadPortrait">
		<div class="uploadPortrait-panel">
			<input type="button" class="iframe-close uploadPortrait-close" value="关闭">
			<form class="uploadPortrait-form" action="savePortrait.php" method="post" enctype="multipart/form-data">
				<input class="none" type="text" name="ID" value="<?php echo $person_id;?>">
				<input type="button" value="选择图片" class="uploadPortrait-select">
				<input type="file" name="image" class="none uploadPortrait-source" accept="image/gif,image/jpeg,image/png">
				<div class="large-portrait">
					<img class="uploadPortrait-preview" src="portrait/default.png">
				</div>
				<input class="uploadPortrait-submit"type="submit" value="上传">
			</form>
		</div>
	</div>
	<div class="main">
		<input id="user-id" type="text" class="none" value="<?php echo $user_id;?>">
		<div class="personIndex-headPanel">
			<div class="large-portrait selectPortrait">
				<?php 
					$person_portrait = mysql_query("select * from user_portrait where user_ID = '$person_id'");
					if(mysql_num_rows($person_portrait)){
				?>
					<img src="<?php echo mysql_fetch_array($person_portrait)['img_path'];?>">
				<?php		
					} else {
				?>
					<img src="portrait/default.png">
				<?php }?>
			</div>
			<div class="personIndex-headPanel-info">
				<div class="personIndex-headPanel-info-username">
					<?php echo $person_row['username']?>
				</div>
				<div class="personIndex-headPanel-info-registerDate">
					A龄: 
					<?php 
						$today = date('Y-m-d',time());
						$day = explode(" ",$person_row['registerDate'])[0];
						$dYear = (int)explode("-",$today)[0] - (int)explode("-",$day)[0];
						$dMonth = (int)explode("-",$today)[1] - (int)explode("-",$day)[1];
						$dDay = (int)explode("-",$today)[2] - (int)explode("-",$day)[2];
						if($dYear > 1){
							echo $dYear."年";
						}elseif($dYear == 1){
							if($dMonth >= 0){
								echo $dYear."年";
							}else{
								echo ($dMonth+12)."个月";
							}
						}else{
							if($dMonth>1){
								echo $dMonth."个月";
							}elseif($dMonth==1){
								if($dDay>=0){
									echo $dMonth."个月";
								}else{
									echo ($dDay+30)."天";
								}
							}else{
								if($dDay > 0){
									echo $dDay."天";
								}else{
									echo "<1天";
								}
							}
						}
					?>
				</div>
				<div class="personIndex-headPanel-info-point">
					<?php 
						$person_point_row = mysql_fetch_array(mysql_query("select * from user_point where user_ID = '$person_id'"));
						echo "积分: ".$person_point_row['point'];
					?>
				</div>
			</div>
		</div>
		<div class="personIndex-mainPanel">
			<div class="tabsPanel">
				<div class="tab currentTab" linkPanel =".personIndex-infoPanel">
					个人信息
				</div>
				<div class="tab" linkPanel =".personIndex-trendsPanel">
					最新动态
				</div>
				<div class="tab" linkPanel =".personIndex-questionsPanel">
					提出的问题
				</div>
				<div class="tab" linkPanel =".personIndex-careQuestionsPanel">
					关心的问题
				</div>
				<div class="tab" linkPanel =".personIndex-messageBoard">
					留言板
				</div>
			</div>
			<div class="showPanel">
			<div class="personIndex-infoPanel currentPanel">
				<form class="userInfo-form">
					<div class="userInfo-form-label">
						基本资料
						<input class="requireLogin" userID="<?php echo $person_id;?>" id="saveInfo" type="button" value="保存">
						<input class="requireLogin" userID="<?php echo $person_id;?>" id="editInfo" type="button" value="编辑">
						<input class="none" id="giveUpEditInfo" type="button" value="还原">
					</div>
					<div>
						<div class="label">性别:</div>
						<input class="input-unEditable" type="text" id="sex" value="<?php echo $person_info_row['sex'];?>"><label class="error" id="sex-error"></label>
					</div>
					<div>
						<div class="label">生日:</div>
						<input class="input-unEditable" type="text" id="birthday" placeholder="xxxx-xx-xx" value="<?php echo $person_info_row['birthday'];?>"><label class="error" id="birthday-error"></label>
					</div>
					<div>
						<div class="label">星座:</div>
						<input class="input-unEditable" type="text" id="constellation" value="<?php echo $person_info_row['constellation'];?>">
					</div>
					<div>
						<div class="label">真实姓名:</div>
						<input class="input-unEditable" type="text" id="realname" value="<?php echo $person_info_row['realname'];?>"><label class="error" id="realname-error"></label>
					</div>
					<div>
						<div class="label">邮箱:</div>
						<input class="input-unEditable" type="text" id="email" value="<?php echo $person_info_row['email'];?>"><label class="error" id="email-error"></label>
					</div>
					<div>
						<div class="label">手机号:</div>
						<input class="input-unEditable" type="text" id="telephone" value="<?php echo $person_info_row['telephone'];?>"><label clas="error" id="telephone-error"></label>
					</div>
					<div>
						<div class="label">地址:</div>
						<input class="input-unEditable" type="text" id="address" value="<?php echo $person_info_row['address'];?>">
					</div>
					<div>
						<div class="label">职业:</div>
						<input class="input-unEditable" type="text" id="profession" value="<?php echo $person_info_row['profession'];?>">
					</div>
					<div>
						<div class="label">任职单位:</div>
						<input class="input-unEditable" type="text" id="workplace" value="<?php echo $person_info_row['workplace'];?>">
					</div>
				</form>
			</div>
			<div class="personIndex-trendsPanel">
				<div class="personIndex-trendsList">
						<?php 
							$question = mysql_query("select * from question where author_ID = '$person_id'");
							$answer = mysql_query("select * from answer where author_ID = '$person_id'");
							$result = array();
							if(mysql_num_rows($question)){
								while($question_row = mysql_fetch_array($question)){
									$result[$question_row['createDate']] = array("ask",$question_row['ID'],$question_row['title'],$question_row['content']);
								}
							}
							if(mysql_num_rows($answer)){
								while($answer_row = mysql_fetch_array($answer)){
									$answer_question_ID = $answer_row['question_ID'];
									$answer_question_row = mysql_fetch_array(mysql_query("select * from question where ID= '$answer_question_ID'"));
									$result[$answer_row['createDate']] = array("answer",$answer_question_row['ID'],$answer_question_row['title'],$answer_question_row['content'],$answer_row['content']);
								}
							}
							krsort($result);
							foreach ($result as $key => $trend) {
						?>
						<div class="personIndex-trend">
						<?php
							if($trend[0]=="ask"){
						?>
							<div class="personIndex-trend-type">提出了问题</div>
							<div class="personIndex-trend-question">
								<div class="title">
									<a href='questionInfo.php?ID=<?php echo $trend[1]?>'><?php echo $trend[2]?></a>
								</div>
								<div class="personIndex-trend-question-content">
									<?php echo $trend[3]?>
								</div>
							</div>
							<div class="personIndex-trend-date"><?php echo $key?></div>
						<?php
							}else if($trend[0]=="answer"){
						?>
							<div class="personIndex-trend-type">回答了问题</div>
							<div class="personIndex-trend-question">
								<div class="title">
									<a href='questionInfo.php?ID=<?php echo $trend[1]?>'><?php echo $trend[2]?></a>
								</div>
								<div class="personIndex-trend-question-content">
									<?php echo $trend[3]?>
								</div>
							</div>
							<div class="personIndex-trend-date"><?php echo $key?></div>
						<?php
							}
						?>
						</div>
						<?php
							}
						?>
				</div>
			</div>
			<div class="personIndex-questionsPanel">
				<div class="personIndex-questions-list">
					<?php
						$query = mysql_query("select * from question where author_ID = '$person_id'");
						if(mysql_num_rows($query)){
					?>
					<ul class="cbp_tmtimeline">
					<?php
						while($question_row = mysql_fetch_array($query)){
							$question_ID = $question_row['ID'];
							$question_cnt_row = mysql_fetch_array(mysql_query("select * from question_cnt where question_ID = '$question_ID'"));
					?>
						
						<li>
							<time class="cbp_tmtime" datetime="<?php echo $question_row['createDate']; ?>">
								<span><?php echo explode(" ",$question_row['createDate'])[0]?></span>
								<span><?php echo explode(" ",$question_row['createDate'])[1]?></span>
							</time>
							<div class="cbp_tmicon cbp_tmicon-phone"></div>
							<div class="cbp_tmlabel">
								<div class="title"><a href="questionInfo.php?ID=<?php echo $question_ID ?>"><?php echo $question_row['title']; ?></a></div>
								<div class="content"><?php echo $question_row['content']; ?></div>
								<div class="Cnt">
									<div class="answerCnt">回答 <?php echo $question_cnt_row['answerCnt']; ?></div>
									<div class="praiseCnt">赞 <?php echo $question_cnt_row['praiseCnt']; ?></div>
									<div class="degradeCnt">贬 <?php echo $question_cnt_row['degradeCnt']; ?></div>
									<div class="careCnt">关心 <?php echo $question_cnt_row['careCnt']; ?></div>
								</div>
								<div class="question-delete requirelogin" userID="<?php echo $question_row['author_ID']?>"></div>
								<input type="text" class="question-ID" value="<?php echo $question_ID ?>">
							</div>
						</li>
					<?php
				        }}else{
				        	echo "还没有提任何问题";
				    ?>
					</ul>
				    <?php
				        }
					?>
				</div>
			</div>
			<div class="personIndex-careQuestionsPanel">
				<div class="personIndex-careQuestions-list">
					<?php
						$query = mysql_query("select * from question where ID in (select question_ID from question_care where user_ID = '$person_id')");
						if(mysql_num_rows($query)){
						while($question_row = mysql_fetch_array($query)){
							$question_ID = $question_row['ID'];
							$question_cnt_row = mysql_fetch_array(mysql_query("select * from question_cnt where question_ID = '$question_ID'"));
					?>
						<div class="personIndex-careQuestions-listitem">
							<div class="personIndex-careQuestions-listitem-answercntPanel">
								<div class="personIndex-careQuestions-listitem-answerCnt"><?php echo $question_cnt_row['answerCnt'] ?></div>
								<div class="personIndex-careQuestions-listitem-answerLabel">回答</div>
							</div>
							<div class="personIndex-careQuestions-listitem-praisecntPanel">
								<div class="personIndex-careQuestions-listitem-praiseCnt"><?php echo $question_cnt_row['praiseCnt'] ?></div>
								<div class="personIndex-careQuestions-listitem-praiseLabel">赞</div>
							</div>
							<div class="personIndex-careQuestions-listitem-degradecntPanel">
								<div class="personIndex-careQuestions-listitem-degradeCnt"><?php echo $question_cnt_row['degradeCnt'] ?></div>
								<div class="personIndex-careQuestions-listitem-degradeLabel">贬</div>
							</div>
							<div class="personIndex-careQuestions-listitem-carecntPanel">
								<div class="personIndex-careQuestions-listitem-careCnt"><?php echo $question_cnt_row['careCnt'] ?></div>
								<div class="personIndex-careQuestions-listitem-careLabel">关心</div>
							</div>
							<div class="personIndex-careQuestions-listitem-title"> 
								<a href="questionInfo.php?ID=<?php echo $question_ID;?>"><?php echo $question_row['title'] ?> </a>
							</div>
							<div class="personIndex-careQuestions-listitem-author">
								<div class="date">
									<?php 
										$author_ID = $question_row['author_ID'];
										$author_row = mysql_fetch_array(mysql_query("select * from user where ID = '$author_ID'"));
										$author_name = $author_row['username'];
										echo $question_row['createDate']." by ";
									?>
									<a href="personIndex.php?ID=<?php echo $commenter_ID; ?>"><?php echo $author_name; ?></a>
								</div>
							</div>
						</div>
					<?php
				        }}else{
				        	echo "还没有关心任何问题";
				    ?>
				    <?php
				        }
					?>
				</div>
			</div>
			<div class="personIndex-messageBoard">
				<div class="personIndex-messageBoard-messageLabel">
					我来留言
				</div>
				<div class="personIndex-messageBoard-form">
					<textarea id="message-content"></textarea>
					<input type="button" id="message-submit" value="提交">
				</div>
				<?php
					$message_query = mysql_query("select * from message where toUser_ID = '$person_id' order by date desc");
				?>
				<div class="personIndex-messageBoard-messageList">
				<?php
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
				<?php
					}
				?>
				</div>
			</div>
			</div>
		</div>
	</div>
	<?php include('common/footer.php');?>
</body>
</html>