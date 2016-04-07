<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$id=isset($_POST['id'])?html($_POST['id']):'';
$fid=isset($_POST['fid'])?html($_POST['fid']):'';
$title_lm=isset($_POST['title_lm'])?html($_POST['title_lm']):'';
$title_lm_en=isset($_POST['title_lm_en'])?html($_POST['title_lm_en']):'';
$url_lm=isset($_POST['url_lm'])?html($_POST['url_lm']):'';
$f_body_lm=isset($_POST['f_body_lm'])?html($_POST['f_body_lm']):'';
$z_body_lm=isset($_POST['z_body_lm'])?$_POST['z_body_lm']:'';
$img_sl_lm=isset($_POST['img_sl_lm'])?html($_POST['img_sl_lm']):'';
$add_xx=isset($_POST['add_xx'])?html($_POST['add_xx']):'';
$add_xia=isset($_POST['add_xia'])?html($_POST['add_xia']):'';
$con_att=isset($_POST['con_att'])?html($_POST['con_att']):'';
$info_keyword=isset($_POST['info_keyword'])?html($_POST['info_keyword']):'';
$info_link=isset($_POST['info_link'])?html($_POST['info_link']):'';
$info_from=isset($_POST['info_from'])?html($_POST['info_from']):'';
$info_f_body=isset($_POST['info_f_body'])?html($_POST['info_f_body']):'';
$info_z_body=isset($_POST['info_z_body'])?html($_POST['info_z_body']):'';
$info_img_sl=isset($_POST['info_img_sl'])?html($_POST['info_img_sl']):'';
$info_img_txt=isset($_POST['info_img_txt'])?html($_POST['info_img_txt']):'';
$info_img_pic=isset($_POST['info_img_pic'])?html($_POST['info_img_pic']):'';
$info_img_typ=isset($_POST['info_img_typ'])?html($_POST['info_img_typ']):'';
$info_img_wid=isset($_POST['info_img_wid'])?html($_POST['info_img_wid']):'';
$info_img_hei=isset($_POST['info_img_hei'])?html($_POST['info_img_hei']):'';
$info_pic_sl=isset($_POST['info_pic_sl'])?html($_POST['info_pic_sl']):'';
$info_pic_txt=isset($_POST['info_pic_txt'])?html($_POST['info_pic_txt']):'';
$info_pic_pic=isset($_POST['info_pic_pic'])?html($_POST['info_pic_pic']):'';
$info_pic_typ=isset($_POST['info_pic_typ'])?html($_POST['info_pic_typ']):'';
$info_pic_wid=isset($_POST['info_pic_wid'])?html($_POST['info_pic_wid']):'';
$info_pic_hei=isset($_POST['info_pic_hei'])?html($_POST['info_pic_hei']):'';
$info_fil_sl=isset($_POST['info_fil_sl'])?html($_POST['info_fil_sl']):'';
$info_vid_sl=isset($_POST['info_vid_sl'])?html($_POST['info_vid_sl']):'';
$info_duotu=isset($_POST['info_duotu'])?html($_POST['info_duotu']):'';
$info_info=isset($_POST['info_info'])?html($_POST['info_info']):'';
$info_file=isset($_POST['info_file'])?html($_POST['info_file']):'';
$info_video=isset($_POST['info_video'])?html($_POST['info_video']):'';
$info_wtime=isset($_POST['info_wtime'])?html($_POST['info_wtime']):'';
$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($id==''||!checknum($id)||$fid==''||!checknum($fid)||$title_lm==''||$add_xx==''||$add_xia==''||$con_att==''||$info_link==''||$info_from==''||$info_f_body==''||$info_z_body==''||$info_img_sl==''||$info_wtime==''||$px==''||!checknum($px)){
	msg('参数错误');
}

//判断系统支持几级分类
if ($fid!=0){
	$rsa=$db->getrs('select * from `'.$conf['sy']['table_lm'].'` where id_lm='.$fid.'');
	if(!$rsa){
		msg('上级分类不存在或已删除');
	}else{
		if ($conf['sy']['level_lm']>0&&$rsa['level_lm']>($conf['sy']['level_lm']-1)){
			msg('系统最多可以添加'.$conf['sy']['level_lm'].'级分类');
		}
	}
}

