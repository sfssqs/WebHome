<?php
require('../../include/common.inc.php');
require('../job_lm/config.php');

checklogin();

$lm=isset($_POST['lm'])?html($_POST['lm']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$num=isset($_POST['num'])?html($_POST['num']):'';
$address=isset($_POST['address'])?html($_POST['address']):'';
$stime=isset($_POST['stime'])?html($_POST['stime']):'';
$etime=isset($_POST['etime'])?html($_POST['etime']):'';
$f_body=isset($_POST['f_body'])?$_POST['f_body']:'';
$z_body=isset($_POST['z_body'])?$_POST['z_body']:'';
$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($lm==''||!checknum($lm)||$title==''||$px==''||!checknum($px)){
	msg('参数错误!');
}

//获取所属分类的分类列表
$list_lm='';
$rs=$db->getrs('select list_lm from `'.$conf['sy']['table_lm'].'` where id_lm='.$lm.'');
if ($rs){
	$list_lm=$rs['list_lm'];
}

$sql='insert into `'.$conf['sy']['table_co'].'` (`lm`,`list_lm`,`title`,`num`,`address`,`stime`,`etime`,`f_body`,`z_body`,`ym_tit`,`ym_key`,`ym_des`,`ding`,`tuijian`,`hot`,`pass`,`read_num`,`px`,`ip`,`wtime`) values('.$lm.',"'.$list_lm.'","'.$title.'","'.$num.'","'.$address.'","'.$stime.'","'.$etime.'","'.$f_body.'","'.$z_body.'","'.$ym_tit.'","'.$ym_key.'","'.$ym_des.'",0,0,0,1,0,'.$px.',"'.getip().'",'.time().')';
$db->execute($sql);
$id=$db->insert_id();

msg('添加成功','location="default.php"');
?>