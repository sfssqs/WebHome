<?php
require('../../include/common.inc.php');
require('../ban_lm/config.php');

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
	//删除
	}elseif ($ac=='del'){
		
		//因为包含进来的文件中的数组$pl_table、$pl_sy_id、$s_pic、$s_arr名字相同，所以要改名
		//单图配置文件
		require('up_image_tool/upcon.php');
		$s_pic_a=$s_pic;
		$s_arr_a=$s_arr;
		
		$rss=$db->getrss('select `id`,`img_sl` from `'.$conf['sy']['table_co'].'` where `id` in ('.$id.')');
		foreach($rss as $row){
		
			//删除单图
			if ($row['img_sl']!=''){
				if($s_pic_a){
					foreach($s_arr_a as $k=>$v){
						delfile(getimgj($row['img_sl'],$v['s_nam']));
					}
				}else{
					delfile($row['img_sl']);
				}
			}
			
			//删除信息
			$db->execute('delete from `'.$conf['sy']['table_co'].'` where `id`='.$row['id'].'');
		}
	}
}

msg('操作成功','location="'.$url.'"');
?>