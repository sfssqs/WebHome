<?php
require('../../include/common.inc.php');
require('config.php');
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
		$db->execute('update `'.$conf['sy']['table_lm'].'` set `px`='.$v.' where `id_lm`='.$k.'');
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
		$db->execute('update `'.$conf['sy']['table_lm'].'` set `tuijian`=1 where `id_lm` in ('.$id.')');	
	//取消推荐
	}elseif($ac=='tuijian2'){
		$db->execute('update `'.$conf['sy']['table_lm'].'` set `tuijian`=0 where `id_lm` in ('.$id.')');
	//热门
	}elseif($ac=='hot1'){
		$db->execute('update `'.$conf['sy']['table_lm'].'` set `hot`=1 where `id_lm` in ('.$id.')');	
	//取消热门
	}elseif($ac=='hot2'){
		$db->execute('update `'.$conf['sy']['table_lm'].'` set `hot`=0 where `id_lm` in ('.$id.')');	
	//屏蔽
	}elseif($ac=='pass1'){
		$db->execute('update `'.$conf['sy']['table_lm'].'` set `pass`=1 where `id_lm` in ('.$id.')');	
	//取消屏蔽
	}elseif($ac=='pass2'){
		$db->execute('update `'.$conf['sy']['table_lm'].'` set `pass`=0 where `id_lm` in ('.$id.')');	
	//删除
	}elseif($ac=='del'){
	
		//因为包含进来的文件中的数组$pl_table、$s_pic、$s_arr名字相同，所以要改名
		//单图配置文件
		require('../'.$conf['sy']['folder_co'].'/up_image_tool/upcon.php');
		$s_pic_a=$s_pic;
		$s_arr_a=$s_arr;
		//分类图片配置文件
		require('up_image_tool/upcon.php');
		$s_pic_f=$s_pic;
		$s_arr_f=$s_arr;
		
		$rsk=$db->getrss('select `id_lm` from `'.$conf['sy']['table_lm'].'` where `id_lm` in ('.$id.')');
		foreach($rsk as $rsm){
			$rsn=$db->getrss('select `id_lm`,`img_sl_lm` from `'.$conf['sy']['table_lm'].'` where locate(",'.$rsm["id_lm"].',",list_lm)>0');
			foreach ($rsn as $rst){
			
				//删除分类下的信息以及信息的图片、文件、视频
				$sql='select `id`,`img_sl`,`vid_sl` from `'.$conf['sy']['table_co'].'` where `lm`='.$rst['id_lm'].'';
				$rss=$db->getrss($sql);
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
					
					//删除文件
					if ($row['vid_sl']!=''){
						delfile($row['vid_sl']);
					}
					
					//删除信息
					$db->execute('delete from `'.$conf['sy']['table_co'].'` where `id`='.$row['id'].'');
				}
				
				//删除分类的图片
				if ($rst['img_sl_lm']!=''){
					if($s_pic_f){
						foreach($s_arr_f as $k=>$v){
							delfile(getimgj($rst['img_sl_lm'],$v['s_nam']));
						}
					}else{
						delfile($rst['img_sl_lm']);
					}
				}
				//删除分类的记录
				$db->execute('delete from `'.$conf['sy']['table_lm'].'` where `id_lm`='.$rst['id_lm'].'');
				
			}
		}
	}
}

msg('操作成功','location="default.php"');
?>