<?php
if(!defined('IN_MO')){
	exit('Access Denied');
}

function replaceKey($key,$text){
	$keys = explode(' ', $key);
	foreach($keys as $v){
		if(preg_match('/'.$v.'/iSU', $text)){
			$text = str_replace($v, '<font color="#f6699">'.$v.'</font>', $text);
		}
	}
	return $text;
}

/* 搜索获取纯文本 */
function stripSearch($str){
	$str = strip_tags($str);
	$str = str_replace('&nbsp','',$str);
	$str = str_replace(' ','',$str);
	return $str;
}


//获取客服端IP
function getip() {
	$IP = getenv('REMOTE_ADDR');
	/*
	getenv() 功能是获取环境变量的值 格式: string getenv(string varname)
	getenv('REMOTE_ADDR');等价于 : $_SERVER['REMOTE_ADDR'];
	*/
	$IP_ = getenv('HTTP_X_FORWARDED_FOR');
	if (($IP_ != "") && ($IP_ != "unknown"))
		$IP = $IP_;
	return $IP;
}

//获得GD库版本
function getGdVersion() {
	$ver = gd_info();
	$ver = $ver['GD Version'];
	return $ver;
}

/*
 * 转换HTML标签
 */
function html($str){
	if(!is_array($str)){
		$str = str_replace('  ', '&nbsp;', $str);
		$str = str_replace('<', '&lt', $str);
		$str = str_replace('>', '&gt', $str);
		$str = str_replace("\"", '&quot;', $str);
		$str = str_replace("'", '&rsquo;', $str);
		$str = str_replace(chr(10), '<br />', $str);
		return $str;
	}else{
		return array_map("html",$str);
	}
}

/**
 * 将实体<br>转换为\n
 */
function rehtml($str){
	$str = str_replace('<br />',"\n",$str);
	$str = str_replace('<br>',"\n",$str);
	$str = str_replace('&quot;', "\"", $str);
	$str = str_replace('&rsquo;', "'", $str);
	$str = str_replace('&nbsp;'," ",$str);
	$str = str_replace('&lt','<',$str);
	$str = str_replace('&gt','>',$str);
	return $str;
}



/**
 * 显示错误
 */
function msg($str1='',$str2=''){
	global $db;
	if($db->link_id){
		$db->close();
	}
	if($str1!=''){
		$str1='alert("'.$str1.'");';
	}
	if($str2==''){
		$str2='history.back();';
	}
	$html='<script>'.$str1.$str2.'</script>';
	exit ($html);
}
/**
 * 获取前一页网址
 */
function previous() {
	if (isset($_SERVER['HTTP_REFERER'])){
		$url = $_SERVER['HTTP_REFERER'];
		return $url;
	}
}

/**
 * 记录系统错误
 */
function myErrorHandler($errno,$errstr,$errfile,$errline){
	if(MY_ERROR_TIPS){
		$errfile = str_replace('\\','/',$errfile); //兼容系统路径格式
		$errfile = str_replace(MO_ROOT,'root',$errfile); //为了安全把错误信息中的完整路径替换掉
		echo '<div style="color:#ff0000;font:12px;">出错啦！';
		echo '<br>出错文件：' . $errfile;
		echo '<br>出错行数：' . $errline;
		echo '<br>错误信息：' . $errstr;
		echo '<br>错误级别：' . $errno . '<br><div>';
	}else{
		echo 'PHP Error!';
	}
	exit();
}

/**
 * 为字符串或数组元素添加反斜杠
 */
function myAddslashes($str){
	if(!is_array($str)){
		//如果传进来不不是数组
		$str = addslashes($str); //那么进行转义
		return $str;
	}else{
		return array_map("myAddslashes",$str);
	}
}


/**
 *  过滤SQL关键字函数
 */
function stripSql($str){
	$sqlkey = array(	 //SQL过滤关键字
		'/\s+select\s+/i',
		'/\s+delete\s+/i',
		'/\s+update\s+/i',
		'/\s+or\s+/i',
		'/\s+union\s+/i',
		'/\s+outfile\s+/'
	);
	$replace = array(  //和上面数组内容对应
		'&nbsp;select&nbsp;',
		'&nbsp;delete&nbsp;',
		'&nbsp;update&nbsp;',
		'&nbsp;or&nbsp;',
		'&nbsp;union&nbsp;',
		'&nbsp;outfile&nbsp;'
	);
	if(!is_array($str)){
		//如果不是数组直接替换
		$str = preg_replace($sqlkey,$replace,$str); 
		return $str;
	}else{
		return array_map("stripSql",$str);
	}
}


