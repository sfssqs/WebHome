<?php
require('../../include/common.inc.php');

checklogin();

$sy_id=isset($_POST['sy_id'])?$_POST['sy_id']:'';
$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';

if ($sy_id==''||!checknum($sy_id)){
	msg('参数错误');
}

$sql='update `'.$tablepre.'sy_setup` set `ym_tit`="'.$ym_tit.'",`ym_key`="'.$ym_key.'",`ym_des`="'.$ym_des.'" where `sy_id`='.$sy_id.'';
$db->execute($sql);

msg('保存成功','location="edit.php?sy_id='.$sy_id.'"');
?>

