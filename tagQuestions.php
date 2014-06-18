<html>
<head>
	<link rel="stylesheet" type="text/css" href="static/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/common.css"/>
	<link rel="stylesheet" type="text/css" href="static/css/tagQuestions.css"/>
	<meta charset="utf-8">
	<script type="text/javascript" src="static/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="static/js/header.js"></script>
	<script type="text/javascript" src="static/js/tagQuestions.js"></script>
</head>
<body>
	<?php include('common/header.php') ?>
	<div class="main">
		<div class="tagQuestions-list">
			<?php
				$user_id = $_SESSION['user_id'];
				include("db.php");
				$tag_ID = $_GET['ID'];
				$tag_query = mysql_query("select * from tag where ID = '$tag_ID'");
				if(mysql_num_rows($tag_query)){
					$tag_row = mysql_fetch_array($tag_query);
					$tag_name = $tag_row['name'];
			?>
				<div class="tagQuestions-label">
					属于标签"<?php echo $tag_name?>"的问题有:
				</div>
			<?php
				}
				$query = mysql_query("select * from question_tag where tag_ID = '$tag_ID'");
				if(mysql_num_rows($query)){
					while($row = mysql_fetch_array($query)){
						$question_ID = $row['question_ID'];
						$query_question = mysql_query("select * from question where ID = '$question_ID'");
						if($question_row = mysql_fetch_array($query_question)){
							$question_cnt_row = mysql_fetch_array(mysql_query("select * from question_cnt where question_ID = '$question_ID'"));
			?>
				<div class="tagQuestions-listitem">
						<div class="tagQuestions-listitem-answercntPanel">
							<div class="tagQuestions-listitem-answerCnt"><?php echo $question_cnt_row['answerCnt'] ?></div>
							<div class="tagQuestions-listitem-answerLabel">回答</div>
						</div>
						<div class="tagQuestions-listitem-praisecntPanel">
							<div class="tagQuestions-listitem-praiseCnt"><?php echo $question_cnt_row['praiseCnt'] ?></div>
							<div class="tagQuestions-listitem-praiseLabel">赞</div>
						</div>
						<div class="tagQuestions-listitem-degradecntPanel">
							<div class="tagQuestions-listitem-degradeCnt"><?php echo $question_cnt_row['viewCnt'] ?></div>
							<div class="tagQuestions-listitem-degradeLabel">贬</div>
						</div>
						<div class="tagQuestions-listitem-title"> 
							<a href="questionInfo.php?ID=<?php echo $question_ID;?>"><?php echo $question_row['title'] ?> </a>
						</div>
						<div class="tagQuestions-listitem-author">
							<div class="date"><?php echo $question_row['createDate'] ?>
							<?php 
								$author_ID = $question_row['author_ID'];
								$query_author = mysql_query("select * from user where ID = '$author_ID'");
								if($author_row = mysql_fetch_array($query_author)){
									echo "by ";
							?>
							<a href="personIndex.php?ID=<?php echo $author_ID; ?>"> <?php echo $author_row['username']; } ?> </a>
							</div>
						</div>
					</div>
			<?php
			        	}
			    	}
			    }
			?>
		</div>
	</div>
	<?php include('common/footer.php');?>
</body>
</html>