/**
 * 字符串截取
 */
function getstr($String, $Length,$act = true) {
	if (mb_strwidth($String, 'UTF8') <= $Length) {
		return $String;
	} else {
		$I = 0;
		$len_word = 0;
		while ($len_word < $Length) {
			$StringTMP = substr($String, $I, 1);
			if (ord($StringTMP) >= 224) {
				$StringTMP = substr($String, $I, 3);
				$I = $I +3;
				$len_word = $len_word +2;
			}
			elseif (ord($StringTMP) >= 192) {
				$StringTMP = substr($String, $I, 2);
				$I = $I +2;
				$len_word = $len_word +2;
			} else {
				$I = $I +1;
				$len_word = $len_word +1;
			}
			$StringLast[] = $StringTMP;
		}
		/* raywang edit it for dirk for (es/index.php)*/
		if (is_array($StringLast) && !empty ($StringLast)) {
			$StringLast = implode("", $StringLast);
			if($act){
				$StringLast .= "...";
			}
		}
		return $StringLast;
	}
}

//检查后台登录
function checklogin(){
	session_cache_limiter("private, must-revalidate");
	session_start();
	if (!isset($_SESSION['pyadmin'])||$_SESSION['pyadmin']==''){
		msg('未登录或登录已超时','location="../default.php"');
	}
}
//检查其他页面登录
function chklogin(){
	session_cache_limiter("private, must-revalidate");
	session_start();
	if (!isset($_SESSION['pyadmin'])||$_SESSION['pyadmin']==''){
		msg('未登录或登录已超时','location="default.php"');
	}
}
//检查登录页
function checkdefault(){
	session_cache_limiter("private, must-revalidate");
	session_start();
	if (isset($_SESSION['pyadmin'])&&$_SESSION['pyadmin']!=''){
		msg('','location="system.php"');
	}
}

//检查数字
function checknum($pid){
	if (!is_array($pid)){
  		return preg_match("/^[0-9]+$/",$pid);
	}else{
		$str=true;
		foreach ($pid as $v){
			if (!checknum($v)){
				$str=false;
				break;
			}
		}
		return $str;
	}
}

//删除文件
function delfile($path){
	if($path!=''){
		$path=MO_ROOT.'/'.$path;
		if (file_exists($path)){
			unlink($path);
		}
	}
}

//实现类惰性加载
function __autoload($filename){
	if(!empty($filename)){
		$classpath = MO_ROOT .'/lib/'.$filename.'.class.php';
		require_once($classpath);
	}
}

/**
 *按字段的关键字(|隔开的)组装成sql模糊搜索
 *$field为字段 例如： title
 *$keyword为用|隔开的关键字 例如： 好用|不锈钢
 *返回字符串 例如： title like "%好用%" or title like "%不锈钢%" 
 */
function zusql($field,$keyword){
	$str='';
	if ($field!=''&&$keyword!=''){
		$arr=explode('|',$keyword);
		$a=1;
		foreach($arr as $v){
			if ($a==1){
				$str=$field.' like "%'.$v.'%"';
			}else{
				$str.=' or '.$field.' like "%'.$v.'%"';
			}
			$a++;
		}
	}
	return $str;
}

//传入不带字母的图片地址，得到带字母的图片地址
function getimgj($str,$zm){
	$strr='';
	if ($str!=''){
		$pos=strrpos($str,'/');
		$strr=substr($str,0,$pos+1).$zm.substr($str,$pos+1);
	}
	return $strr;
}

//传入带字母的图片地址，得到带其他字母($zm为空时就是不带字母)的图片地址
function getimgh($str,$zm){
	$strr='';
	if ($str!=''){
		$pos=strrpos($str,'/');
		$strr=substr($str,0,$pos+1).$zm.substr($str,$pos+2);
	}
	return $strr;
}

