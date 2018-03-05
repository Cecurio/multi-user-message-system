<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'active');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';

if(!isset($_GET['active'])) {
    _alert_back('非法操作！');
}
if(isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok') {
    //$_GET['active'] 从哪里来？是多少？
    $_active = _mysql_string($_GET['active']);
    //如果当前激活码和数据库中的激活码一致，那么激活用户成功。
    if (_fetch_array("SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")) {
        //将数据库中的激活码设置为空，和未激活的加以区别
        _query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
        if(_affected_rows() == 1) {
            _close();
            _location('账户激活成功！','login.php');
        } else {
            _close();
            _location('账户激活失败！','register.php');
        }
    } else {
        _alert_back('非法操作！');
    }
}





?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---激活用户</title>
    <?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<?php
	require ROOT_PATH.'includes/header.inc.php';	
?>

<div id="active">
    <h2>激活账户</h2>
    <p>本页面是为了模拟您的邮件的功能，点击以下超级连接激活您的账户</p>
    <p><a href="active.php?action=ok&amp;active=<?php echo @$_GET['active']?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].
    $_SERVER["PHP_SELF"]?>active.php?action=ok&amp;active=<?php echo @$_GET['active']?></a></p>
    <!-- $_GET['active']由注册页面跳转时给出，即注册页面生成的激活码 -->
</div>




<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>