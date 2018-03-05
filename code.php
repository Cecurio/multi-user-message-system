<?php
/**
 * @authors cecurio 
 * @date    2016-08-10 17:37:49
 * @version 1.0
 * 
 */
session_start();


//随机码的个数
$_rnd_code = 4;

//创建随机码
$_nmsg = '';
for ($i=0; $i < $_rnd_code; $i++) { 
	$_nmsg .= dechex(mt_rand(0,15));
}

//保存在session里
$_SESSION['code'] = $_nmsg;   

//设置图片的宽度和高度
$_width = 75;
$_height = 25;



//创建一个图片
$_img = imagecreatetruecolor($_width, $_height);

//创建白色
$_white = imagecolorallocate($_img, 255, 255, 255);

//填充
imagefill($_img, 0, 0, $_white);

$_flag =false;
if ($_flag) {
	//黑色
	$_black = imagecolorallocate($_img, 0, 0, 0);
	//边框
	imagerectangle($_img, 0, 0, $_width-1, $_height-1, $_black);
}


//随机画线条
for ($i=0; $i < 6; $i++) { 
	$_rnd_color = imagecolorallocate($_img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
	imageline($_img, mt_rand(0,$_width), mt_rand(0,$_height),  mt_rand(0,$_width), mt_rand(0,$_height), $_rnd_color);
}

//随机雪花
for ($i=0; $i < 100; $i++) { 
	$_rnd_color = imagecolorallocate($_img, mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
	imagestring($_img, 1, mt_rand(1,$_width), mt_rand(1,$_height), '*', $_rnd_color);	
}

//输出随机码
for ($i=0; $i <strlen($_SESSION['code']) ; $i++) { 
	$_rnd_color = imagecolorallocate($_img, mt_rand(0,100), mt_rand(0,150), mt_rand(0,200));
	imagestring($_img, 
				mt_rand(4,5), 
				$i*$_width/$_rnd_code + mt_rand(2,10),
		 		mt_rand(1,$_height/2),
		  		$_SESSION['code'][$i], 
		  		$_rnd_color);
}
//输出销毁
header('Content-Type:image/png');
imagepng($_img);
imagedestroy($_img);












?>

