<?php
require('../../include/common.inc.php');
require('../kf_lm/config.php');

checklogin();

$lm=isset($_POST['lm'])?html($_POST['lm']):'';
$lx=isset($_POST['lx'])?html($_POST['lx']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$rename=isset($_POST['rename'])?html($_POST['rename']):'';
$uename=isset($_POST['uename'])?html($_POST['uename']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($lm==''||!checknum($lm)||$lx==''||!checknum($lx)||$title==''||$px==''||!checknum($px)){
	msg('参数错误!');
}

//获取所属分类的分类列表
$list_lm='';
$rs=$db->getrs('select list_lm from `'.$conf['sy']['table_lm'].'` where id_lm='.$lm.'');
if ($rs){
	$list_lm=$rs['list_lm'];
}

$sql='insert into `'.$conf['sy']['table_co'].'` (`lm`,`list_lm`,`lx`,`title`,`rename`,`uename`,`ding`,`tuijian`,`hot`,`pass`,`read_num`,`px`,`ip`,`wtime`) values('.$lm.',"'.$list_lm.'",'.$lx.',"'.$title.'","'.$rename.'","'.$uename.'",0,0,0,1,0,'.$px.',"'.getip().'",'.time().')';
$db->execute($sql);

msg('添加成功','location="default.php"');
?>