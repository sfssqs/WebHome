<?php
require('../../include/common.inc.php');
require('../pro_lm/config.php');

checklogin();

$lm=isset($_POST['lm'])?html($_POST['lm']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$keyword=isset($_POST['keyword'])?html($_POST['keyword']):'';
$link_url=isset($_POST['link_url'])?html($_POST['link_url']):'';
$pro_can1=isset($_POST['pro_can1'])?html($_POST['pro_can1']):'';
$pro_can2=isset($_POST['pro_can2'])?html($_POST['pro_can2']):'';
$pro_can3=isset($_POST['pro_can3'])?html($_POST['pro_can3']):'';
$pro_can4=isset($_POST['pro_can4'])?html($_POST['pro_can4']):'';
$f_body=isset($_POST['f_body'])?html($_POST['f_body']):'';
$z_body=isset($_POST['z_body'])?$_POST['z_body']:'';
$t_body=isset($_POST['t_body'])?$_POST['t_body']:'';
$g_body=isset($_POST['g_body'])?$_POST['g_body']:'';
$img_sl=isset($_POST['img_sl'])?html($_POST['img_sl']):'';
$pic_sl=isset($_POST['pic_sl'])?html($_POST['pic_sl']):'';
$fil_sl=isset($_POST['fil_sl'])?html($_POST['fil_sl']):'';
$vid_sl=isset($_POST['vid_sl'])?html($_POST['vid_sl']):'';
$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';


$title_en=isset($_POST['title_en'])?html($_POST['title_en']):'';
$f_body_en=isset($_POST['f_body_en'])?html($_POST['f_body_en']):'';
$z_body_en=isset($_POST['z_body_en'])?$_POST['z_body_en']:'';

$t_body_en=isset($_POST['t_body_en'])?$_POST['t_body_en']:'';
$g_body_en=isset($_POST['g_body_en'])?$_POST['g_body_en']:'';
$ym_tit_en=isset($_POST['ym_tit_en'])?html($_POST['ym_tit_en']):'';
$ym_key_en=isset($_POST['ym_key_en'])?html($_POST['ym_key_en']):'';
$ym_des_en=isset($_POST['ym_des_en'])?html($_POST['ym_des_en']):'';


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

$sql='insert into `'.$conf['sy']['table_co'].'` (`lm`,`list_lm`,`title`,`title_en`,`keyword`,`link_url`,`pro_can1`,`pro_can2`,`pro_can3`,`pro_can4`,`f_body`,`z_body`,`t_body`,`g_body`,`f_body_en`,`z_body_en`,`t_body_en`,`g_body_en`,`img_sl`,`pic_sl`,`fil_sl`,`vid_sl`,`ym_tit`,`ym_key`,`ym_des`,`ding`,`tuijian`,`hot`,`pass`,`read_num`,`px`,`ip`,`wtime`) values('.$lm.',"'.$list_lm.'","'.$title.'","'.$title_en.'","'.$keyword.'","'.$link_url.'","'.$pro_can1.'","'.$pro_can2.'","'.$pro_can3.'","'.$pro_can4.'","'.$f_body.'","'.$z_body.'","'.$t_body.'","'.$g_body.'","'.$f_body_en.'","'.$z_body_en.'","'.$t_body_en.'","'.$g_body_en.'","'.$img_sl.'","'.$pic_sl.'","'.$fil_sl.'","'.$vid_sl.'","'.$ym_tit.'","'.$ym_key.'","'.$ym_des.'",0,0,0,1,0,'.$px.',"'.getip().'",'.time().')';
$db->execute($sql);
$id=$db->insert_id();

//添加信息后把批量上传的临时sessionID换成信息的id
if ($conf['co']['duotu']==true){
	require('pl_image_tool/pl_con.php');
	if (isset($_SESSION[$pl_sesname])&&checknum($_SESSION[$pl_sesname])){	
		$db->execute('update `'.$pl_table.'` set pl_id='.$id.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].'');
		$_SESSION[$pl_sesname]='';
	}
}

//添加信息后把批量上传的临时sessionID换成信息的id
if ($conf['co']['info']==true){
	require('pl_info_tool/pl_con.php');
	if (isset($_SESSION[$pl_sesname])&&checknum($_SESSION[$pl_sesname])){	
		$db->execute('update `'.$pl_table.'` set pl_id='.$id.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].'');
		$_SESSION[$pl_sesname]='';
	}
}

//添加信息后把批量上传的临时sessionID换成信息的id
if ($conf['co']['file']==true){
	require('pl_file_tool/pl_con.php');
	if (isset($_SESSION[$pl_sesname])&&checknum($_SESSION[$pl_sesname])){	
		$db->execute('update `'.$pl_table.'` set pl_id='.$id.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].'');
		$_SESSION[$pl_sesname]='';
	}
}

//添加信息后把批量上传的临时sessionID换成信息的id
if ($conf['co']['video']==true){
	require('pl_video_tool/pl_con.php');
	if (isset($_SESSION[$pl_sesname])&&checknum($_SESSION[$pl_sesname])){	
		$db->execute('update `'.$pl_table.'` set pl_id='.$id.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].'');
		$_SESSION[$pl_sesname]='';
	}
}


msg('添加成功','location="default.php"');
?>