<html>
<head>
	<link rel="stylesheet" type="text/css" href="static/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/common.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/search.css"/>
	<meta charset="utf-8">
	<script type="text/javascript" src="static/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="static/js/header.js"></script>
	<script type="text/javascript" src="static/js/search.js"></script>
</head>
<body>
	<?php include('common/header.php') ?>
	<div class="main">
		<div class="search-panel">
			<?php
				error_reporting(0);
				$user_id = $_SESSION['user_id'];
				include("db.php");
				$content = $_POST['content'];
				$result_question = array();
				$result_user = array();
				$result_tag = array();
				$query1 = mysql_query("select * from question");
				while($row = mysql_fetch_array($query1)){
					if(strpos($row['content'], $content) !== false){
						$id = $row['ID'];
						$query_questioncnt = mysql_query("select * from question_cnt where question_ID = '$id'");
						if($questioncnt_row = mysql_fetch_array($query_questioncnt)){
							array_push($row, $questioncnt_row['answerCnt']);
							array_push($row, $questioncnt_row['careCnt']);
							array_push($row, $questioncnt_row['praiseCnt']);
							array_push($row, $questioncnt_row['degradeCnt']);
						}
						array_push($result_question, $row);
		        	}
		    	}
				$query2 = mysql_query("select * from question");
				while($row = mysql_fetch_array($query2)){
					for($i=0;$i<strlen($content) - 1;$i++){
						if(strpos($row['content'], substr($content, $i ,2)) !== false){
							$id = $row['ID'];
							$query_questioncnt = mysql_query("select * from question_cnt where question_ID = '$id'");
							if($questioncnt_row = mysql_fetch_array($query_questioncnt)){
								array_push($row, $questioncnt_row['answerCnt']);
								array_push($row, $questioncnt_row['careCnt']);
								array_push($row, $questioncnt_row['praiseCnt']);
								array_push($row, $questioncnt_row['degradeCnt']);
							}
							$existed = false;
							foreach ($result_question as $temp) {
								if($row == $temp)
									$existed = true;
							}
							if(!$existed)
								array_push($result_question, $row);
							break;
						}
					}
				}
				$query_user = mysql_query("select * from user");
				while($row = mysql_fetch_array($query_user)){
					if(strpos($row['username'],$content) !== false){
						array_push($result_user, $row);
	        		}
				}
				$query_tag = mysql_query("select * from tag");
				while($row = mysql_fetch_array($query_tag)){
					if(strpos($content,$row['name']) !== false){
						array_push($result_tag, $row);
	        		}
				}
			?>
			<div class="search-searchInfoLabel">有关"<?php echo $content ?>"我们为您搜索到了如下结果：</div>
			<div class="tabsPanel">
				<div class="tab currentTab" linkPanel =".search-questionPanel">
					问题
				</div>
				<div class="tab" linkPanel =".search-userPanel">
					用户
				</div>
				<div class="tab" linkPanel =".search-tagPanel">
					标签
				</div>
			</div>
			<div class="showPanel">
				<div class="search-questionPanel currentPanel">
					<div class="search-question-list">
					<?php 
						if(empty($result_question)){
							echo "没有找到任何问题";
						}else{
							foreach($result_question as $question){
								$question_ID = $question['ID'];
					?>
						<div class="search-question-listitem">
							<div class="search-question-listitem-answercntPanel">
								<div class="search-question-listitem-answerCnt"><?php echo $question[6] ?></div>
								<div class="search-question-listitem-answerLabel">回答</div>
							</div>
							<div class="search-question-listitem-carecntPanel">
								<div class="search-question-listitem-careCnt"><?php echo $question[7] ?></div>
								<div class="search-question-listitem-careLabel">关心</div>
							</div>
							<div class="search-question-listitem-praisecntPanel">
								<div class="search-question-listitem-praiseCnt"><?php echo $question[8] ?></div>
								<div class="search-question-listitem-praiseLabel">赞</div>
							</div>
							<div class="search-question-listitem-degradecntPanel">
								<div class="search-question-listitem-degradeCnt"><?php echo $question[9] ?></div>
								<div class="search-question-listitem-degradeLabel">贬</div>
							</div>
							<div class="search-question-listitem-title"> 
								<a href="questionInfo.php?ID=<?php echo $question_ID;?>"><?php echo $question['title'] ?> </a>
							</div>
							<div class="search-question-listitem-author">
								<div class="date"><?php echo $question['createDate'] ?>
								<?php 
									$author_ID = $question['author_ID'];
									$query_author = mysql_query("select * from user where ID = '$author_ID'");
									if($author_row = mysql_fetch_array($query_author)){
										echo "by ";
								?>
								<a href="userIndex.php?ID=<?php echo $author_ID; ?>"> <?php echo $author_row['username']; } ?> </a>
								</div>
							</div>
						</div>
						<?php
									}
								}
						?>
					</div>
				</div>
				<div class="search-userPanel"> 
					<?php
						if(empty($result_user)) {
							echo "没有找到任何用户";
						}else{
							foreach ($result_user as $user) {
					?>
					<div class="search-user">
						<div class="middle-portrait" title="<?php echo $user['username'];?>">
							<?php 
								$User_portrait = mysql_query("select * from user_portrait where user_ID = '".$user['ID']."'");
								if(mysql_num_rows($User_portrait)){
							?>
								<a href="personIndex.php?ID=<?php echo $user['ID']?>"><img src="<?php echo mysql_fetch_array($User_portrait)['img_path'];?>"></a>
							<?php		
								} else {
							?>
								<a href="personIndex.php?ID=<?php echo $user['ID']?>"><img src="portrait/default.png"></a>
							<?php }?>
						</div>
						<a href = "personIndex.php?ID=<?php echo $user['ID'];?>">
							<?php echo $user['username']?>
						</a>
					<div>
					<?php
							}
						}
					?>
				</div>
				<div class="search-tagPanel"> 
					<?php
						if(empty($result_tag)) {
							echo "没有找到任何标签";
						}else{
							foreach ($result_tag as $tag) {
					?>
					<a href="tagQuestions.php?ID=<?php echo $tag['ID'] ?>">
						<input type="button" class="tag" value= "<?php echo $tag['name']; ?>"> 
					</a>
					<?php
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php include('common/footer.php');?>
</body>
</html>