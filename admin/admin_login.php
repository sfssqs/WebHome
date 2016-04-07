<?php
require('../include/common.inc.php');
$username=isset($_POST['username'])?strtolower(trim($_POST['username'])):'';
$password=isset($_POST['username'])?strtolower(trim($_POST['password'])):'';
$safecodes=isset($_POST['safecode'])?strtolower(trim($_POST['safecode'])):'';
if (empty($username)||empty($password)||empty($safecodes)){
	msg('参数错误');
}
session_start();
if ($safecodes!=$_SESSION['safecode']||$safecodes==''||$_SESSION['safecode']==''){
	msg('验证码错误');
}
$sql='select * from `'.$tablepre.'master` where `username`="'.$username.'"';
$result=$db->query($sql);
$row=$db->getrow($result);
$db->freeresult($result);
if (!$row){
	msg('帐号不存在');
}else{
	if($row['password']!=$password){
		msg('密码错误');
	}else{
		$db->execute('update `'.$tablepre.'master` set `lip`=`eip`,`ltime`=`etime`,`eip`="'.getip().'",`etime`='.time().',`login_num`=`login_num`+1 where `username`="'.$username.'"');
		$_SESSION['pyadmin']=$username;
		msg('','parent.location="system.php"');
	}
}
?>