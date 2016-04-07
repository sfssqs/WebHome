<?php
require('../../include/common.inc.php');
require('../kf_lm/config.php');

checklogin();

$ac=isset($_GET['ac'])?$_GET['ac']:'';
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
		$db->execute('update `'.$conf['sy']['table_lx'].'` set `px`='.$v.' where `id_lm`='.$k.'');
	}
}else{
	$id=isset($_GET['id'])?$_GET['id']:'';
	if ($id==''||!checknum($id)){
		msg('参数错误');
	}
	if (is_array($id)){
		$id=implode(',',$id);
	}
	//推荐
	if($ac=='tuijian1'){
		$db->execute('update `'.$conf['sy']['table_lx'].'` set `tuijian`=1 where `id_lm` in ('.$id.')');	
	//取消推荐
	}elseif($ac=='tuijian2'){
		$db->execute('update `'.$conf['sy']['table_lx'].'` set `tuijian`=0 where `id_lm` in ('.$id.')');
	//热门
	}elseif($ac=='hot1'){
		$db->execute('update `'.$conf['sy']['table_lx'].'` set `hot`=1 where `id_lm` in ('.$id.')');	
	//取消热门
	}elseif($ac=='hot2'){
		$db->execute('update `'.$conf['sy']['table_lx'].'` set `hot`=0 where `id_lm` in ('.$id.')');	
	//屏蔽
	}elseif($ac=='pass1'){
		$db->execute('update `'.$conf['sy']['table_lx'].'` set `pass`=1 where `id_lm` in ('.$id.')');	
	//取消屏蔽
	}elseif($ac=='pass2'){
		$db->execute('update `'.$conf['sy']['table_lx'].'` set `pass`=0 where `id_lm` in ('.$id.')');	
	//删除
	}elseif($ac=='del'){		
	//删除类型的记录
	$db->execute('delete from `'.$conf['sy']['table_lx'].'` where `id_lm` in ('.$id.')');
	}
}

msg('操作成功','location="default.php"');
?>