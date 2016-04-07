<?php
require('../include/common.inc.php');
chklogin();
$username=strtolower(trim($_POST['username']));
$password=strtolower(trim($_POST['password']));
$username1=strtolower(trim($_POST['username1']));
$password1=strtolower(trim($_POST['password1']));
$password2=strtolower(trim($_POST['password2']));
if($username==''||$password==''||$username1==''||$password1==''||$password2==''){
	msg('参数错误');
}
if($password1!=$password2){
	msg('两次输入新密码不一致');
}
$sql='select * from '.$tablepre.'`master` where `username`="'.$username.'" and `password`="'.$password.'" and `pass`="yes"';
$result=$db->query($sql);
$row=$db->getrow($result);
if (!$row){
	msg('原帐号或原密码错误');
}else{
	$sql='update '.$tablepre.'`master` set `username`="'.$username1.'",`password`="'.$password1.'" where `username`="'.$username.'"';
	$db->execute($sql);
	msg('成功修改帐号密码,请重新登录','location="admin_logout.php"');
}
?>