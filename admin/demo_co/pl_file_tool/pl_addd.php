<?php
require('../../../include/common.inc.php');
require('pl_con.php');

checklogin();

$pl_id=isset($_POST['pl_id'])?html($_POST['pl_id']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$link_url=isset($_POST['link_url'])?html($_POST['link_url']):'';
$z_body=isset($_POST['z_body'])?$_POST['z_body']:'';
$img_sl=isset($_POST['img_sl'])?html($_POST['img_sl']):'';
$fil_sl=isset($_POST['fil_sl'])?html($_POST['fil_sl']):'';
$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($pl_id!=''&&!checknum($pl_id)){
	exit('参数错误');
}

if ($title==''||$px==''||!checknum($px)){
	msg('参数错误!');
}

//如果没有$pl_id传入进来，系统生成一个临时id用session来保存
if($pl_id==''||!checknum($pl_id)){
	if(isset($_SESSION[$pl_sesname])&&$_SESSION[$pl_sesname]!=''&&checknum($_SESSION[$pl_sesname])){
		$pr_id=$_SESSION[$pl_sesname];
	}else{
		$pr_id=date('His').rand(10,99);
		$_SESSION[$pl_sesname]=$pr_id;
	}
}else{
	$pr_id=$pl_id;	
}

$sql='insert into `'.$pl_table.'` (`sy_id`,`pl_id`,`title`,`link_url`,`z_body`,`img_sl`,`fil_sl`,`ym_tit`,`ym_key`,`ym_des`,`read_num`,`px`,`ip`,`wtime`) values('.$pl_sy_id.','.$pr_id.',"'.$title.'","'.$link_url.'","'.$z_body.'","'.$img_sl.'","'.$fil_sl.'","'.$ym_tit.'","'.$ym_key.'","'.$ym_des.'",0,'.$px.',"'.getip().'",'.time().')';
$db->execute($sql);

msg('添加成功','parent.document.getElementById("fra_file").src="pl_file_tool/pl_default.php?pl_id='.$pr_id.'";parent.tanchuCancle()');
?>