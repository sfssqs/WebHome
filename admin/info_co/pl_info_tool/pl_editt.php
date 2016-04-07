<?php 
require('../../../include/common.inc.php');
require('pl_con.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
$pl_id=isset($_POST['pl_id'])?html($_POST['pl_id']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$link_url=isset($_POST['link_url'])?html($_POST['link_url']):'';
$z_body=isset($_POST['z_body'])?$_POST['z_body']:'';
$img_sl=isset($_POST['img_sl'])?html($_POST['img_sl']):'';
$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($id==''||!checknum($id)){
	msg('参数错误');
}
if ($pl_id!=''&&!checknum($pl_id)){
	msg('参数错误');
}
if ($title==''||$px==''||!checknum($px)){
	msg('参数错误');
}

$sql='update '.$pl_table.' set `title`="'.$title.'",`link_url`="'.$link_url.'",`z_body`="'.$z_body.'",`img_sl`="'.$img_sl.'",`ym_tit`="'.$ym_tit.'",`ym_key`="'.$ym_key.'",`ym_des`="'.$ym_des.'",`px`='.$px.' where id='.$id.'';
$db->execute($sql);

msg('修改成功','parent.document.getElementById("fra_info").src="pl_info_tool/pl_default.php?pl_id='.$pl_id.'";parent.tanchuCancle()');
?>