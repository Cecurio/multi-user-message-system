<?php
//此文件包含mysql的操作流程，封装成函数


//防止恶意调用
if(!defined('IN_TG')) {
    exit('Access Denied!');
}

function _connect() {
    global $_conn;
    if (!$_conn = @mysql_connect(DB_HOST,DB_USER,DB_PSD)) {
		exit('数据库连接失败');
	}
}
//选择一款数据库
function _select_db() {
    global $_conn;
	if (!mysql_select_db(DB_NAME,$_conn)) {
		exit('找不到指定的数据库');
	}
}

//设置字符集
function _set_unicode() {
	if (!mysql_query('SET NAMES UTF8')) {
		exit('字符集错误');
	}
}

//执行数据库操作语句
//$_sql为MySQL语句
function _query($_sql) {
	if (!$_result = mysql_query($_sql)) {
		exit('SQL执行失败');
	}
	return $_result;
}

function _fetch_array($_sql) {
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

function _fetch_array_list($_result) {
	return mysql_fetch_array($_result,MYSQL_ASSOC);
}
function _num_rows($_result) {
	return mysql_num_rows($_result);
}
/**
 * _affected_row表示影响到的记录数
 */

function _affected_rows() {
	return mysql_affected_rows();
}

//注册新用户之前，检查是否用户名已经用过
function _is_repeat($_sql,$_info) {
	//如果结果集有数据，证明此用户名存在，那么不能完成注册
	if (_fetch_array($_sql)) {
		_alert_back($_info);
	}
}

function _free_result($_result) {
	mysql_free_result($_result);
}
//关闭数据库
function _close() {
	if (!mysql_close()) {
		exit('关闭异常');
	}
}

?>