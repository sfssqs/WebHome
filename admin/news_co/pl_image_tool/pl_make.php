<?php
require('../../../include/common.inc.php');
require('pl_con.php');
require('upcon.php');
checklogin();

$act=isset($_GET['act'])?$_GET['act']:'';

if ($act==''){
	msg('参数错误');
}

//删除单条记录
if ($act=='del'){

	$id=isset($_GET['id'])?$_GET['id']:'';	
	$pl_id=isset($_GET['pl_id'])?$_GET['pl_id']:'';
	
	if ($id==''||!checknum($id)){
		msg('参数错误');
	}
	if ($pl_id!=''&&!checknum($pl_id)){
		exit('参数错误');
	}
	
	$sql='select * from '.$pl_table.' where `id`='.$id.'';
	$row=$db->getrs($sql);
	if($row){
		if ($row['img_sl']!=''){
			if($s_pic){
				foreach($s_arr as $k=>$v){
					delfile(getimgj($row['img_sl'],$v['s_nam']));
				}
			}else{
				delfile($row['img_sl']);
			}
		}
		$db->execute('delete from '.$pl_table.' where `id`='.$row['id'].'');
	}
		
//批量修改
}elseif($act=='edit_pl'){

	$pl_id=isset($_GET['pl_id'])?$_GET['pl_id']:'';
	$title=isset($_POST['title'])?$_POST['title']:'';
	$px=isset($_POST['px'])?$_POST['px']:'';
	
	if ($pl_id!=''&&!checknum($pl_id)){
		exit('参数错误');
	}
	if ($px==''||!checknum($px)){
		msg('参数错误');
	}
	foreach($title as $k=>$v){
		$db->execute('update '.$pl_table.' set title="'.$title[$k].'",px='.$px[$k].' where id='.$k.'');
	}

//批量删除	
}elseif($act=='del_pl'){

	$pl_id=isset($_GET['pl_id'])?$_GET['pl_id']:'';
	$id=isset($_POST['id'])?$_POST['id']:'';
	
	if ($pl_id!=''&&!checknum($pl_id)){
		exit('参数错误');
	}
	if ($id==''||!checknum($id)){
		msg('参数错误');
	}
	
	if (is_array($id)){
		$id=implode(',',$id);
	}
	
	$sql='select * from '.$pl_table.' where `id` in ('.$id.')';
	$rss=$db->getrss($sql);
	foreach($rss as $row){
		if ($row['img_sl']!=''){
			if($s_pic){
				foreach($s_arr as $k=>$v){
					delfile(getimgj($row['img_sl'],$v['s_nam']));
				}
			}else{
				delfile($row['img_sl']);
			}
		}
		$db->execute('delete from '.$pl_table.' where `id`='.$row['id'].'');
	}
}

msg('','location="pl_default.php?pl_id='.$pl_id.'"');
?>