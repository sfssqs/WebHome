<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
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
$url=isset($_POST['url'])?$_POST['url']:'default.php';

$sq='';
if ($password!=''){
	if (strlen($password)<6||strlen($password)>20||!checkstring($password)){
		msg('错误的登录密码格式');
	}else{
		$sq.=',password="'.$password.'"';
	}
}

$sql='update '.$conf['sy']['table_co'].' set `rename`="'.$rename.'",`sex`="'.$sex.'",`phone`="'.$phone.'",`fax`="'.$fax.'",`email`="'.$email.'",`qq`="'.$qq.'",`wx`="'.$wx.'",`compname`="'.$compname.'",`address`="'.$address.'",`post`="'.$post.'",`z_body`="'.$z_body.'",pass="'.$pass.'"'.$sq.'  where id="'.$id.'" ';
$result=$db->execute($sql);

msg('保存成功','location="'.$url.'"');
?>