//获取修改的分类信息
$rs=$db->getrs('select * from `'.$conf['sy']['table_lm'].'` where id_lm='.$id.'');
if(!$rs){
	msg('当前分类不存在或已删除');
}else{
	//当现在的上级分类与原来的上级分类不一样时
	if ($fid!=$rs['fid']){
	
		//检测--不能把当前分类修改成隶属于它自己或它的下级
		if ($fid!=0){
			//获取现在上级分类信息
			$rsa=$db->getrs('select * from `'.$conf['sy']['table_lm'].'` where id_lm='.$fid.'');
			if(!$rsa){
				msg('上级分类不存在或已删除');
			}else{
				//在现在的上级分类的分类列表里找"要修改的分类id"的位置
				$id_pos=strpos($rsa['list_lm'],','.$id.',');
				//在现在的上级分类的分类列表里找"现在上级分类id"的位置
				$fid_pos=strpos($rsa['list_lm'],','.$fid.',');
				//如果在现在的上级分类的分类列表里找到要修改的分类id的位置
				if ($id_pos!==false){
					//举例现在的上级分类id为4 分类列表“,2,3,4,” 当前修改的分类id为3 把要修改的分类id为3移动它的下级分类4去
					if ($id_pos<=$fid_pos){
						msg('不能把上级分类设为当前分类或当前分类的下级分类');
					}
				}
			}
		}
		
		//修改"当前分类"和"它以前的下级分类"的分类列表和分类级别,同时修改信息表里的分类列表
		if ($fid==0){
			//上级分类的分类列表
			$list_lm='';
			//上级分类的分类级别
			$level_lm=0;
			//现在的分类级别与原来的分类级别相差值
			$level_bian=($level_lm+1)-$rs['level_lm'];
		}else{
			//获取现在上级分类信息
			$rsa=$db->getrs('select * from `'.$conf['sy']['table_lm'].'` where id_lm='.$fid.'');
			if(!$rsa){
				msg('上级分类不存在或已删除');
			}else{
				$list_lm=substr($rsa['list_lm'],0,(strlen($rsa['list_lm'])-1));
				$level_lm=$rsa['level_lm'];
				$level_bian=($level_lm+1)-$rs['level_lm'];
			}
		}
		//修改"当前分类"和"它以前的下级分类"的分类列表
		//concat、substring、locate都是mysql的函数 concat(str1,str2,str3...)组合字符串，substring(str,start,length)截取字符串，locate(str1,str2)在str2里查找str1出现的位置
		$db->execute('update `'.$conf['sy']['table_lm'].'` set list_lm=concat("'.$list_lm.'",substring(list_lm,locate(",'.$id.',",list_lm))) where locate(",'.$id.',",list_lm)>0');
		//修改"当前分类"和"它以前的下级分类"的分类级别
		$db->execute('update `'.$conf['sy']['table_lm'].'` set level_lm=(level_lm+'.$level_bian.') where locate(",'.$id.',",list_lm)>0');
		//修改"信息表"里的分类列表
		$db->execute('update `'.$conf['sy']['table_co'].'` set list_lm=concat("'.$list_lm.'",substring(list_lm,locate(",'.$id.',",list_lm))) where locate(",'.$id.',",list_lm)>0');
	}
}


$sql='update `'.$conf['sy']['table_lm'].'` set `fid`='.$fid.',`title_lm`="'.$title_lm.'",`title_lm_en`="'.$title_lm_en.'",`url_lm`="'.$url_lm.'",`f_body_lm`="'.$f_body_lm.'",`z_body_lm`="'.$z_body_lm.'",`img_sl_lm`="'.$img_sl_lm.'",`add_xx`="'.$add_xx.'",`add_xia`="'.$add_xia.'",`con_att`="'.$con_att.'",`info_keyword`="'.$info_keyword.'",`info_link`="'.$info_link.'",`info_from`="'.$info_from.'",`info_f_body`="'.$info_f_body.'",`info_z_body`="'.$info_z_body.'",`info_img_sl`="'.$info_img_sl.'",`info_img_txt`="'.$info_img_txt.'",`info_img_pic`="'.$info_img_pic.'",`info_img_typ`="'.$info_img_typ.'",`info_img_wid`="'.$info_img_wid.'",`info_img_hei`="'.$info_img_hei.'",`info_pic_sl`="'.$info_pic_sl.'",`info_pic_txt`="'.$info_pic_txt.'",`info_pic_pic`="'.$info_pic_pic.'",`info_pic_typ`="'.$info_pic_typ.'",`info_pic_wid`="'.$info_pic_wid.'",`info_pic_hei`="'.$info_pic_hei.'",`info_fil_sl`="'.$info_fil_sl.'",`info_vid_sl`="'.$info_vid_sl.'",`info_duotu`="'.$info_duotu.'",`info_info`="'.$info_info.'",`info_file`="'.$info_file.'",`info_video`="'.$info_video.'",`info_wtime`="'.$info_wtime.'",`ym_tit`="'.$ym_tit.'",`ym_key`="'.$ym_key.'",`ym_des`="'.$ym_des.'",`px`='.$px.' where `id_lm`='.$id.'';
$db->execute($sql);

msg('保存成功','location="default.php"');
?>
