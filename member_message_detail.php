<?php
/**
* @authors cecurio 
* @date    2016-09-20 20:03:21
*/
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'member_message_detail');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
if (!isset($_COOKIE['username'])) {
	_alert_back('请先登录！');
}
// 删除短信
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
	$rows = _fetch_array("SELECT 
								tg_id 
								FROM tg_message 
								WHERE tg_id = '{$_GET['id']}' 
								LIMIT 1"
						);
	//判断短信是否存在
	if (!!$rows) {
		$_rows = _fetch_array("SELECT 
									tg_uniqid 
								FROM tg_user 
								WHERE tg_username='{$_COOKIE['username']}' 
							LIMIT 1");
		// 判断唯一标识符是否是伪造的
		if (!!$_rows) {
			//检查cookie是否伪造
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);

			//安全条件已经验证，下面开始删除
			$_delete_sql_sentence = "DELETE FROM tg_message WHERE tg_id = '{$_GET['id']}' LIMIT 1";
			_query($_delete_sql_sentence);
			if(_affected_rows() == 1) {
				_close();
				_location('短信删除成功！' , 'member_message.php');
			}else {
				_close();
				_alert_back("短信删除失败！");
			}
		}else {
			_alert_back('非法登录');
		}
	}else {
		_alert_back("此短信不存在！");
	}
		
}
// 查看短信详情的ID
if(isset($_GET['id'])) {
	$rows = _fetch_array("SELECT 
								tg_id,tg_state,tg_fromuser,tg_content,tg_date 
								FROM tg_message 
								WHERE tg_id = '{$_GET['id']}' 
								LIMIT 1"
						);
	if (!!$rows) {
		if($rows['tg_state'] == 0) {
			_query("UPDATE tg_message SET tg_state=1 WHERE tg_id='{$_GET['id']}' LIMIT 1");
		}
		if (!_affected_rows()) {
			_alert_back('异常');
		}
		$_html = array();
		$_html['id'] = $rows['tg_id'];
		$_html['state'] = 1;
		$_html['fromuser'] = $rows['tg_fromuser'];
		$_html['content'] = $rows['tg_content'];
		$_html['date'] = $rows['tg_date'];
		$_html = _html($_html);
	}else {
		_alert_back("此短信不存在！");
	}
} else {
	_alert_back("非法登录");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---短信查阅</title>
    <?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/member_message_detail.js"></script>
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
		<h2>短信详情</h2>
		<dl>
			<dd>发 信 人：<?php echo $_html['fromuser']?></dd>
			<dd>内    容：<?php echo $_html['content']?></dd>
			<dd>发信时间：<?php echo $_html['date']?></dd>
			<dd class="button">
				<input type="button" value="返回列表" id="return" />
				<input type="button" value="删除短信" id="delete" name="<?php echo $_html['id'];?>" />
			</dd>
		</dl>
	</div>
</div>

<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
