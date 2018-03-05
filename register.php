<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'register');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否为登录状态
//如果已经登录，则不能访问本页面
_login_state();
//判断是否提交了
if (isset($_GET['action']) && $_GET['action'] == "register") {
	//防止恶意注册,检查验证码是否正确输入
	 _check_code($_POST['yzm'] , $_SESSION['code']);
	//引入验证文件
	include ROOT_PATH.'includes/check.func.php';
	//用数组接收,创建一个空数组，用来存放提交过来的合法数据
	$_clean = array();
	//唯一标识符的一个作用是防止恶意注册和伪装表单跨站攻击
	//这个存放入数据库的唯一标识符还有另外一个特点：就是登录时的cookie注册
	$_clean['uniqid'] = _check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
	//active也是一个唯一标识符，用来刚注册用户进行激活处理，方可登录
	$_clean['active'] = _sha1_uniqid();
	$_clean['username'] = _check_username($_POST['username'],2,20);
	$_clean['password'] = _check_password($_POST['password'],$_POST['notpassword'],6);
	$_clean['question'] = _check_question($_POST['question'],2,20);
	$_clean['answer'] = _check_answer($_POST['question'],$_POST['answer'],2,20);
	$_clean['gender'] = _check_gender($_POST['gender']);
	$_clean['face'] = _check_face($_POST['face']);	
	$_clean['email'] = _check_email($_POST['email'],6,40);
	$_clean['qq'] = _check_qq($_POST['qq']);
	$_clean['url'] = _check_url($_POST['url']);

	//在新增之前，要判断用户名是否重复
	$_ziduan_exist = "SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}' LIMIT 1";
	_is_repeat($_ziduan_exist , '对不起，此用户已被注册');

	//新增用户 在双引号里，直接放变量是可以的，比如$_username,但如果是数组，就必须加上{} ，比如 {$_clean['username']}
	$add = "INSERT INTO tg_user (
											tg_uniqid,
											tg_active,
											tg_username,
											tg_password,
											tg_question,
											tg_answer,
											tg_email,
											tg_qq,
											tg_url,
											tg_gender,
											tg_face,
											tg_reg_time,
											tg_last_time,
											tg_last_ip
											) 

								VALUES (
											'{$_clean['uniqid']}',
											'{$_clean['active']}',
											'{$_clean['username']}',
											'{$_clean['password']}',
											'{$_clean['question']}',
											'{$_clean['answer']}',
											'{$_clean['email']}',
											'{$_clean['qq']}',
											'{$_clean['url']}',
											'{$_clean['gender']}',
											'{$_clean['face']}',
											NOW(),
											NOW(),
											'{$_SERVER["REMOTE_ADDR"]}'
											)";
	_query($add);
	if (_affected_rows() == 1) {
		//关闭
		_close(); 
		_session_destroy();
		//页面跳转，函数定义在global.func.php 中
		_location('恭喜你，注册成功！' , 'active.php?active='.$_clean['active']);
	} else {
		_close();
		_session_destroy();
		_location('很遗憾，注册失败！','register.php');
	}
	
	
} else {  
	//如果没有提交，则执行下面的语句
	$_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
}



?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---注册</title>
    <?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
	<script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<?php
	require ROOT_PATH.'includes/header.inc.php';	
?>

<div id="register">
	<h2>会员注册</h2>
	<form method="post" name="register" action="register.php?action=register">
		<input type="hidden" name="uniqid" value="<?php echo $_uniqid;?>" />
		<dl>
			<dt>请认真填写信息</dt>
			<dd>用 户 名：<input type="text" name="username" class="text" /> (*必填，至少两位)</dd>
			<dd>密  &nbsp;  码：<input type="password" name="password" class="text" /> (*必填，至少六位)</dd>
			<dd>确认密码：<input type="password" name="notpassword" class="text" /> (*必填，同上)</dd>
			<dd>密码提示：<input type="text" name="question" class="text" /> (*必填，至少两位)</dd>
			<dd>密码回答：<input type="text" name="answer" class="text" /> (*必填，至少两位)</dd>
			<dd>性  &nbsp;  别：<input type="radio" name="gender" value="男" checked="checked" />男 <input type="radio" name="gender" value="女" />女</dd>
			<dd class="face"><input type="hidden" name="face" value="face/m01.gif"  /><img src="face/m01.gif" alt="头像选择" id="faceimg" /></dd>
			<dd>电子邮件：<input type="text" name="email" class="text" /> (*必填,用于激活账户)</dd>
			<dd>   &nbsp;&nbsp;Q  Q  ：<input type="text" name="qq" class="text" /></dd>
			<dd>主页地址：<input type="text" name="url" class="text" value="http://" /></dd>
			<dd>验 证 码：<input type="text" name="yzm" class="text yzm" /><img src="code.php" id="code" /></dd>
			<dd><input type="submit" class="submit" value="注册"></dd>
		</dl>
	</form>
</div>




<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>