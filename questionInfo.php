<html>
<head>
	<link rel="stylesheet" type="text/css" href="static/css/base.css">
	<link rel="stylesheet" type="text/css" href="static/css/common.css">
	<link rel="stylesheet" type="text/css" href="static/css/questionInfo.css">
	<meta charset="utf-8">
	<script type="text/javascript" src="static/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="static/js/header.js"></script>
	<script type="text/javascript" src="static/js/questionInfo.js"></script>
	<?php require("model.php");
		editor_require();
	?>
</head>
<body>
	<?php include('common/header.php') ?>
	<div class="main">
		<?php
			$id = $_GET['ID'];
			if(isset($_SESSION['user_id'])){
				$user_id = $_SESSION['user_id'];
				include("db.php");
				date_default_timezone_set('PRC');
				$startDate = date('Y-m-d H:i:s',strtotime("-1 hours"));
				$nowDate = date('Y-m-d H:i:s',time());
				$endDate = date('Y-m-d H:i:s',strtotime("+1 hours"));
				$evaluate_query = mysql_query("select * from question_view where question_ID = '$id' and user_ID = '$user_id' and Date >= '$startDate' and Date <= '$endDate'");
				if(mysql_num_rows($evaluate_query) == 0){
					mysql_query("insert into question_view values('$id','$user_id','$nowDate')");
					$question_cnt_row = mysql_fetch_array(mysql_query("select * from question_cnt where question_ID = '$id'"));
					$question_cnt_view = $question_cnt_row['viewCnt'] + 1;
					mysql_query("update question_cnt set viewCnt = '$question_cnt_view' where question_ID = '$id'");
				}
			}else{
				$user_id = 0;
			}
		?>
			<input class="none" id="question-ID" type="text" value="<?php echo $id;?>">
			<input class="none" id="user-id" type="text" value="<?php echo $user_id;?>">
		<?php
			$question = mysql_query("select * from question where ID = '$id'");
			if($question_row = mysql_fetch_array($question)){
				$question_author_ID = $question_row['author_ID'];
				$question_author = mysql_fetch_array(mysql_query("select * from user where ID = '$question_author_ID'"));
				$question_author_name = $question_author['username'];
		?>
		<div class="questionInfo-panel">
			<div class="questionInfo-title">
				<div class="title"><?php echo $question_row['title']; ?></div>
				<div class="date">
					<?php echo $question_row['createDate']." by "; ?>
					<a href="personIndex.php?ID=<?php echo $question_author_ID; ?>"> <?php echo $question_author_name;?> </a>
				</div>
			</div>
		<?php
				$question_tags = mysql_query("select * from question_tag where question_ID = '$id'");
				if($question_tags){
		?>
				<div class="questionInfo-tagspanel">
		<?php
					while($question_tags_row = mysql_fetch_array($question_tags)){
						$tag_ID = $question_tags_row['tag_ID'];
						$tag = mysql_query("select * from tag where ID = '$tag_ID'");
						if($tag_row = mysql_fetch_array($tag)){
		?>
					<a href="tagQuestions.php?ID=<?php echo $tag_row['ID']; ?>" >
						<input type="button" class="tag" value= "<?php echo $tag_row['name']; ?>"> 
					</a>
		<?php
						}
					}
				}
		?>
				</div>
			<div class="questionInfo-content">
				<?php echo $question_row['content']; ?>
			</div>
			<div class="questionInfo-evaluate">
				<?php 
					$question_cnt = mysql_query("select * from question_cnt where question_ID = '$id'");
					$question_cnt_row = mysql_fetch_array($question_cnt); 
					$question_evaluate = mysql_query("select * from question_evaluate where user_ID = '$user_id' and question_ID = '$id'");
					$question_care = mysql_query("select * from question_care where user_ID = '$user_id' and question_ID = '$id'");
					if(!mysql_num_rows($question_evaluate)){
				?>
				<div class="questionInfo-evaluate-praise">
					<div class="questionInfo-evaluate-praiseLabel">赞</div>
					<div class="questionInfo-evaluate-praiseCnt"><?php echo $question_cnt_row['praiseCnt'] ?></div>
				</div>
				<div class="questionInfo-evaluate-degrade">
					<div class="questionInfo-evaluate-degradeLabel">贬</div>
					<div class="questionInfo-evaluate-degradeCnt"><?php echo $question_cnt_row['degradeCnt'] ?></div>
				</div>
				<?php 
					} else {
						$question_evaluate_row = mysql_fetch_array($question_evaluate);
						if($question_evaluate_row['evaluateType'] == 'praise'){
				?>
				<div class="questionInfo-evaluate-praised">
					<div class="questionInfo-evaluate-praiseLabel">已赞</div>
					<div class="questionInfo-evaluate-praiseCnt"><?php echo $question_cnt_row['praiseCnt'] ?></div>
				</div>
				<div class="questionInfo-evaluate-nodegrade">
					<div class="questionInfo-evaluate-degradeLabel">贬</div>
					<div class="questionInfo-evaluate-degradeCnt"><?php echo $question_cnt_row['degradeCnt'] ?></div>
				</div>
				<?php
						} else {
				?>
						<div class="questionInfo-evaluate-nopraise">
							<div class="questionInfo-evaluate-praiseLabel">赞</div>
							<div class="questionInfo-evaluate-praiseCnt"><?php echo $question_cnt_row['praiseCnt'] ?></div>
						</div>
						<div class="questionInfo-evaluate-degraded">
							<div class="questionInfo-evaluate-degradeLabel">已贬</div>
							<div class="questionInfo-evaluate-degradeCnt"><?php echo $question_cnt_row['degradeCnt'] ?></div>
						</div>
				<?php 
						}
					}
					if(mysql_num_rows($question_care)){
				?>
					<div class="questionInfo-cared">
						<div class="questionInfo-careLabel">已关心</div>
						<div class="questionInfo-careCnt"><?php echo $question_cnt_row['careCnt'] ?></div>
					</div>
				<?php
					}else{
				?>
					<div class="questionInfo-care">
						<div class="questionInfo-careLabel">关心</div>
						<div class="questionInfo-careCnt"><?php echo $question_cnt_row['careCnt'] ?></div>
					</div>
				<?php
					}
				?>
			</div>
			<div class="questionInfo-point">
				悬赏积分:<?php echo $question_row['point'];?>
			</div>
		</div>
			<?php 
				if($question_cnt_row['satisfiedAnswerCnt']){
			?>
				<div class="questionInfo-satisfiedAnswerList">
					<div class="questionInfo-satisfiedAnswerLabel">满意回答 <?php echo $question_cnt_row['satisfiedAnswerCnt'];?></div>
				<?php
					$answer1 = mysql_query("select * from answer where question_ID = '$id'");
					if(mysql_num_rows($answer1)){
					while($answer_row = mysql_fetch_array($answer1)){ 
						$answer_author_ID = $answer_row['author_ID'];
						$answer_author = mysql_fetch_array(mysql_query("select * from user where ID = '$answer_author_ID'"));
						$answer_author_name = $answer_author['username'];
						$answer_ID = $answer_row['ID'];
						$answer_cnt = mysql_query("select * from answer_cnt where answer_ID = '$answer_ID'");
						$answer_cnt_row = mysql_fetch_array($answer_cnt);
						if($answer_cnt_row['beSatisfied']){ 
				?>
							<div class="questionInfo-satisfiedAnswer">
								<input type="text" class="answer-ID none" value="<?php echo $answer_ID;?>">
								<div class="questionInfo-satisfiedAnswer-content"><?php echo $answer_row['content']; ?></div>
								<div class="questionInfo-answer-delete requireLogin" userID="<?php echo $answer_author_ID;?>"></div>
								<div class="date">
									<?php echo $answer_row['createDate']." by ";?>
									<a href="personIndex.php?ID=<?php echo $answer_author_ID; ?>"> <?php echo $answer_author_name;?> </a>
								</div>
								<div class="buttonGroup">
									<input class="questionInfo-comment-showbutton" type="button" value="评论 <?php echo $answer_cnt_row['commentCnt'] ?>">
									<input class="questionInfo-comment-hidebutton none" type="button" value="收起评论">
									<?php
										$answer_evaluate = mysql_query("select * from answer_evaluate where answer_ID = '$answer_ID' and user_ID = '$user_id'");
										if(mysql_num_rows($answer_evaluate)){
											$answer_evaluate_row = mysql_fetch_array($answer_evaluate);
											if($answer_evaluate_row['evaluateType'] == 'praise'){
									?>
										<input class="questionInfo-answer-praised" type="button" value="已赞 <?php echo $answer_cnt_row['praiseCnt'] ?>">
										<input class="questionInfo-answer-nodegrade" type="button" value="贬 <?php echo $answer_cnt_row['degradeCnt'] ?>">
									<?php
											}else if($answer_evaluate_row['evaluateType'] == 'degrade'){
									?>
										<input class="questionInfo-answer-nopraise" type="button" value="赞 <?php echo $answer_cnt_row['praiseCnt'] ?>">
										<input class="questionInfo-answer-degraded" type="button" value="已贬 <?php echo $answer_cnt_row['degradeCnt'] ?>">
									<?php
											}
										}else{
									?>
									<input class="questionInfo-answer-praise" type="button" value="赞 <?php echo $answer_cnt_row['praiseCnt'] ?>">
									<input class="questionInfo-answer-degrade" type="button" value="贬 <?php echo $answer_cnt_row['degradeCnt'] ?>">
									<?php
										}
									?>
									<input class="questionInfo-answer-delete requireLogin" type="button" userID="<?php echo $question_author_ID?>" value="删除">
								</div>
								<div class="questionInfo-commentPanel none">
									<div class="questionInfo-commentList">
										<?php 
											$answer_comment = mysql_query("select * from answer_comment where answer_ID = '$answer_ID'");
											if(!mysql_num_rows($answer_comment)){
										?>
											<div class="questionInfo-noComment">本回答暂无评论</div>
										<?php
											}else{
												while($answer_comment_row = mysql_fetch_array($answer_comment)) {
										?>
										<div class="questionInfo-comment">
											<div class="questionInfo-commentContent"><?php echo $answer_comment_row['content'];?> </div>
											<div class="date">
											<?php 
												$commenter_ID = $answer_comment_row['author_ID'];
												$commenter = mysql_fetch_array(mysql_query("select * from user where ID = '$commenter_ID' "));
												$commenter_name = $commenter['username'];
												echo $answer_comment_row['createDate']." by ";
											?>
											<a href="personIndex.php?ID=<?php echo $commenter_ID; ?>"><?php echo $commenter_name; ?></a>
											<input type="button" class="comment-delete requirelogin" userID="<?php echo $commenter_ID;?>" value="删除评论">
											<input type="text" class="comment-id none" value="<?php echo $answer_comment_row['ID']?>" >
											</div>
										</div>
										<?php
												}
											}
										?>
									</div>
									<div class="questionInfo-myComment">
										<input class="questionInfo-myComment-showbutton" type="button" value="我来评论">
										<input class="questionInfo-myComment-hidebutton none" type="button" value="取消评论">
										<div class="questionInfo-myCommentArea none">
											<textarea type="text" id="myComment-text"></textarea>
											<div class="questionInfo-myCommentSubmit">
												<input type="button" name="submit" class="myComment-submit" value="评论">
											</div>
										</div>
									</div>
								</div>
							</div>
			<?php 		}
					}
					}
			?>
				</div>
			<?php
				}
			?>
			<div class="questionInfo-normalAnswerList">
				<div class="questionInfo-normalAnswerLabel">其他回答 <?php echo $question_cnt_row['normalAnswerCnt'];?></div>
				<?php
					$answer2 = mysql_query("select * from answer where question_ID = '$id'");
					if(mysql_num_rows($answer2)){
					while($answer_row = mysql_fetch_array($answer2)){ 
						$answer_author_ID = $answer_row['author_ID'];
						$answer_author = mysql_fetch_array(mysql_query("select * from user where ID = '$answer_author_ID'"));
						$answer_author_name = $answer_author['username'];
						$answer_ID = $answer_row['ID'];
						$answer_cnt = mysql_query("select * from answer_cnt where answer_ID = '$answer_ID'");
						$answer_cnt_row = mysql_fetch_array($answer_cnt);
						if(!$answer_cnt_row['beSatisfied']){ 
				?>
							<div class="questionInfo-normalAnswer">
								<input type="text" class="answer-ID none" value="<?php echo $answer_ID;?>">
								<div class="questionInfo-normalAnswer-content"><?php echo $answer_row['content']; ?></div>
								<div class="date">
									<?php echo $answer_row['createDate']." by "?>
									<a href="personIndex.php?ID=<?php echo $answer_author_ID; ?>"> <?php echo $answer_author_name;?> </a>
								</div>
								<div class="buttonGroup">
									<input class="questionInfo-comment-showbutton" type="button" value="评论 <?php echo $answer_cnt_row['commentCnt'] ?>">
									<input class="questionInfo-comment-hidebutton none" type="button" value="收起评论">
									<?php
										$answer_evaluate = mysql_query("select * from answer_evaluate where answer_ID = '$answer_ID' and user_ID = '$user_id'");
										if(mysql_num_rows($answer_evaluate)){
											$answer_evaluate_row = mysql_fetch_array($answer_evaluate);
											if($answer_evaluate_row['evaluateType'] == 'praise'){
									?>
										<input class="questionInfo-answer-praised" type="button" value="已赞 <?php echo $answer_cnt_row['praiseCnt'] ?>">
										<input class="questionInfo-answer-nodegrade" type="button" value="贬 <?php echo $answer_cnt_row['degradeCnt'] ?>">
									<?php
											}else if($answer_evaluate_row['evaluateType'] == 'degrade'){
									?>
										<input class="questionInfo-answer-nopraise" type="button" value="赞 <?php echo $answer_cnt_row['praiseCnt'] ?>">
										<input class="questionInfo-answer-degraded" type="button" value="已贬 <?php echo $answer_cnt_row['degradeCnt'] ?>">
									<?php
											}
										}else{
									?>
									<input class="questionInfo-answer-praise" type="button" value="赞 <?php echo $answer_cnt_row['praiseCnt'] ?>">
									<input class="questionInfo-answer-degrade" type="button" value="贬 <?php echo $answer_cnt_row['degradeCnt'] ?>">
									<?php
										}
									?>
									<input class="questionInfo-answer-delete requireLogin" type="button" userID="<?php echo $question_author_ID?>" value="删除">
									<input class="questionInfo-answer-setSatisfied requireLogin" userID="<?php echo $question_author_ID?>" type="button" value="满意">
								</div>
								<div class="questionInfo-commentPanel">
									<div class="questionInfo-commentList">
										<?php 
											$answer_comment = mysql_query("select * from answer_comment where answer_ID = '$answer_ID'");
											if(!mysql_num_rows($answer_comment)){
										?>
											<div class="questionInfo-noComment">本回答暂无评论</div>
										<?php
											}else{
												while($answer_comment_row = mysql_fetch_array($answer_comment)) {
										?>
										<div class="questionInfo-comment">
											<div class="questionInfo-commentContent"><?php echo $answer_comment_row['content'];?> </div>
											<div class="date">
											<?php 
												$commenter_ID = $answer_comment_row['author_ID'];
												$commenter = mysql_fetch_array(mysql_query("select * from user where ID = '$commenter_ID' "));
												$commenter_name = $commenter['username'];
												echo $answer_comment_row['createDate']." by ";
											?>
												<a href="personIndex.php?ID=<?php echo $commenter_ID; ?>">
												<?php
														echo $commenter_name;
												?>
												</a>
												<input type="button" class="comment-delete requirelogin" userID="<?php echo $commenter_ID;?>" value="删除评论">
												<input type="text" class="comment-id none" value="<?php echo $answer_comment_row['ID'];?>" >
											</div>
										</div>
										<?php
												}
											}
										?>
									</div>
									<div class="questionInfo-myComment">
										<input class="questionInfo-myComment-showbutton" type="button" value="我来评论">
										<input class="questionInfo-myComment-hidebutton none" type="button" value="取消评论">
										<div class="questionInfo-myCommentArea none">
											<textarea type="text" id="myComment-text"></textarea>
											<div class="questionInfo-myCommentSubmit">
												<input type="button" name="submit" class="myComment-submit" value="评论">
											</div>
										</div>
									</div>
								</div>
							</div>
			<?php 		}
					}
				}
			?>
			</div>
			<div class="questionInfo-myAnswer-panel">
				<form class="info-form" id="questionInfo-myAnswer-form">
					<div class="questionInfo-myCommentLabel">我来回答</div>
					<script type='text/plain' name="answer-content" id="myEditor" ></script>
					<script type="text/javascript">
					    UE.getEditor('myEditor')
					</script>
					<input class="none" type="test" name="question_ID" value="<?php echo $id;?>">
					<div class="buttonline">
						<div class="buttoninput">
							<input id="answer-submit" type="button" name="submit" value="提交">
						</div>
					</div>
				</form>
			</div>
		<?php
			} 
		?>
	</div>
	<?php include('common/footer.php');?>
</body>
</html>