//获取当前页url
function getpageurl(){
    $pageURL = 'http://';
    if (isset($_SERVER['HTTPS'])&&(strtolower($_SERVER['HTTPS']) != 'off')){
        $pageURL = "https://";
    }
    if (isset($_SERVER["SERVER_PORT"])&&$_SERVER["SERVER_PORT"] != "80"){
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }else{
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

//检查浮点数
function checkfloat($pid){
	if (!is_array($pid)){
  		return preg_match("/^[0-9]+(\.[0-9]{1,3})?$/",$pid);
	}else{
		$str=true;
		foreach ($pid as $v){
			if (!checkfloat($v)){
				$str=false;
				break;
			}
		}
		return $str;
	}
}

//检查字母+数字-
function checkstring($pid){
	if (!is_array($pid)){
  		return preg_match("/^(\w)+$/",$pid);
	}else{
		$str=true;
		foreach ($pid as $v){
			if (!checkstring($v)){
				$str=false;
				break;
			}
		}
		return $str;
	}
}

//检查日期
function checkd($pid){
	if (!is_array($pid)){
  		return preg_match("/^[0-9]{4}(\-)[0-9]{1,2}(\-)[0-9]{1,2}$/",$pid);
	}else{
		$str=true;
		foreach ($pid as $v){
			if (!checkd($v)){
				$str=false;
				break;
			}
		}
		return $str;
	}
}

//检查日期时间
function checkt($pid){
	if (!is_array($pid)){
  		return preg_match("/^[0-9]{4}(\-)[0-9]{1,2}(\-)[0-9]{1,2} [0-9]{1,2}(\:)[0-9]{1,2}(\:)[0-9]{1,2}$/",$pid);
	}else{
		$str=true;
		foreach ($pid as $v){
			if (!checkd($v)){
				$str=false;
				break;
			}
		}
		return $str;
	}
}

//会员状态
function person_z($zt){
	$arr=array('','未审核','未通过','已通过','已屏蔽');
	$str='';
	if($zt==1){
		$str='<font class="blue">'.$arr[1].'</font>';
	}elseif ($zt==2){
		$str='<font class="hui">'.$arr[2].'</font>';
	}elseif ($zt==3){
		$str='<font class="green">'.$arr[3].'</font>';
	}elseif ($zt==4){
		$str='<font class="red">'.$arr[4].'</font>';
	}
	return $str;
}

//地址转换(用于伪静态)
function zurl($pname,$arr=array(),$apname='',$page=''){
	$pna='';
	$par='';
	$url='';
	
	//去掉扩展名获取页面名
	if ($pname!=''){
		$pna=substr($pname,0,strrpos($pname,'.'));
	}
	
	//组装参数
	$a=1;
	foreach($arr as $k=>$v){
		//普通url
		if ($GLOBALS['rewrite']==0){
			if ($a==1){
				$par.=$k.'='.$v;
			}else{
				$par.='&'.$k.'='.$v;
			}
		//伪静态
		}elseif($GLOBALS['rewrite']==1){
			if ($k=='id'||$k=='lm'){
				$par.='-'.$v;
			}else{
				$par.='-'.$k.$v;
			}
		//伪静态页面名称后台可控制
		}elseif($GLOBALS['rewrite']==2){
			if ($k=='id'||$k=='lm'){
				if ($apname!=''){
					$par.='';
				}else{
					$par.='-'.$v;
				}
			}else{
				$par.='-'.$k.$v;
			}
		}
	$a++;
	}
	
	//组装url
	//普通url
	if ($GLOBALS['rewrite']==0){
		if ($page!=''){
			$par.='&page='.$page;
		}
		$url.=($par!='')?$pname.'?'.$par:$pname;
	//伪静态
	}elseif($GLOBALS['rewrite']==1){
		if ($page!=''){
			$par.='_'.$page;
		}
		$url.=$pna.$par.'.html';
	//伪静态页面名称后台可控制
	}elseif($GLOBALS['rewrite']==2){
		if ($apname!=''){
			if ($pna==''){
				$par=$apname.$par;
			}else{
				$par='-'.$apname.$par;
			}
		}
		if ($page!=''){
			$par.='_'.$page;
		}
		$url.=$pna.$par.'.html';
	}
	return $url;
}

//加载css文件
function loadcss($filename){
	static $cssarr=array();
	if(file_exists($filename)){
		if(!isset($cssarr[$filename])){
			$cssarr[$filename]=$filename;
			return '<link href="'.$filename.'" rel="stylesheet" type="text/css" />';
		}
	}else{
		exit($filename.' 文件不存在');
	}
}

//加载js文件
function loadjs($filename){
	static $jsarr=array();
	if(file_exists($filename)){
		if(!isset($jsarr[$filename])){
			$jsarr[$filename]=$filename;
			return '<script src="'.$filename.'" rel="stylesheet" type="text/javascript" ></script>';
		}
	}else{
		exit($filename.' 文件不存在');
	}
}


?>