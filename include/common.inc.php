<?php
define('IN_MO',true); //系统入口

define('MO_ROOT',str_replace('\\','/',dirname(dirname(__FILE__)))); // 系统根目录

require_once(MO_ROOT . '/include/config.inc.php'); //包含系统配置文件

require_once(MO_ROOT . '/include/common.func.php'); //加载系统公用函数库

require_once(MO_ROOT . '/include/db.class.php'); //加载MYSQL数据库操作类文件

require_once(MO_ROOT . '/include/page.class.php'); //加载MYSQL数据库操作类文件

header('Content-type:text/html; charset=' . $charset . ''); //设置网站字符集

if(function_exists('date_default_timezone_set')){
	//如果该函数存在，就设置时区
	date_default_timezone_set($timezone); //设置默认时区
}

unset($HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS);  //清空php4.1一下的 post get取值方法

$_GET = stripSql($_GET); //过滤一些简单的sql关键字 

$_POST = stripSql($_POST);

$_COOKIE = stripSql($_COOKIE);

$magic_quotes_gpc = get_magic_quotes_gpc(); //获取系统是否自动转义GPC  get post cookie

if(!$magic_quotes_gpc){ 
	//如果没有开启
    if (!empty($_GET)){
		$_GET = myAddslashes($_GET); //使用自定义函数进行转义
	}
	
	if (!empty($_POST)){
		$_POST = myAddslashes($_POST);
	}
	
	$_COOKIE = myAddslashes($_COOKIE);
	
	$_REQUEST = myAddslashes($_REQUEST);
}
$db = new db($db_host, $db_user, $db_pass, $db_name);

$db_host = $db_user = $db_pass = $db_name = NULL;

error_reporting(E_ALL);

set_error_handler('myErrorHandler'); 
?>