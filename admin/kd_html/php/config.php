<?php

//文件保存url(相对于网站的根目录)
$save_url='/123/xcmy/edit_file/';

//允许上传的文件大小(分别是图片、flash、视频音频、文件)
$max_size = array(
	'image'=>200000,
	'flash'=>20000000,
	'media'=>20000000,
	'file'=>20000000
);

//允许上传的文件扩展名(分别是图片、flash、视频音频、文件)
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);

?>
