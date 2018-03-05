<?php
/**
* @authors cecurio 
* @date    2016-09-04 20:33:58
*/
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'member');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否正常登录
if(isset($_COOKIE['username'])) {
	$rows = _fetch_array("SELECT 
								tg_username,tg_gender,tg_face,tg_email,tg_url,tg_qq,tg_reg_time,tg_level 
								FROM tg_user 
								WHERE tg_username = '{$_COOKIE['username']}' 
								LIMIT 1"
						);
	if($rows) {
		$_html =array();
		$_html['username'] = $rows['tg_username'];
		$_html['gender'] = $rows['tg_gender'];
		$_html['face'] = $rows['tg_face'];
		$_html['email'] = $rows['tg_email'];
		$_html['url'] = $rows['tg_url'];
		$_html['qq'] = $rows['tg_qq'];
		$_html['reg_time'] = $rows['tg_reg_time'];
		switch($rows['tg_level']) {
			case 0:
				$_html['level'] = '普通用户';
				break;
			case 1:
				$_html['level'] = '管理员';
				break;
			default:
				$_html['level'] = '系统出错了……';
				break;
		}
		$_html = _html($_html);
	}else {
		_alert_back("此用户不存在");
	}
}else {
	_alert_back("未登录账号，不能访问个人中心！");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---个人中心</title>
    <?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
</head>
<body>
<?php
	require ROOT_PATH.'includes/header.inc.php';	
?>

<div id="member">
<?php
	require ROOT_PATH.'includes/member.inc.php';
?>
	<div id="member_main">
		<h2>会员管理中心</h2>
		<dl>
			<dd>用 户 名：<?php echo $_html['username'];?></dd>
			<dd>性　　别：<?php echo $_html['gender'];?></dd>
			<dd>头　　像：<?php echo $_html['face'];?></dd>
			<dd>电子邮件：<?php echo $_html['email'];?></dd>
			<dd>主　　页：<?php echo $_html['url'];?></dd>
			<dd>Q 　 　Q：<?php echo $_html['qq'];?></dd>
			<dd>注册时间：<?php echo $_html['reg_time'];?></dd>
			<dd>身　　份：<?php echo $_html['level'];?></dd>
		</dl>
	</div>
</div>



<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>