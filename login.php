<?php
/**
 * @authors cecurio 
 * @date    2016-08-20 09:03:47 
 */
session_start();
 //定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'login');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
//登录状态
_login_state();
//开始处理登录数据
if (isset($_GET['action']) && $_GET['action'] == 'login') {
	//防止恶意登录,检查验证码是否正确输入
	//$_SESSION['code']的赋值在code.php 文件中
	_check_code($_POST['code'] , $_SESSION['code']);
	//引入验证文件，专属的login的文件
	include ROOT_PATH.'includes/login.func.php';
	//接收数据
	$_clean = array();
	$_clean['username'] = _check_username($_POST['username'],2,20);
	$_clean['password'] = _check_password($_POST['password'],6);
	$_clean['savetime'] = _check_savetime($_POST['savetime']);
	// print_r($_clean);

	//到数据库验证
	$_identify = "SELECT 
					tg_username,tg_uniqid 
					FROM 
					tg_user 
					WHERE 
					tg_username='{$_clean['username']}' 
					AND tg_password='{$_clean['password']}' 
					AND tg_active='' LIMIT 1";

	if (!!$_rows = _fetch_array($_identify)) {
		_query("UPDATE tg_user SET 
									tg_last_time=NOW(),
									tg_last_ip = '{$_SERVER["REMOTE_ADDR"]}',
									tg_login_count = tg_login_count + 1
								WHERE tg_username = '{$_rows['tg_username']}'
								 ");
		_close();  //关闭数据库连接
		_session_destroy(); //关闭session
		//生成登录后的cookie,表示登录状态
		_setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clean['savetime']);
		_location(null,'member.php');
	} else {
		_close();  //关闭数据库连接
		_session_destroy(); //关闭session
		_location('用户名密码不正确或者该账户未被激活！','login.php');
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---登录</title>
    <?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
</head>
<body>
<?php
	require ROOT_PATH.'includes/header.inc.php';	
?>

<div id="login">
	<h2>登录</h2>
	<form method="post" name="login" action="login.php?action=login">
		<dl>
			<dt> </dt>
			<dd>用户名：<input type="text" name="username" class="text" /></dd>
			<dd>密  码 ：<input type="password" name="password" class="text" /></dd>
			<dd>
				保  留：<input type="radio" name="savetime" value="0" checked="checked" />不保留
					  <input type="radio" name="savetime" value="1" />一天
					  <input type="radio" name="savetime" value="2" />一周
					  <input type="radio" name="savetime" value="3" />一月
			</dd>
			<dd>
				验 证 码：<input type="text" name="code" class="text code" /><img src="code.php" id="code" />
			</dd>
			<dd>
				<input type="submit" class="button" value="登录">
				<input type="button" class="button location" id="location" value="注册">
			</dd>
		</dl>
	</form>
</div>




<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>