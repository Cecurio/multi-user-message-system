<?php
/**
 * @authors cecurio 
 * @date    2016-08-20 19:36:40 
*/
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'blog');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
//分页模块
global $_pagenum,$_pagesize;
_page("SELECT tg_id FROM tg_user",10);
//从数据库提取数据
//最近注册的要首先显示
$_result = _query("SELECT tg_id,tg_username,tg_gender,tg_face 
												FROM tg_user 
											ORDER BY tg_reg_time DESC 
									LIMIT $_pagenum,$_pagesize");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---博友</title>
    <?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php
	require ROOT_PATH.'includes/header.inc.php';	
?>

<div id="blog">
	<h2>blog</h2>
	<?php 
		while ($_rows = _fetch_array_list($_result)) {
			$_html =array();
			$_html['id'] = $_rows['tg_id'];
			$_html['username'] = $_rows['tg_username'];
			$_html['gender'] = $_rows['tg_gender'];
			$_html['face'] = $_rows['tg_face'];
			$_html = _html($_html);
	?>
	<dl>
		<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['gender']?>)</dd>
		<dt><img src="<?php echo $_html['face'];?>" alt="炎日" /></dt>
		<dd class="message">
			<a href="javascript:;" name="message" title="<?php echo $_html['id'] ;?>">发消息</a>
		</dd>
		<dd class="friend">
			<a href="javascript:;" name="friend" title="<?php echo $_html['id'] ;?>">加为好友</a>
		</dd>
		<dd class="guest">写留言</dd>
		<dd class="flower">给Ta送花</dd>
	</dl>
	<?php
		} 
		_free_result($_result);
		_paging(1);
	?>
	
</div>




<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

<!-- onclick="javascript:window.open('message.php','message','width=400,height=250')" -->