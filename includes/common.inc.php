<?php
/**
 * @authors cecurio 
 * @date    2016-08-08 22:53:24
 * @version 1.0
 * 
 */
//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Denied!');
}

header('Content-Type:text/html;charset=utf-8');

//转换成硬路径
define('ROOT_PATH', substr(dirname(__FILE__), 0,-8));
define('GPC',get_magic_quotes_gpc());

//拒绝低的PHP版本
if (PHP_VERSION < '4.1.0') {
	exit('Your PHP version is too low!');
}

//引入核心函数库,全部公开
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';

//页面开始加载的时间点
$_start_time = _runtime();

//与数据库操作有关的常量
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PSD','root');
define('DB_NAME','sk_guest');
//第一步：连接服务器
_connect();
//第二步：连接指定的数据库，设置字符集 
_select_db();
//设置字符集
_set_unicode();


// 短信提醒 
if(isset($_COOKIE['username'])) {
	$_message = _fetch_array("SELECT 
								COUNT(tg_id) 
							AS count 
					FROM tg_message 
			WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");
	//print_r($_message);
	if(empty($_message['count'])) {
		$_GLOBALS['message'] = '<strong class="noread"><a href="member_message.php">(0)</a></strong>';
	}else {
		$_GLOBALS['message'] = '<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
	}
}




?>	
