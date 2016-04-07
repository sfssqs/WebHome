<?php
require('../../include/common.inc.php');
require('upcon.php');
checklogin();

$lm=isset($_POST['lm'])?html($_POST['lm']):'';
$img_sl=isset($_POST['img_sl'])?html($_POST['img_sl']):'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($lm==''||!checknum($lm)||$img_sl==''||$px==''||!checknum($px)){
	msg('参数错误');
}

//获取所属分类的分类列表
$list_lm='';
$rs=$db->getrs('select list_lm from `'.$tablepre.$table_lm.'` where id_lm='.$lm.'');
if ($rs){
	$list_lm=$rs['list_lm'];
}

//把批量上传组装成一条sql语句
$sql='insert into `'.$tablepre.$table_co.'` (`lm`,`list_lm`,`title`,`img_sl`,`ding`,`tuijian`,`hot`,`pass`,`px`,`wtime`,`ip`) values ';
$a=1;
foreach ($img_sl as $k=>$v){
	if ($img_sl[$k]!=''){
		if ($a==1){
			$sql.='('.$lm.',"'.$list_lm.'","'.$title[$k].'","'.$img_sl[$k].'",0,0,0,1,'.$px[$k].','.time().',"'.getip().'")';
		}else{
			$sql.=',('.$lm.',"'.$list_lm.'","'.$title[$k].'","'.$img_sl[$k].'",0,0,0,1,'.$px[$k].','.time().',"'.getip().'")';
		}
		$a++;
	}
}
$db->execute($sql);

msg('添加成功','location="add.php"');
?>