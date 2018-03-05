<?php
/**
* @authors cecurio 
* @date    2016-09-13 20:55:37
*/
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'friend');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录
if (!isset($_COOKIE['username'])) {
	_alert_close('请先登录！');
}
// 添加好友
if (isset($_GET['action']) && $_GET['action'] == 'add') {
	//检查验证码是否正确输入
	_check_code($_POST['yzm'] , $_SESSION['code']);
	
	if(!!$_rows = _fetch_array("SELECT 
									tg_uniqid 
									FROM tg_user 
									WHERE tg_username='{$_COOKIE['username']}' 
									LIMIT 1")) {
		//检查cookie是否伪造
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);

		include ROOT_PATH.'includes/check.func.php';

		$_clean = array();
		$_clean['touser'] = $_POST['touser'];
		$_clean['fromuser'] = $_COOKIE['username'];
		$_clean['content'] = _check_content($_POST['content'],10,200);
		$_clean = _mysql_string($_clean);

		if ($_clean['touser'] == $_clean['fromuser']) {
			_alert_close("不能添加自己");
		}
		// 验证好友是否已经添加
		$_rows1 = _fetch_array("SELECT tg_id 
							FROM 
							  tg_friend
							WHERE 
								(tg_touser='{$_clean['touser']}' AND tg_fromuser='{$_clean['fromuser']}')
								OR (tg_touser='{$_clean['fromuser']}' AND tg_fromuser='{$_clean['touser']}')
							");
		if(!!$_rows1) {
			_alert_close("你们已经是好友，或者好友验证已经发送");
		}else {
			//print_r($_clean);
			_query("INSERT INTO tg_friend (
											tg_touser,
											tg_fromuser,
											tg_content,
											tg_date
				                           ) VALUES (
											'{$_clean['touser']}',
											'{$_clean['fromuser']}',
											'{$_clean['content']}',
											NOW()

				                           )");

		}
		
		if (_affected_rows() == 1) {
			//关闭
			_close(); 
			_session_destroy();
			_alert_close("添加好友成功，等待验证");
		} else {
			_close();
			_session_destroy();
			_alert_back("添加好友失败");
		}

		exit();


	}
}
//获取数据
if (isset($_GET['id'])) {
	$rows = _fetch_array("SELECT 
							tg_username 
						FROM tg_user 
							WHERE tg_id = '{$_GET['id']}' 
						LIMIT 1");
	if(!!$rows){
		$_html = array();
		$_html['touser'] = $rows['tg_username'];
		$_html = _html($_html);
	}else {
		_alert_close("此用户不存在！");
	}
}else {
	_alert_close("非法操作！");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---添加好友</title>
    <?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/message.js"></script>
</head>
<body>

<div id="message">
	<h3>添加好友</h3>
	<form method="post" action="?action=add">
		<input type="hidden" name="touser" value="<?php echo $_html['touser'];?>">
		<dl>
			<dd>
				<input type="text" readonly="readonly" value="To: <?php echo $_html['touser']?>" class="text">
			</dd>
			<dd><textarea name="content">亲,加一波好友呗,我是<?php echo $_COOKIE['username']?></textarea></dd>
			<dd>
				验 证 码：<input type="text" name="yzm" class="text yzm" /><img src="code.php" id="code" />
				<input type="submit" class="submit" value="添加好友">
			</dd>
		</dl>
	</form>
</div>


</body>
</html>