<?php
/**
 * @authors cecurio 
 * @date    2016-08-20 18:20:37
 * @version 1.0
 * 
 */
session_start();
define('IN_TG',true);
//引入公共文件，包括常量ROOT_PATH和GPC，引入了核心函数库global.func.php,计算页面开始加载时间，连接数据库
require dirname(__FILE__).'/includes/common.inc.php';
_unsetcookies();
?>

