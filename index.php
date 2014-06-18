<html>
<head>
	<link rel="stylesheet" type="text/css" href="common/scroll/perfect-scrollbar.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/index.css"/>
	<meta charset="utf-8">
	<script type="text/javascript" src="static/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="common/scroll/jquery.mousewheel.js"></script>
	<script src="common/scroll/perfect-scrollbar.js"></script>
	<script type="text/javascript" src="static/js/header.js"></script>
	<script type="text/javascript" src="static/js/index.js"></script>
	<script>
	$(function(){
		$(".showpanel").perfectScrollbar();
	});
	</script>
</head>
<body>
	<?php 
		if(isset($_GET['action'])){
			$action = $_GET['action'];
		}else{
			$action = "normal";
		}
	?>
	<header></header>
	<div class="main">
		<div>
			<form class="search-form" action="search.php" method="post">
				<input class="content" type="text" name="content" placeholder="搜一搜">
				<input class="submit" type="submit" name="submit" value="搜索">
			</form>
		</div>
		<div class="tabsPanel">
			<div class="tab<?php if($action == 'normal' || $action == 'hotQuestions') echo ' currentTab'?>" linkPanel=".index-hotQuestionsList">
				热门问题
			</div>
			<div class="tab<?php if($action == 'newQuestions') echo ' currentTab'?>" linkPanel=".index-newQuestionsList">
				最新问题
			</div>
			<div class="tab<?php if($action == 'account') echo ' currentTab'?>" linkPanel=".index-loginRegisterPanel">
				账号
			</div>
		</div>
		<div class="showpanel">
			<div class="index-hotQuestionsList<?php if($action == 'normal' || $action == 'hotQuestions') echo ' currentList'?>">
				<?php 
					error_reporting(0);
					include('db.php');
					$question_cnt = mysql_query("select * from question_cnt order by answerCnt desc");
					while($question_cnt_row = mysql_fetch_array($question_cnt)){
						$question_ID = $question_cnt_row['question_ID'];
						$question = mysql_query("select * from question where ID = '$question_ID'");
						if($question_row = mysql_fetch_array($question)){
							$author_ID = $question_row['author_ID'];
							$author_row = mysql_fetch_array(mysql_query("select * from user where ID = '$author_ID'"));
							$question_tag = mysql_query("select * from question_tag where question_ID = '$question_ID'");
				?>
				<div class='index-questionItem'>
					<div class='index-questionItem-title'>
						<a href='questionInfo.php?ID=<?php echo $question_ID;?>'>
							<?php echo $question_row['title'];?>
						</a>
					</div>
					<?php if(mysql_num_rows($question_tag)){ ?>
						<div class="index-questionItem-tag">
							<?php while($question_tag_row = mysql_fetch_array($question_tag)){ 
								$tag_ID = $question_tag_row['tag_ID'];
								$tag_row = mysql_fetch_array(mysql_query("select * from tag where ID = '$tag_ID'"));
							?>
								<a href="tagQuestions.php?ID=<?php echo $tag_ID ?>"><input type="button" class="tag" value= "<?php echo $tag_row['name']; ?>"> </a>
							<?php } ?>
						</div>
					<?php } ?>
					<div class='index-questionItem-date'>
						<?php echo $question_row['createDate']." by "?>
						<a href = "personIndex.php?ID=<?php echo $author_ID;?>">
							<?php echo $author_row['username']?>
						</a>
					</div>
					<div class='index-questionItem-content'>
						<?php echo $question_row['content'];?>
					</div>
					<div class='index-questionItem-evaluate'>
						<input type="button" value="回答 <?php echo $question_cnt_row['answerCnt']?>">
						<input type="button" value="赞 <?php echo $question_cnt_row['praiseCnt']?>">
						<input type="button" value="贬 <?php echo $question_cnt_row['degradeCnt']?>">
						<input type="button" value="关心 <?php echo $question_cnt_row['careCnt']?>">
					</div>
				</div>
				<?php
						}
					}
				?>
			</div>
			<div class="index-newQuestionsList<?php if($action == 'newQuestions') echo ' currentList'?>">
				<?php 
					$question = mysql_query("select * from question order by createDate desc");
					while($question_row = mysql_fetch_array($question)){
						$question_ID = $question_row['ID'];
						$author_ID = $question_row['author_ID'];
						$author_row = mysql_fetch_array(mysql_query("select * from user where ID = '$author_ID'"));
						$question_cnt = mysql_query("select * from question_cnt where question_ID = '$question_ID'");
						$question_tag = mysql_query("select * from question_tag where question_ID = '$question_ID'");
						if($question_cnt_row = mysql_fetch_array($question_cnt)){
							$question_cnt_row = mysql_fetch_array(mysql_query("select * from question_cnt where question_ID = '$question_ID'"));
				?>
				<div class='index-questionItem'>
					<div class='index-questionItem-title'>
						<a href='questionInfo.php?ID=<?php echo $question_ID;?>'>
							<?php echo $question_row['title'];?>
						</a>
					</div>
					<?php if(mysql_num_rows($question_tag)){ ?>
						<div class="index-questionItem-tag">
							<?php while($question_tag_row = mysql_fetch_array($question_tag)){ 
								$tag_ID = $question_tag_row['tag_ID'];
								$tag_row = mysql_fetch_array(mysql_query("select * from tag where ID = '$tag_ID'"));
							?>
								<a href="tagQuestions.php?ID=<?php echo $tag_ID ?>"><input type="button" class="tag" value= "<?php echo $tag_row['name']; ?>"> </a>
							<?php } ?>
						</div>
					<?php } ?>
					<div class='index-questionItem-date'>
						<?php echo $question_row['createDate']." by "?>
						<a href = "personIndex.php?ID=<?php echo $author_ID;?>">
							<?php echo $author_row['username']?>
						</a>
					</div>
					<div class='index-questionItem-content'>
						<?php echo $question_row['content'];?>
					</div>
					<div class='index-questionItem-evaluate'>
						<input type="button" value="回答 <?php echo $question_cnt_row['answerCnt']?>">
						<input type="button" value="赞 <?php echo $question_cnt_row['praiseCnt']?>">
						<input type="button" value="贬 <?php echo $question_cnt_row['degradeCnt']?>">
						<input type="button" value="关心 <?php echo $question_cnt_row['careCnt']?>">
					</div>
				</div>
				<?php
						}
					}
				?>
			</div>
			<div class="index-loginRegisterPanel<?php if($action == 'account') echo ' currentList'?>">
				<?php 
					session_start();
					if(isset($_SESSION['user_id'])){
				?>
					<div class="index-userPanel">
						欢迎您,<?php echo $_SESSION['username'];?><a href="personIndex.php?ID=<?php echo $_SESSION['user_id']?>">>>个人中心</a>
					</div>
				<?php
					} else {
				?>
				<form class="info-form loginForm" action="login.php" method="post">
					<div class="login-label"></div>
					<div class="textline">
						<div class="textinput">
							<div class="username-logo"></div>
							<input class="inactive-input" id="login-username" name="username" type="text" placeholder="用户名">
						</div>
						<div class="error<?php if($usernameUnexited){echo '_show';} ?>" id="login-username-error"></div>
					</div>
					<div class="textline">
						<div class="textinput">
							<div class="password-logo"></div>
							<input class="inactive-input" id="login-password" name="password" type="password" placeholder="密码">
						</div>
						<div class="error<?php if($passwordError){echo '_show';} ?>" id="login-password-error"></div>
					</div>
					<div class="buttonline">
						<div class="buttoninput">
							<input class="login-submit" type="submit" value="登录" name="submit"/>
						</div>
					</div>
				</form>
				<form class="info-form registerForm" action="register.php" method="post">
					<div class="register-label"></div>
					<div class="textline">
						<div class="textinput">
							<div class="username-logo"></div>
							<input class="inactive-input" id="register-username" name="username" type="text" placeholder="用户名">
						</div>
						<div class="error" id="register-username-error"></div>
					</div>
					<div class="textline">
						<div class="textinput">
							<div class="password-logo"></div>
							<input class="inactive-input" id="register-password" name="password" type="password" placeholder="密码">
						</div>
						<div class="error" id="register-password-error"></div>
					</div>
					<div class="textline">
						<div class="textinput">
							<div class="password-logo"></div>
							<input class="inactive-input" id="register-repassword" name="repassword" type="password" placeholder="确认密码">
						</div>
						<div class="error" id="register-repassword-error"></div>
					</div>
					<div class="buttonline">
						<div class="buttoninput">
							<input id="register-submit" type="submit" value="注册" name="submit">
						</div>
					</div>
				</form>
				<?php } ?>
			</div>
		</div>
	</div>
	<footer></footer>
</body>
</html>