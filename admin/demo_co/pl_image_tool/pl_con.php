<?php 
//后台建立多个多图上传时的设置-----------------
//保存多图上传记录的表名,默认是各个系统都保存在sy_img表,用$pl_sy_id区分不同系统，可独立建立表名，$pl_sy_id随便设置数字都可以
$pl_table=$tablepre.'sy_img';
//默认情况下各个系统的多图上传记录放到sy_file表中用$pl_sy_id区分不同系统
$pl_sy_id=20;
//信息临时session变量，后台所有的多图上传未添加记录时都是创建一个随机数然后用session来保存的，等信息入库后再更新记录id
$pl_sesname='demo_img_id';

//要使用的字段
$conf['pl']=array(
	//以下是要显示的字段
	'title'=>true,     //标题
	'px'=>true         //排序
);
?>
