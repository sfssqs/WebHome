<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
$ac=isset($_REQUEST['ac'])?$_REQUEST['ac']:'';
(previous())?$url=previous():$url='default.php';

if ($ac==''){
	msg('参数错误');
}
if ($id==''||!checknum($id)){
	msg('参数错误','',$db);
}
if (is_array($id)){
	$id=implode(',',$id);
}

//删除
if ($ac=='del'){
	$db->execute('delete from '.$conf['sy']['table_co'].' where `id` in ('.$id.')');
}


msg('操作成功','location="'.$url.'"');
?>