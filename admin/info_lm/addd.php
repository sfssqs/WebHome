<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

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

if ($fid==''||!checknum($fid)||$title_lm==''||$add_xx==''||$add_xia==''||$con_att==''||$info_link==''||$info_from==''||$info_f_body==''||$info_z_body==''||$info_img_sl==''||$info_wtime==''||$px==''||!checknum($px)){
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

//添加分类信息
$sql='insert into `'.$conf['sy']['table_lm'].'` (`fid`,`title_lm`,`title_lm_en`,`url_lm`,`f_body_lm`,`z_body_lm`,`img_sl_lm`,`add_xx`,`add_xia`,`con_att`,`info_keyword`,`info_link`,`info_from`,`info_f_body`,`info_z_body`,`info_img_sl`,`info_img_txt`,`info_img_pic`,`info_img_typ`,`info_img_wid`,`info_img_hei`,`info_pic_sl`,`info_pic_txt`,`info_pic_pic`,`info_pic_typ`,`info_pic_wid`,`info_pic_hei`,`info_fil_sl`,`info_vid_sl`,`info_duotu`,`info_info`,`info_file`,`info_video`,`info_wtime`,`ym_tit`,`ym_key`,`ym_des`,`tuijian`,`hot`,`pass`,`px`,`wtime`,`ip`) values('.$fid.',"'.$title_lm.'","'.$title_lm_en.'","'.$url_lm.'","'.$f_body_lm.'","'.$z_body_lm.'","'.$img_sl_lm.'","'.$add_xx.'","'.$add_xia.'","'.$con_att.'","'.$info_keyword.'","'.$info_link.'","'.$info_from.'","'.$info_f_body.'","'.$info_z_body.'","'.$info_img_sl.'","'.$info_img_txt.'","'.$info_img_pic.'","'.$info_img_typ.'","'.$info_img_wid.'","'.$info_img_hei.'","'.$info_pic_sl.'","'.$info_pic_txt.'","'.$info_pic_pic.'","'.$info_pic_typ.'","'.$info_pic_wid.'","'.$info_pic_hei.'","'.$info_fil_sl.'","'.$info_vid_sl.'","'.$info_duotu.'","'.$info_info.'","'.$info_file.'","'.$info_video.'","'.$info_wtime.'","'.$ym_tit.'","'.$ym_key.'","'.$ym_des.'",0,0,1,'.$px.','.time().',"'.getip().'")';
$db->execute($sql);

//更新新增的分类的分类列表和分类级别
//获取新增的分类id
$id=$db->insert_id();
//如果没有上级分类，分类列表就是新增的分类id，分类级别就是1级
if ($fid==0){
	$list_lm=",".$id.",";
	$level_lm=1;
//如果有上级分类，分类列表就在上级分类列表的基础上加上新增的分类id，分类级别就在上级分类级别的基础上加1级
}else{
	$rsa=$db->getrs('select * from `'.$conf['sy']['table_lm'].'` where id_lm='.$fid.'');
	if(!$rsa){
		msg('上级分类不存在或已删除');
	}else{
		$list_lm=$rsa['list_lm'].$id.',';
		$level_lm=$rsa['level_lm']+1;
	}
}
//把获取的分类列表和分类级别更新到新增的分类记录里
$db->execute('update `'.$conf['sy']['table_lm'].'` set `list_lm`="'.$list_lm.'",level_lm='.$level_lm.' where id_lm='.$id.'');

msg('添加成功','location="default.php"');
?>
