<?php
/**
* @authors cecurio 
* @date    2016-09-04 20:33:58
*/
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'member_modify');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
//判断提交的方式
if(isset($_GET['action']) && $_GET['action'] == 'modify') {
	//防止恶意注册,检查验证码是否正确输入
	_check_code($_POST['yzm'] , $_SESSION['code']);

	$_rows = _fetch_array("SELECT 
									tg_uniqid 
								FROM tg_user 
								WHERE tg_username='{$_COOKIE['username']}' 
							LIMIT 1");
	if(!!$_rows) {
		
		//检查cookie是否伪造
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);


		//引入验证文件
		include ROOT_PATH.'includes/check.func.php';
		//用数组接收,创建一个空数组，用来存放提交过来的合法数据
		$_clean = array();
		$_clean['password'] = _check_modify_password($_POST['password'],6);
		$_clean['gender'] = _check_gender($_POST['gender']);
		$_clean['face'] = _check_face($_POST['face']);	
		$_clean['email'] = _check_email($_POST['email'],6,40);
		$_clean['qq'] = _check_qq($_POST['qq']);
		$_clean['url'] = _check_url($_POST['url']);
		
		$_modify  = "UPDATE tg_user SET 
										tg_password='{$_clean['password']}',
										tg_gender='{$_clean['gender']}',
										tg_face='{$_clean['face']}',
										tg_email='{$_clean['email']}',
										tg_url='{$_clean['url']}',
										tg_qq='{$_clean['qq']}' 
									WHERE tg_username='{$_COOKIE['username']}'";
		_query($_modify);
	}
	 
	

	if (_affected_rows() == 1) {
		//关闭数据库
		_close();
		_session_destroy();
		//页面跳转，函数定义在global.func.php 中
		_location('恭喜你，修改成功！' , 'member.php');
	} else {
		_close();
		_session_destroy();
		_location('没有任何资料被修改！','member_modify.php');
	}
}

//判断是否正常登录
if(isset($_COOKIE['username'])) {
	$rows = _fetch_array("SELECT tg_username,tg_gender,tg_face,tg_email,tg_url,tg_qq FROM tg_user WHERE tg_username = '{$_COOKIE['username']}'");
	if($rows) {
		$_html =array();
		$_html['username'] = $rows['tg_username'];
		$_html['gender'] = $rows['tg_gender'];
		$_html['face'] = $rows['tg_face'];
		$_html['email'] = $rows['tg_email'];
		$_html['url'] = $rows['tg_url'];
		$_html['qq'] = $rows['tg_qq'];
		$_html = _html($_html);

		//修改性别
		if($_html['gender'] == '男') {
			$_html['gender_html'] = '<input type="radio" name="gender" value="男" checked="checked">男 <input type="radio" name="gender" value="女" >女';
		} elseif ($_html['gender'] == '女') {
			$_html['gender_html'] = '<input type="radio" name="gender" value="女" checked="checked">女 <input type="radio" name="gender" value="男" >男';
		}
		
		//修改头像
		$_html['face_html'] = '<select name="face">';
		foreach(range(1,9) as $_num) {
			$_html['face_html'] .= '<option value="face/m0'.$_num.'.gif">face/m0'.$_num.'.gif</option>';
		}
		foreach(range(10, 82) as $_num) {
			$_html['face_html'] .= '<option value="face/m'.$_num.'.gif">face/m'.$_num.'.gif</option>';
		}
		$_html['face_html'] .= '</select>';

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
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/member_modify.js"></script>
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
		<form method="post" name="modify" action="member_modify.php?action=modify">
			<dl>
				<dd>用 户 名：<?php echo $_html['username'];?></dd>
				<dd>密　　码：<input type="password" class="text" name="password" />(必填)</dd>
				<dd>性　　别：<?php echo $_html['gender_html'];?></dd>
				<dd>头　　像：<?php echo $_html['face_html'];?></dd>
				<dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $_html['email'];?>" /></dd>
				<dd>主　　页：<input type="text" class="text" name="url" value="<?php echo $_html['url'];?>" /></dd>
				<dd>Q 　 　Q：<input type="text" class="text" name="qq" value="<?php echo $_html['qq'];?>" /></dd>
				<dd>验 证 码：<input type="text" name="yzm" class="text yzm" /><img src="code.php" id="code" /></dd>
				<dd><input type="submit" class="submit" value="修改资料"></dd>
			</dl>
		</form>
	</div>
</div>



<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>