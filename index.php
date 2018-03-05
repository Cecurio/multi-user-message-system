<?php
/**
 * Created by PhpStorm.
 * User: Cecurio
 * Date: 2016/8/6
 * Time: 22:58
 */
//定义个常量，用来授权调用includes里的文件
define('IN_TG',true);
define('SCRIPT', 'index');
//
require dirname(__FILE__).'/includes/common.inc.php';
   


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---首页</title>
    <link rel="stylesheet" type="text/css" href="styles/1/miaov_style.css" />
	<script type="text/javascript" src="js/miaov.js"></script>
    <?php
        require ROOT_PATH.'includes/title.inc.php';
    ?>
</head>

<body>
<?php
	require ROOT_PATH.'includes/header.inc.php';	
?>

 <!--帖子列表 -->
<!--<div id="list">
	<h2>帖子列表</h2>
</div>-->

<!-- 新进会员 -->
<!--<div id="user">
	<h2>新进会员</h2>
</div>-->

<!-- 最新图片 -->
<!--<div id="pics">
	<h2>最新图片</h2>
</div>-->
<div id="div1">
	<a href="http://www.miaov.com">JS课程</a>
	<a href="http://www.miaov.com/course_outline_1.html.php" class="red">教程</a>
	<a href="http://www.miaov.com">试听</a>
	<a href="http://www.miaov.com">精品</a>
	<a href="http://www.miaov.com" class="blue">妙味课堂</a>
	<a href="http://blog.miaov.com/722.html">SEO</a>
	<a href="http://www.miaov.com" class="red">特效</a>
	<a href="http://www.miaov.com/course.html.php" class="yellow">JavaScript</a>
	<a href="http://www.miaov.com/course_detail_1.html.php">miaov</a>
	<a href="http://www.miaov.com/course_detail_2.html.php" class="red">CSS</a>
	<a href="http://www.miaov.com/course_detail_3.html.php">求职</a>
	<a href="http://www.miaov.com/course_detail_2.html.php" class="blue">面试题</a>
	<a href="http://www.miaov.com/contact.html.php">继承</a>
	<a href="http://www.miaov.com/" class="red">妙味课堂</a>
	<a href="http://www.miaov.com/about.html.php" class="blue">OOP</a>
	<a href="http://www.miaov.com/work.html.php">XHTML</a>
	<a href="http://www.miaov.com/message.html.php" class="blue">setInterval</a>
	<a href="http://blog.miaov.com/">W3C</a>
	<a href="http://blog.miaov.com/716.html">石川</a>
	<a href="http://www.miaov.com/" class="yellow">妙味课堂</a>
	<a href="http://blog.miaov.com/676.html">blue</a>
</div>
<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
