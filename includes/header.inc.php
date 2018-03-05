<?php

//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Denied!');
}


?>
<!-- 表头 -->
<div id = "header">
	<h1><a href="index.php">
		瓢城Web俱乐部多用户留言系统</a></h1>
	<ul>
		<li><a href="index.php">首页</a></li>
		<?php
		if(isset($_COOKIE['username'])) {
			echo '<li><a href="member.php">'.$_COOKIE['username'].'的个人中心</a>'.$_GLOBALS['message'].'</li>';
			echo "\n";
		} else {
			echo '<li><a href="register.php">注册</a></li>';
			echo "\n";
			echo "\t\t";
		    echo '<li><a href="login.php">登录</a></li>';
			echo "\n";			
		}
		?>
		<li><a href="blog.php">博友</a></li>
		<li>风格</li>
		<li>管理</li>
		<?php
		if(isset($_COOKIE['username'])) {
			echo '<li><a href="logout.php">退出</a></li>';
		}
		?>
	</ul>
</div>