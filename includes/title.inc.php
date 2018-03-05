<?php
/**
 * @authors cecurio 
 * @date    2016-08-10 02:14:02
 * @version 1.0
 * 
 */

//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Denied!');
}
//防止非html页面调用
if (!defined('SCRIPT')) {
	exit('Script Error!');
}
?>
<link rel="shortcut icon"  href="favicon.ico">
<link rel="stylesheet" type="text/css" href="styles/1/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/1/<?php echo SCRIPT; ?>.css" />
