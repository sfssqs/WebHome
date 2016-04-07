<?php
require('../../include/common.inc.php');
require('../info_lm/config.php');

checklogin();

$lm=isset($_POST['lm'])?html($_POST['lm']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$title_en=isset($_POST['title_en'])?html($_POST['title_en']):'';
$color_font=isset($_POST['color_font'])?html($_POST['color_font']):'';
$keyword=isset($_POST['keyword'])?html($_POST['keyword']):'';
$link_url=isset($_POST['link_url'])?html($_POST['link_url']):'';
$info_from=isset($_POST['info_from'])?html($_POST['info_from']):'';
$info_author=isset($_POST['info_author'])?html($_POST['info_author']):'';
$f_body=isset($_POST['f_body'])?html($_POST['f_body']):'';
$z_body=isset($_POST['z_body'])?$_POST['z_body']:'';
$f_body_en=isset($_POST['f_body_en'])?html($_POST['f_body_en']):'';
$z_body_en=isset($_POST['z_body_en'])?$_POST['z_body_en']:'';
$img_sl=isset($_POST['img_sl'])?html($_POST['img_sl']):'';
$pic_sl=isset($_POST['pic_sl'])?html($_POST['pic_sl']):'';
$fil_sl=isset($_POST['fil_sl'])?html($_POST['fil_sl']):'';
$vid_sl=isset($_POST['vid_sl'])?html($_POST['vid_sl']):'';
$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';
$wtime=isset($_POST['wtime'])?strtotime(html($_POST['wtime'])):'';

if ($lm==''||!checknum($lm)||$title==''||$px==''||!checknum($px)){
	msg('参数错误');
}

//获取所属分类的分类列表
$list_lm='';
$rs=$db->getrs('select list_lm from `'.$conf['sy']['table_lm'].'` where id_lm='.$lm.'');
if ($rs){
	$list_lm=$rs['list_lm'];
}

$sql='insert into `'.$conf['sy']['table_co'].'` (`lm`,`list_lm`,`title`,`title_en`,`color_font`,`keyword`,`link_url`,`info_from`,`info_author`,`f_body`,`z_body`,`f_body_en`,`z_body_en`,`img_sl`,`pic_sl`,`fil_sl`,`vid_sl`,`ym_tit`,`ym_key`,`ym_des`,`ding`,`tuijian`,`hot`,`pass`,`read_num`,`px`,`ip`,`wtime`) values('.$lm.',"'.$list_lm.'","'.$title.'","'.$title.'","'.$color_font.'","'.$keyword.'","'.$link_url.'","'.$info_from.'","'.$info_author.'","'.$f_body.'","'.$z_body.'","'.$f_body_en.'","'.$z_body_en.'","'.$img_sl.'","'.$pic_sl.'","'.$fil_sl.'","'.$vid_sl.'","'.$ym_tit.'","'.$ym_key.'","'.$ym_des.'",0,0,0,1,0,'.$px.',"'.getip().'",'.$wtime.')';
$db->execute($sql);
$id=$db->insert_id();

//添加信息后把批量上传的临时sessionID换成信息的id
require('pl_image_tool/pl_con.php');
if (isset($_SESSION[$pl_sesname])&&checknum($_SESSION[$pl_sesname])){	
	$db->execute('update `'.$pl_table.'` set pl_id='.$id.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].'');
	$_SESSION[$pl_sesname]='';
}

//添加信息后把批量上传的临时sessionID换成信息的id
require('pl_info_tool/pl_con.php');
if (isset($_SESSION[$pl_sesname])&&checknum($_SESSION[$pl_sesname])){	
	$db->execute('update `'.$pl_table.'` set pl_id='.$id.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].'');
	$_SESSION[$pl_sesname]='';
}

//添加信息后把批量上传的临时sessionID换成信息的id
require('pl_file_tool/pl_con.php');
if (isset($_SESSION[$pl_sesname])&&checknum($_SESSION[$pl_sesname])){	
	$db->execute('update `'.$pl_table.'` set pl_id='.$id.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].'');
	$_SESSION[$pl_sesname]='';
}

//添加信息后把批量上传的临时sessionID换成信息的id
require('pl_video_tool/pl_con.php');
if (isset($_SESSION[$pl_sesname])&&checknum($_SESSION[$pl_sesname])){	
	$db->execute('update `'.$pl_table.'` set pl_id='.$id.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].'');
	$_SESSION[$pl_sesname]='';
}

msg('添加成功','location="default.php"');
?>