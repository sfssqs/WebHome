<?php 
require('../../../include/common.inc.php');
require('../../../include/uploadfile.class.php');
require('pl_con.php');
checklogin();

$pl_id=isset($_POST['pl_id'])?$_POST['pl_id']:'';
$title=isset($_POST['title'])?html($_POST['title']):'';
$img_sl=isset($_POST['img_sl'])?html($_POST['img_sl']):'';
$px=isset($_POST['px'])?html($_POST['px']):'';

if ($pl_id!=''&&!checknum($pl_id)){
	exit('参数错误');
}

if ($img_sl==''||$px==''||!checknum($px)){
	msg('参数错误');
}

//如果没有$pl_id传入进来，系统生成一个临时id用session来保存
if($pl_id==''||!checknum($pl_id)){
	if(isset($_SESSION[$pl_sesname])&&$_SESSION[$pl_sesname]!=''&&checknum($_SESSION[$pl_sesname])){
		$pr_id=$_SESSION[$pl_sesname];
	}else{
		$pr_id=date('His').rand(10,99);
		$_SESSION[$pl_sesname]=$pr_id;
	}
}else{
	$pr_id=$pl_id;	
}

//把批量上传组装成一条sql语句
$sql='insert into `'.$pl_table.'` (`sy_id`,`pl_id`,`title`,`img_sl`,`px`) values ';
$a=1;
foreach ($img_sl as $k=>$v){
	if ($img_sl[$k]!=''){
		if ($a==1){
			$sql.='('.$pl_sy_id.','.$pr_id.',"'.$title[$k].'","'.$img_sl[$k].'",'.$px[$k].')';
		}else{
			$sql.=',('.$pl_sy_id.','.$pr_id.',"'.$title[$k].'","'.$img_sl[$k].'",'.$px[$k].')';
		}
		$a++;
	}
}
$db->execute($sql);
msg("","location='pl_default.php?pl_id=".$pl_id."'");
?>