<?php
require('../../include/common.inc.php');
require('../job_lm/config.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
$lm=isset($_POST['lm'])?html($_POST['lm']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$num=isset($_POST['num'])?html($_POST['num']):'';
$address=isset($_POST['address'])?html($_POST['address']):'';
$f_body=isset($_POST['f_body'])?$_POST['f_body']:'';
$z_body=isset($_POST['z_body'])?$_POST['z_body']:'';
$stime=isset($_POST['stime'])?html($_POST['stime']):'';
$etime=isset($_POST['etime'])?html($_POST['etime']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';
$url=isset($_POST['url'])?$_POST['url']:'default.php';

if ($id==''||!checknum($id)||$lm==''||!checknum($lm)||$title==''||$px==''||!checknum($px)){
	msg('参数错误');
}

//获取所属分类的分类列表
$list_lm='';
$rs=$db->getrs('select list_lm from `'.$conf['sy']['table_lm'].'` where id_lm='.$lm.'');
if ($rs){
	$list_lm=$rs['list_lm'];
}

$sql='update `'.$conf['sy']['table_co'].'` set `lm`='.$lm.',`list_lm`="'.$list_lm.'",`title`="'.$title.'",`num`="'.$num.'",`address`="'.$address.'",`f_body`="'.$f_body.'",`z_body`="'.$z_body.'",`stime`="'.$stime.'",`etime`="'.$etime.'",`px`='.$px.' where `id`='.$id.'';
$db->execute($sql);

msg('保存成功','location="'.$url.'"');
?>