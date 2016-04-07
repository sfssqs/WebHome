<?php
//后台建立多个相关信息时的设置-----------------
//保存相关信息记录的表名,默认是各个系统都保存在sy_file表,用$pl_sy_id区分不同系统，可独立建立表名，$pl_sy_id随便设置数字都可以
$pl_table=$tablepre.'sy_info';
//默认情况下各个系统的相关信息记录放到sy_file表中用$pl_sy_id区分不同系统
$pl_sy_id=7;
//信息临时session变量，后台所有的相关信息未添加记录时都是创建一个随机数然后用session来保存的，等信息入库后再更新记录id
$pl_sesname='pro_info_id';

//信息要使用的功能和字段
$conf['pl']=array(
	//以下是要使用的功能
	'seo'=>true,           //信息启用seo
	//以下是要显示的字段
	'link_url'=>true,      //链接地址
	'img_sl'=>true         //图片上传
);

//include/config.inc.php的$sy_seo==true同时本系统信息也启用seo，这样信息才算启用seo
if($sy_seo==true&&$conf['pl']['seo']==true){
	$conf['pl']['seo']=true;
}else{
	$conf['pl']['seo']=false;
}
?>