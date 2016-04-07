<?php
require('../../include/common.inc.php');
require('../ban_lm/config.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
$lm=isset($_POST['lm'])?html($_POST['lm']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$link_url=isset($_POST['link_url'])?html($_POST['link_url']):'';
$z_body=isset($_POST['z_body'])?$_POST['z_body']:'';
$img_sl=isset($_POST['img_sl'])?html($_POST['img_sl']):'';
$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';
$url=isset($_POST['url'])?$_POST['url']:'';

if ($id==''||!checknum($id)||$lm==''||!checknum($lm)||$title==''||$px==''||!checknum($px)){
	msg('参数错误');
}

//获取所属分类的分类列表
$list_lm='';
$rs=$db->getrs('select list_lm from `'.$conf['sy']['table_lm'].'` where id_lm='.$lm.'');
if ($rs){
	$list_lm=$rs['list_lm'];
}

$sql='update `'.$conf['sy']['table_co'].'` set `lm`='.$lm.',`list_lm`="'.$list_lm.'",`title`="'.$title.'",`link_url`="'.$link_url.'",`z_body`="'.$z_body.'",`img_sl`="'.$img_sl.'",`ym_tit`="'.$ym_tit.'",`ym_key`="'.$ym_key.'",`ym_des`="'.$ym_des.'",`px`='.$px.' where `id`='.$id.'';
$db->execute($sql);

msg('保存成功','location="'.$url.'"');
?>