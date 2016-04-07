<?php
require('../../include/common.inc.php');
require('../kf_lm/config.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
$title_lm=isset($_POST['title_lm'])?html($_POST['title_lm']):'';
$f_body_lm=isset($_POST['f_body_lm'])?$_POST['f_body_lm']:'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($id==''||!checknum($id)||$title_lm==''||$px==''||!checknum($px)){
	msg('参数错误');
}

$sql='update `'.$conf['sy']['table_lx'].'` set `title_lm`="'.$title_lm.'",`f_body_lm`="'.$f_body_lm.'",`px`='.$px.' where `id_lm`='.$id.'';
$db->execute($sql);

msg('保存成功','location="default.php"');
?>
