<?php
/**
 * @authors cecurio 
 * @date    2016-08-09 23:03:32
*/


/**函数目录：
*  _runtime()是用来获取执行耗时的
*  _alert_back() 是用来js弹窗，页面后退
*  _check_code() 检验验证码是否正确
*  _mysql_string($_string) 智能转义字符
*  _location($_info,$_url) 页面跳转函数
*  _sha1_uniqid() 产生页面唯一标识码
*/

/*
 *_runtime()是用来获取执行耗时的
 * @access public 表示函数对外公开
 * @return float类型
 *
 */
function _runtime() {
	$_mtime = explode(' ', microtime());
	return $_mtime[0] + $_mtime[1];
}


/*
*表示JS弹窗
*/
function _alert_back($info){
	echo "<script type='text/javascript'>alert('".$info."');history.back();</script>";
	exit();
}

function _alert_close($info) {
	echo "<script type='text/javascript'>alert('".$info."');window.close();</script>";
	exit();
}

function _title($_string){
	if(mb_strlen($_string,'utf-8') > 14) {
		$_string = mb_substr($_string,0,14,'utf-8')."...";
	}
	return $_string;
}

/**
* 检查验证码是否正确
*/
function _check_code($_first_code,$_end_code) {
	if($_first_code != $_end_code) {
		_alert_back('验证码错误');
	}
}


/**
* 智能转义字符
*/
function _mysql_string($_string) {
	if(!GPC) {
		if(is_array($_string)) {
			foreach ($_string as $_key => $_value) {
				$_string[$_key] = mysql_escape_string($_value);
			}
		}else {
			$_string = mysql_escape_string($_string);
		}
	} 
	
	return $_string;
}

/**
*检查cookie是否伪造
*/
function _uniqid($_mysql_uniqid,$_cookie_uniqid) {
	if($_mysql_uniqid != $_cookie_uniqid) {
		_alert_back("唯一标识符异常！");
	}
}

function _sha1_uniqid() {
	return _mysql_string(sha1(uniqid(rand(),true)));
}

//页面跳转函数
function _location($_info,$_url) {
	if(!empty($_info)) {
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
	} else {
		header('location:'.$_url);
	}
}

//判断是否是登录状态
function _login_state() {
	if(isset($_COOKIE['username'])) {
		_alert_back('登录状态下无法进行本操作！');
	}
}


function _html($_string) {
	if(is_array($_string)) {
		foreach ($_string as $_key => $_value) {
			$_string[$_key] = htmlspecialchars($_value);
		}
	}else {
		$_string = htmlspecialchars($_string);
	}
	return $_string;
}
//分页参数的设置
//$_sql 语句，执行用来获取相关的记录的条数
//$_size ,用来设置每页显示的条数
function _page($_sql,$_size) {
	global $_pagesize,$_pagenum;
	global $_page,$_pageabsolute,$_num;
	if (isset($_GET['page'])) {
		$_page = $_GET['page'];
		if (empty($_page) || $_page < 0 || !is_numeric($_page)) {
			$_page = 1;
		} else {
			$_page = intval($_page);
		}
	} else {
		$_page = 1;
	}
	$_pagesize = $_size;
	//tg_user表中的记录数，也就是用户数量
	$_num = _num_rows(_query($_sql));
	if ($_num == 0) {
		$_pageabsolute = 1;
	} else {
		$_pageabsolute = ceil($_num / $_pagesize);
	}
	if ($_page > $_pageabsolute) {
		$_page = $_pageabsolute;
	}
	$_pagenum = ($_page-1)*$_pagesize;
}
//分页函数
//$_type 表示调用方式， 1 表示数字调用，2表示文本调用
function _paging($_type) {
	//$_page 表示第几页
	//$_pageabsolute 表示共多少页
	//$_num 表示用户个数
	global $_page,$_pageabsolute,$_num;
	if($_type == 1) {
		echo '<div id="page_num">';
		echo '<ul>';
			for($i=1;$i<=$_pageabsolute;$i++) { 
				if ($_page == $i) {
					echo '<li><a href="'.SCRIPT.'.php?page='.$i.'" class="selected">'.$i.'</a></li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php?page='.$i.'">'.$i.'</a></li>';
			 	}
			 } 
		echo '</ul>';
	    echo '</div>';
	}elseif($_type == 2) {
		echo '<div id="page_text">';
		echo '<ul>';
			echo '<li>'.$_page.'/'. $_pageabsolute.'页 |</li>';
			echo '<li>共有<strong>'.$_num.'</strong>条数据 |</li>';
				if($_page == 1 ) {
					echo '<li>首页 | </li>';
					echo '<li>上一页 | </li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
					echo '<li><a href="'.SCRIPT.'.php?page='.($_page - 1 ).'">上一页</a> | </li>';
				}
				if($_page == $_pageabsolute) {
					echo '<li>下一页 | </li>';
					echo '<li>尾页</li>';
				} else {
					echo '<li><a href="'.SCRIPT.'.php?page='.($_page + 1).'">下一页</a> | <li>';
					echo '<li><a href="'.SCRIPT.'.php?page='.$_pageabsolute.'">尾页</a><li>'; 
				}
		echo '</ul>';
		echo '</div>';
	}
}
//销毁session
function _session_destroy() {
	if (session_start()) {
		session_destroy();	
	}
}

//销毁cookie
function _unsetcookies() {
	setcookie('username','',time()-1);
	setcookie('uniqid','',time()-1);
	_session_destroy();
	_location(null,'index.php');
}


?>	