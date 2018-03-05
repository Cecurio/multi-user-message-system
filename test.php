<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PSD', 'root');
define('DB_NAME', 'sk_guest');
$conn = mysql_connect(DB_HOST,DB_USER,DB_PSD) or die(mysql_error());
mysql_select_db(DB_NAME,$conn);
mysql_query("SET NAMES UTF8");

// mysql_query("INSERT INTO tg_friend (
// 											tg_touser,
// 											tg_fromuser,
// 											tg_content,
// 											tg_date
// 				                           ) VALUES (
// 											'单凯',
// 											'保罗·乔治',
// 											'亲，加一波好友呗，我是单凯',
// 											NOW()

// 				                           )");
if (mysql_affected_rows() == 1) {
	# code...
	
	echo '<script>alert("tianjaichjekdjkf");</script>';
}else {
	echo '<script>alert("fail");</script>';
}




mysql_close($conn);

?>