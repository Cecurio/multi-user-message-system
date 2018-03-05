<?php
/**
* @authors cecurio 
* @date    2016-09-19 23:30:20
*/
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'member_friend');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';

if (!isset($_COOKIE['username'])) {
	_alert_back('请先登录！');
}

//
if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'check') {
	$_rows = _fetch_array("SELECT 
									tg_uniqid 
								FROM tg_user 
								WHERE tg_username='{$_COOKIE['username']}' 
							LIMIT 1");
	// 判断唯一标识符是否是伪造的
	if (!!$_rows) {
		_query("UPDATE tg_friend SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
		if(_affected_rows() == 1) {
			_close();
			_location('好友验证成功！' , 'member_friend.php');
		}else {
			_close();
			_alert_back("好友验证失败！");
		}
	} else {
		_alert_back('非法登录');
	}
	
}
//删除所有好友
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_POST['ids'])) {
	$_clean = array();
	$_clean['ids'] = _mysql_string(implode(',',$_POST['ids']));
	//echo $_clean['ids'];
	$_rows = _fetch_array("SELECT 
									tg_uniqid 
								FROM tg_user 
								WHERE tg_username='{$_COOKIE['username']}' 
							LIMIT 1");
	// 判断唯一标识符是否是伪造的
	if (!!$_rows) {
		//检查cookie是否伪造
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		_query("DELETE FROM tg_friend WHERE tg_id IN ({$_clean['ids']}) ");
		if(_affected_rows()) {
			_close();
			_location('好友删除成功！' , 'member_friend.php');
		}else {
			_close();
			_alert_back("好友删除失败！");
		}
	}else {
		_alert_back('非法登录');
	}
}

// 用于分页
global $_pagenum,$_pagesize;
_page("SELECT tg_id 
	FROM tg_friend 
	WHERE tg_touser='{$_COOKIE['username']}' 
	OR tg_fromuser='{$_COOKIE['username']}'",10);


$_result = _query("SELECT tg_id,tg_state,tg_touser,tg_fromuser,tg_content,tg_date 
									FROM tg_friend 
									WHERE tg_touser='{$_COOKIE['username']}'
									OR tg_fromuser='{$_COOKIE['username']}'
											ORDER BY tg_date DESC 
									LIMIT $_pagenum,$_pagesize");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>多用户留言系统---好友列表</title>
    <?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/member_message.js"></script>
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
		<h2>好友设置中心</h2>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>好友</th><th>验证消息</th><th>提交验证时间</th><th>状态</th><th>操作</th></tr>
			<?php 
				while ($_rows = _fetch_array_list($_result)) {
					$_html = array();
					$_html['id'] = $_rows['tg_id'];
					$_html['touser'] = $_rows['tg_touser'];
					$_html['fromuser'] = $_rows['tg_fromuser'];
					$_html['content'] = $_rows['tg_content'];
					$_html['date'] = $_rows['tg_date'];
					$_html['state'] = $_rows['tg_state'];
					$_html = _html($_html);
					if($_html['touser'] == $_COOKIE['username']) {
						// 别人添加你
						if($_html['state'] == 0) {
							$_html['state_html'] = 
							'<a href="member_friend.php?action=check&id='.$_html['id'].'" style="color:red">点此通过Ta的请求</a>';
						} else {
							$_html['state_html'] = '<span style="color:green;">通过</span>';
						}
						$_html['friend'] = $_html['fromuser'];
					} elseif($_html['fromuser'] == $_COOKIE['username']) {
						// 我添加别人
						if($_html['state'] == 0) {
							$_html['state_html'] = '<span style="color:blue;">对方未验证</span>';;
						} else {
							$_html['state_html'] = '<span style="color:green;">通过</span>';
						}
						$_html['friend'] = $_html['touser'];
					}
			?>
			<tr>
				<td><?php echo $_html['friend'];?></td>
				<td title="<?php echo $_html['content']?>">
					<?php echo _title($_html['content']);?>
				</td>
				<td><?php echo $_html['date'];?></td>
				<td><?php echo $_html['state_html'];?></td>
				<td><input type="checkbox" name="ids[]" value="<?php echo $_html['id'];?>" /></td>
			</tr>

			<?php 
			}
			_free_result($_result);
			?>
			<tr>
				<td colspan="5">
					<label for="all">全选：<input type="checkbox" name="chkall" id="all"></label>
					<input type="submit" value="批量删除">
				</td>
			</tr>
		</table>
		</form>
		<?php _paging(2);?>
	</div>
</div>

<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>