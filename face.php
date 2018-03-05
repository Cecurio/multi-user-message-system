<?php
/**
 * @authors cecurio 
 * @date    2016-08-10 02:38:40
 * @version 1.0
 * 
 */
define('IN_TG',true);
define('SCRIPT', 'face');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>多用户留言系统---头像选择</title>
	<?php
    	require ROOT_PATH.'includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/opener.js"></script>
</head>
<body>

<div id="face">
	<h3>选择头像</h3>
	<dl> 
		<?php foreach(range(1, 9) as $num) { ?> 
		<dd><img src="face/m0<?php echo $num;?>.gif" alt="face/m0<?php echo $num;?>.gif" title="头像<?php echo $num;?>" /></dd>
		<?php } ?>
		<?php foreach(range(10, 82) as $num) { ?> 
		<dd><img src="face/m<?php echo $num;?>.gif" alt="face/m<?php echo $num;?>.gif" title="头像<?php echo $num;?>"  /></dd>
		<?php } ?>

	</dl>

</div>
</body>
</html>