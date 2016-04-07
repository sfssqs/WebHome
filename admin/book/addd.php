<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
$z_body=isset($_POST['z_body'])?html($_POST['z_body']):'';
$h_body=isset($_POST['h_body'])?html($_POST['h_body']):'';
$url=isset($_POST['url'])?$_POST['url']:'';

if ($id==''||!checknum($id)){
	msg('参数错误');
}

$db->execute('update `'.$conf['sy']['table_co'].'` set z_body="'.$z_body.'" where `id`='.$id.'');

if ($h_body!=''){
	$rs=$db->getrs('select * from `'.$conf['sy']['table_co'].'` where `id_re`='.$id.' order by `id` desc limit 1');
	if ($rs){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `z_body`="'.$h_body.'" where `id`='.$rs["id"].'');
	}else{
		$db->execute('insert into `'.$conf['sy']['table_co'].'` (`id_re`,`z_body`,`wtime`,`ip`,`chakan`,`huifu`,`pass`)values('.$id.',"'.$h_body.'",'.time().',"'.getip().'",0,0,1)');
	}
	$db->execute('update `'.$conf['sy']['table_co'].'` set `huifu`=1 where `id`='.$id.'');
}

msg('提交成功','location="show.php?id='.$id.'&url='.urlencode($url).'"');
?>