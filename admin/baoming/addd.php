<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
$htime=isset($_POST['htime'])?strtotime($_POST['htime']):'';
$h_body=isset($_POST['h_body'])?html($_POST['h_body']):'';
$url=isset($_POST['url'])?$_POST['url']:'';

if ($id==''||!checknum($id)){
	msg('参数错误');
}

$db->execute('update `'.$conf['sy']['table_co'].'` set chuli=1,htime="'.$htime.'",h_body="'.$h_body.'" where `id`='.$id.'');


msg('保存成功','location="show.php?id='.$id.'&url='.urlencode($url).'"');
?>