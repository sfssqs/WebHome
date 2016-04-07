<?php
require('../../include/common.inc.php');
require('../kf_lm/config.php');

checklogin();

$ac=isset($_REQUEST['ac'])?$_REQUEST['ac']:'';
$url=(previous())?previous():'default.php';

if ($ac==''){
	msg('参数错误');
}

//排序
if($ac=='px'){

	$px=isset($_POST['px'])?$_POST['px']:'';
	if ($px==''||!checknum($px)){
		msg('参数错误');
	}
	foreach($px as $k=>$v){
		$sql='update `'.$conf['sy']['table_co'].'` set `px`='.$v.' where `id`='.$k.'';
		$db->execute($sql);
	}
	
}else{
	
	$id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
	if ($id==''||!checknum($id)){
		msg('参数错误');
	}
	if (is_array($id)){
		$id=implode(',',$id);
	}
	//置顶
	if($ac=='ding1'){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `ding`=1 where `id` in ('.$id.')');	
	//取消置顶
	}elseif($ac=='ding2'){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `ding`=0 where `id` in ('.$id.')');
	//推荐
	}elseif($ac=='tuijian1'){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `tuijian`=1 where `id` in ('.$id.')');	
	//取消推荐
	}elseif($ac=='tuijian2'){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `tuijian`=0 where `id` in ('.$id.')');
	//热门
	}elseif($ac=='hot1'){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `hot`=1 where `id` in ('.$id.')');	
	//取消热门
	}elseif($ac=='hot2'){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `hot`=0 where `id` in ('.$id.')');	
	//屏蔽
	}elseif($ac=='pass1'){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `pass`=1 where `id` in ('.$id.')');	
	//取消屏蔽
	}elseif($ac=='pass2'){
		$db->execute('update `'.$conf['sy']['table_co'].'` set `pass`=0 where `id` in ('.$id.')');	
	//删除信息
	}elseif ($ac=='del'){
		$db->execute('delete from `'.$conf['sy']['table_co'].'` where `id` in ('.$id.')');
	}
}

msg('操作成功','location="'.$url.'"');
?>