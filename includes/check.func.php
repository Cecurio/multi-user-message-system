<?php
/**
 * @authors cecurio 
 * @date    2016-08-11 01:07:02
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

//判断页面提交的唯一标识符是否一致
function _check_uniqid($_first_uniqid,$_end_uniqid) {
	
	if((strlen($_first_uniqid) != 40) || ($_first_uniqid != $_end_uniqid)) {
		_alert_back('唯一标识符异常！');
	}
	return _mysql_string($_first_uniqid);
}

/**
 * 对用户名进行筛选处理
 */
function _check_username($_string,$_min_num=2,$_max_num=20){
	$_string = trim($_string);
	if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {
		_alert_back('用户名长度不能小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//去除限制敏感字符
	$_char_pattern = '/[<>\'\"\ ]/';
	if (preg_match($_char_pattern, $_string)) {	
		_alert_back('用户名不得包含敏感字符！');	
	}
	
	$_mg =array('李炎恢','胡心鹏','武器');
	$_mg_string = '';
	foreach ($_mg as  $value) {	
		$_mg_string .= '['.$value.']'.'\n';	
	}
	if (in_array($_string, $_mg)) {	
		_alert_back($_mg_string.'以上敏感用户名，不能使用！');
	}
	return _mysql_string($_string);
}

/*
*验证密码
*/
function _check_password($_first_pass,$_end_pass,$_min_num=6)
{
	//判断密码
	if (strlen($_first_pass)<$_min_num) {
		_alert_back('密码不得少于'.$_min_num.'位');
	}
	if ($_first_pass != $_end_pass) {	
		_alert_back('密码不一致');	
	}
	return sha1($_first_pass);
}

function _check_modify_password($_pass,$_min_num=6)
{
	//判断密码
	if(empty($_pass)) {
		_alert_back("密码是必填项!");
	}
	if (strlen($_pass)<$_min_num) {	
		_alert_back('密码不得少于'.$_min_num.'位');	
	}
	return sha1($_pass);
}

function _check_question($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {	
		_alert_back('密码提示不能小于'.$_min_num.'位或者大于'.$_max_num.'位');	
	}
	return _mysql_string($_string);
}


function _check_answer($_ques,$_answ,$_min_num,$_max_num) {
	$_answ = trim($_answ);
	if (mb_strlen($_answ,'utf-8')<$_min_num || mb_strlen($_answ,'utf-8')>$_max_num) {	
		_alert_back('密码回答不能小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	if($_ques == $_answ) {	
		_alert_back('提示和回答不能一致！');	
	}
	
	return sha1($_answ);
	
}

function _check_gender($_string) {
	return _mysql_string($_string);
}

function _check_face($_string) {
	return _mysql_string($_string);
}

//bnbbs@163.com.net.cn

/**
*param string $_string
*
*
*
*/

function _check_email($_string,$_min_num,$_max_num) {
	
	
	
		
	if(!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
		
		_alert_back('邮件格式不正确');
		
	}
		
	

	if(strlen($_string) < $_min_num || strlen($_string) > $_max_num) {
		_alert_back('邮件格式不合法！');
	}
	
	return $_string;
	
}


function _check_qq($_string) {
	
	if(empty($_string)) {
		
		return null;
		
	}
	else {
		
		if(!preg_match('/^[1-9]{1}[0-9]{4,9}$/',$_string)) {
			
			_alert_back('QQ号码不正确');
			
		}
		
	}
	
	return $_string;
	
}

/*
*网址验证
*
*
*/
function _check_url($_string) {
	if (empty($_string) || $_string == 'http://') {
		return null;
	} else {
		if(!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)) {
			_alert_back('网址不正确');
		}
	}

	return _mysql_string($_string);
}

function _check_content($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	
	if (mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num) {
		
		_alert_back('发信内容不能小于'.$_min_num.'位或者大于'.$_max_num.'位');
		
	}
	return $_string;
}
?>