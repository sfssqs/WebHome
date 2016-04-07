<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$username=isset($_POST['username'])?html(trim($_POST['username'])):'';
$password=isset($_POST['password'])?html(trim($_POST['password'])):'';
$rename=isset($_POST['rename'])?html(trim($_POST['rename'])):'';
$sex=isset($_POST['sex'])?html(trim($_POST['sex'])):'';
$phone=isset($_POST['phone'])?html(trim($_POST['phone'])):'';
$fax=isset($_POST['fax'])?html(trim($_POST['fax'])):'';
$email=isset($_POST['email'])?html(trim($_POST['email'])):'';
$qq=isset($_POST['qq'])?html(trim($_POST['qq'])):'';
$wx=isset($_POST['wx'])?html(trim($_POST['wx'])):'';
$compname=isset($_POST['compname'])?html(trim($_POST['compname'])):'';
$address=isset($_POST['address'])?html(trim($_POST['address'])):'';
$post=isset($_POST['post'])?html(trim($_POST['post'])):'';
$z_body=isset($_POST['z_body'])?html($_POST['z_body']):'';
$pass=isset($_POST['pass'])?html(trim($_POST['pass'])):'';


if (strlen($username)<6||strlen($username)>20||!checkstring($username)){
	msg('错误的用户名格式');
}

if (strlen($password)<6||strlen($password)>20||!checkstring($password)){
	msg('错误的登录密码格式');
}

$row=$db->getrs('select `username` from `'.$conf['sy']['table_co'].'` where `username`="'.$username.'"');
if ($row){
	msg('该用户名已有人使用');
}else{
	$sql='insert into `'.$conf['sy']['table_co'].'` (`username`,`password`,`rename`,`sex`,`phone`,`fax`,`email`,`qq`,`wx`,`compname`,`address`,`post`,`z_body`,`login_num`,`pass`,`wtime`,`wip`)values("'.$username.'","'.$password.'","'.$rename.'","'.$sex.'","'.$phone.'","'.$fax.'","'.$email.'","'.$qq.'","'.$wx.'","'.$compname.'","'.$address.'","'.$post.'","'.$z_body.'",0,'.$pass.','.time().',"'.getip().'")';
	$db->execute($sql);
}

msg('添加成功','location="default.php"');
?>