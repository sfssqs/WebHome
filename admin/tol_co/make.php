<?php
require('../../include/common.inc.php');
require('../tol_lm/config.php');
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
		//多图配置文件
		if ($conf['co']['duotu']==true){
			require('pl_image_tool/pl_con.php');
			$pl_table_b=$pl_table;
			$pl_sy_id_b=$pl_sy_id;
			require('pl_image_tool/upcon.php');
			$s_pic_b=$s_pic;
			$s_arr_b=$s_arr;
		}
		//相关信息图片配置文件
		if ($conf['co']['info']==true){
			require('pl_info_tool/pl_con.php');
			$pl_table_c=$pl_table;
			$pl_sy_id_c=$pl_sy_id;
			require('pl_info_tool/up_image_tool/upcon.php');
			$s_pic_c=$s_pic;
			$s_arr_c=$s_arr;
		}
		//相关文件图片配置文件
		if ($conf['co']['file']==true){
			require('pl_file_tool/pl_con.php');
			$pl_table_d=$pl_table;
			$pl_sy_id_d=$pl_sy_id;
			require('pl_file_tool/up_image_tool/upcon.php');
			$s_pic_d=$s_pic;
			$s_arr_d=$s_arr;
		}
		//相关视频图片配置文件
		if ($conf['co']['video']==true){
			require('pl_video_tool/pl_con.php');
			$pl_table_e=$pl_table;
			$pl_sy_id_e=$pl_sy_id;
			require('pl_video_tool/up_image_tool/upcon.php');
			$s_pic_e=$s_pic;
			$s_arr_e=$s_arr;
		}
		
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
			
			//多图
			if ($conf['co']['duotu']==true){
				//删除多图的图片
				$sql='select `id`,`img_sl` from `'.$pl_table_b.'` where `sy_id`='.$pl_sy_id_b.' and `pl_id`='.$row['id'].'';
				$arr=$db->getrss($sql);
				foreach($arr as $rsb){
					if($rsb['img_sl']!=''){
						if($s_pic_b){
							foreach($s_arr_b as $k=>$v){
								delfile(getimgj($rsb['img_sl'],$v['s_nam']));
							}
						}else{
							delfile($rsb['img_sl']);
						}
					}
				}
				//删除多图的记录
				$db->execute('delete from `'.$pl_table_b.'` where `sy_id`='.$pl_sy_id_b.' and `pl_id`='.$row['id'].'');
			}
			
			//相关信息
			if ($conf['co']['info']==true){
				//删除相关信息的图片
				$sql='select `id`,`img_sl` from `'.$pl_table_c.'` where `sy_id`='.$pl_sy_id_c.' and `pl_id`='.$row['id'].'';
				$arr=$db->getrss($sql);
				foreach($arr as $rsb){
					if($rsb['img_sl']!=''){
						if($s_pic_c){
							foreach($s_arr_c as $k=>$v){
								delfile(getimgj($rsb['img_sl'],$v['s_nam']));
							}
						}else{
							delfile($rsb['img_sl']);
						}
					}
				}
				//删除相关信息的记录
				$db->execute('delete from `'.$pl_table_c.'` where `sy_id`='.$pl_sy_id_c.' and `pl_id`='.$row['id'].'');
			}
			
			//相关文件
			if ($conf['co']['file']==true){
				//删除相关文件的图片、文件
				$sql='select `id`,`img_sl`,`fil_sl` from `'.$pl_table_d.'` where `sy_id`='.$pl_sy_id_d.' and `pl_id`='.$row['id'].'';
				$arr=$db->getrss($sql);
				foreach($arr as $rsb){
					if($rsb['img_sl']!=''){
						if($s_pic_d){
							foreach($s_arr_d as $k=>$v){
								delfile(getimgj($rsb['img_sl'],$v['s_nam']));
							}
						}else{
							delfile($rsb['img_sl']);
						}
					}
					if($rsb['fil_sl']!=''){
						delfile($rsb['fil_sl']);
					}
				}
				//删除相关文件的记录
				$db->execute('delete from `'.$pl_table_d.'` where `sy_id`='.$pl_sy_id_d.' and `pl_id`='.$row['id'].'');
			}
			
			//相关视频
			if ($conf['co']['video']==true){
				//删除相关视频的图片、视频
				$sql='select `id`,`img_sl`,`vid_sl` from `'.$pl_table_e.'` where `sy_id`='.$pl_sy_id_e.' and `pl_id`='.$row['id'].'';
				$arr=$db->getrss($sql);
				foreach($arr as $rsb){
					if($rsb['img_sl']!=''){
						if($s_pic_e){
							foreach($s_arr_e as $k=>$v){
								delfile(getimgj($rsb['img_sl'],$v['s_nam']));
							}
						}else{
							delfile($rsb['img_sl']);
						}
					}
					if($rsb['vid_sl']!=''){
						delfile($rsb['vid_sl']);
					}
				}
				//删除相关视频的记录
				$db->execute('delete from `'.$pl_table_e.'` where `sy_id`='.$pl_sy_id_e.' and `pl_id`='.$row['id'].'');
			}
			
			//删除信息
			$db->execute('delete from `'.$conf['sy']['table_co'].'` where `id`='.$row['id'].'');
		}
	}	
}

msg('操作成功','location="'.$url.'"');
?>