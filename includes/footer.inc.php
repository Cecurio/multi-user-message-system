<?php

//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Denied!');
}
mysql_close();
?>
<div id="footer">
	<p>本程序执行耗时为：<?php echo round((_runtime() - $_start_time),4);?>秒</p>
	<p>版权所有 翻版必究</p>
</div>