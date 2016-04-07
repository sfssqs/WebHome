<?php
require('../../include/common.inc.php');
require('../kf_lm/config.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
$lm=isset($_POST['lm'])?html($_POST['lm']):'';
$lx=isset($_POST['lx'])?html($_POST['lx']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$rename=isset($_POST['rename'])?html($_POST['rename']):'';
$uename=isset($_POST['uename'])?html($_POST['uename']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';
$url=isset($_POST['url'])?$_POST['url']:'';

if ($id==''||!checknum($id)||$lm==''||!checknum($lm)||$lx==''||!checknum($lx)||$title==''||$px==''||!checknum($px)){
	msg('参数错误');
}

//获取所属分类的分类列表
$list_lm='';
$rs=$db->getrs('select list_lm from `'.$conf['sy']['table_lm'].'` where id_lm='.$lm.'');
if ($rs){
	$list_lm=$rs['list_lm'];
}

$sql='update `'.$conf['sy']['table_co'].'` set `lm`='.$lm.',`list_lm`="'.$list_lm.'",`lx`='.$lx.',`title`="'.$title.'",`rename`="'.$rename.'",`uename`="'.$uename.'",`px`='.$px.' where `id`='.$id.'';
$db->execute($sql);

msg('保存成功','location="'.$url.'"');
?>