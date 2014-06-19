
<header>
	<div class="header-main">
		<div id="logo-Panel">
			<a href="index.php">
				<div id="logo-image"></div>	
			</a>
		</div>
		<nav>
			<a href="index.php?action=hotQuestions">全站热点</a>
			<a href="index.php?action=newQuestions">新鲜出炉</a>
		</nav>
		<?php 
			error_reporting(0);
			session_start();
			if(!isset($_SESSION['user_id'])){ 
		?>
			<div id="user-info">
				<a class="header-login" href="index.php?action=account">登录</a>
				<a href="index.php?action=account">注册</a>
			</div>
		<?php } else { ?>
				<div id="user-info">
				<div><?php echo $_SESSION['username'] ?></div>
				<div id="user-menu">
					<div class="user-item"><a href="personIndex.php?ID=<?php echo $_SESSION['user_id']; ?>">个人中心</a></div>
					<div class="user-item"><a href="editQuestion.php">提问</a></div>
					<div class="user-item"><a href="login.php?action=logout" id="logout">注销</a></div>
				</div>
			</div>
		<?php } ?>
		<div id="search">
	        <form method="post" action="search.php">
	            <input type="text" name="content" placeholder="搜索" method="post" id="search-text">
	            <input type="submit" value="go" id="search-submit">
	        </form>
	    </div>

	    <div class="clearfix"></div>
	</div>
    <div class="iframe-holder loginBox">
    	<div class="loginBox-panel">
    		<input type="button" class="iframe-close loginBox-close" value="关闭">
    		<div class="loginBox-label"></div>
    		<form class="info-form loginBox-form" method="post" action="" >
    		<div class="textline">
				<div class="textinput">
					<div class="username-logo"></div>
					<input class="inactive-input" id="loginBox-username" name="username" type="text" placeholder="用户名">
				</div>
			</div>
			<div class="loginBox-error" id="loginBox-username-error"></div>
			<div class="textline">
				<div class="textinput">
					<div class="password-logo"></div>
					<input class="inactive-input" id="loginBox-password" name="password" type="password" placeholder="密码">
				</div>
			</div>
			<div class="loginBox-error" id="loginBox-password-error"></div>
			<div class="loginBox-toRegister"><a href="index.php?action=account">没有账号?点击一步注册</a></div>
    		<div class="buttonline">
    			<div class="buttoninput"> 
    				<input class="loginBox-submit" type="button" name="submit" value="登录">
    			</div>
    		</div>
    		</form>
    	</div>
    </div>
</header>