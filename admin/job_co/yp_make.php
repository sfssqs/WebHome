<?php
require('../../include/common.inc.php');
require('../job_lm/config.php');

checklogin();

$id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
$ac=isset($_REQUEST['ac'])?$_REQUEST['ac']:'';
$url=(previous())?previous():'yp_default.php';

if ($ac==''||$id==''||!checknum($id)){
	msg('参数错误');
}

if (is_array($id)){
	$id=implode(',',$id);
}
	
//删除
if ($ac=='del'){
	$db->execute('delete from `'.$conf['sy']['table_yp'].'` where `id` in ('.$id.')');
}

msg('操作成功','location="'.$url.'"');
?>