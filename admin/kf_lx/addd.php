<?php
require('../../include/common.inc.php');
require('../kf_lm/config.php');

checklogin();

$title_lm=isset($_POST['title_lm'])?html($_POST['title_lm']):'';
$f_body_lm=isset($_POST['f_body_lm'])?$_POST['f_body_lm']:'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($title_lm==''||$px==''||!checknum($px)){
	msg('参数错误');
}

//添加类型信息
$sql='insert into `'.$conf['sy']['table_lx'].'` (`title_lm`,`f_body_lm`,`pass`,`px`,`wtime`,`ip`) values("'.$title_lm.'","'.$f_body_lm.'",1,'.$px.','.time().',"'.getip().'")';
$db->execute($sql);

msg('添加成功','location="default.php"');
?>
