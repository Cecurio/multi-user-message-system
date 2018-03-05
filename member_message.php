<?php
/**
* @authors cecurio 
* @date    2016-09-19 23:30:20
*/
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT', 'member_message');
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
if (!isset($_COOKIE['username'])) {
	_alert_back('请先登录！');
}
//删除所有
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
		_query("DELETE FROM tg_message WHERE tg_id IN ({$_clean['ids']}) ");
		if(_affected_rows()) {
			_close();
			_location('短信删除成功！' , 'member_message.php');
		}else {
			_close();
			_alert_back("短信删除失败！");
		}
	}else {
		_alert_back('非法登录');
	}
	exit();
}
global $_pagenum,$_pagesize;
_page("SELECT tg_id FROM tg_message WHERE tg_touser='{$_COOKIE['username']}'",10);
//从数据库提取数据
//最近注册的要首先显示
$_result = _query("SELECT tg_id,tg_state,tg_fromuser,tg_content,tg_date 
												FROM tg_message 
												WHERE tg_touser='{$_COOKIE['username']}'
											ORDER BY tg_date DESC 
									LIMIT $_pagenum,$_pagesize");





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
		<h2>短信中心</h2>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>发信人</th><th>信息内容</th><th>发信时间</th><th>状态</th><th>操作</th></tr>
			<?php 
				while ($_rows = _fetch_array_list($_result)) {
					$_html = array();
					$_html['id'] = $_rows['tg_id'];
					$_html['fromuser'] = $_rows['tg_fromuser'];
					$_html['content'] = $_rows['tg_content'];
					$_html['date'] = $_rows['tg_date'];
					$_html = _html($_html);
					if (empty($_rows['tg_state'])) {
						$_html['state'] = '<img src="images/read.gif" alt="未读" title="未读">';
						$_html['content_html'] = '<strong>'._title($_html['content']).'</strong>';
					}else {
						$_html['state'] = '<img src="images/noread.gif" alt="已读" title="已读">';
						$_html['content_html'] = _title($_html['content']);
					}
			?>
			<tr>
				<td><?php echo $_html['fromuser'];?></td>
				<td><a href="member_message_detail.php?id=<?php echo $_html['id']?>" title="<?php echo $_html['content']?>">
						<?php echo $_html['content_html'];?>
					</a>
				</td>
				<td><?php echo $_html['date'];?></td>
				<td><?php echo $_html['state'];?></td>
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