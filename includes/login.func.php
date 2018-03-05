<?php
/**
 * @authors cecurio 
 * @date    2016-08-20 10:29:45
 */


//防止恶意调用
if (!defined('IN_TG')) {
	
	exit('Access Denied!');
	
}

//检查_alert_back()函数是否存在
if (!function_exists('_alert_back')) {
	
	exit('_alert_back()函数不存在，请检查！');
	
}

//_mysql_string()函数是否存在
if (!function_exists('_mysql_string')) {
	
	exit('_mysql_string()函数不存在，请检查！');
	
}

function _setcookies($_username,$_uniqid,$_cookie_time) {
	switch($_cookie_time) 
	{
		case '0':  //浏览器进程，意思是浏览器关闭后cookie消失
			setcookie('username',$_username);
			setcookie('uniqid',$_uniqid);
			break;
		case '1':  //一天
			setcookie('username',$_username,time()+86400);
			setcookie('uniqid',$_uniqid,time()+86400);
			break;
		case '2':  //一周
			setcookie('username',$_username,time()+604800);
			setcookie('uniqid',$_uniqid,time()+604800);
			break;
		case '3':  //一月
			setcookie('username',$_username,time()+2592000);
			setcookie('uniqid',$_uniqid,time()+2592000);
			break;	
		default:
			break;
	}
}
function _check_username($_string,$_min_num=2,$_max_num=20){
	$_string = trim($_string);
	if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {
		
		_alert_back('用户名长度不能小于'.$_min_num.'位或者大于'.$_max_num.'位');
		
	}
	
	//去除限制敏感字符
	$_char_pattern = '/[<>\'\"\ \ ]/';
	
	if (preg_match($_char_pattern, $_string)) {
		
		_alert_back('用户名不得包含敏感字符！');
		
	}
	return _mysql_string($_string);
	
}

function _check_password($_string,$_min_num=6)
{
	//判断密码
	if (strlen($_string)<$_min_num) {
		_alert_back('密码不得少于'.$_min_num.'位');
	}
		
	return sha1($_string);
	
}

function _check_savetime($_string) {
    $_time = array('0','1','2','3');
    if(!in_array($_string,$_time)) {
        _alert_back('保留时间不在可选范围！');
    }

    return _mysql_string($_string);
}
?>

