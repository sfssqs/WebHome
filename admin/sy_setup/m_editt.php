<?php
require('../../include/common.inc.php');

checklogin();

$sy_id=isset($_POST['sy_id'])?$_POST['sy_id']:'';
$r_email=isset($_POST['r_email'])?html($_POST['r_email']):'';

if ($sy_id==''||!checknum($sy_id)){
	msg('参数错误');
}

$sql='update `'.$tablepre.'sy_setup` set `r_email`="'.$r_email.'" where `sy_id`='.$sy_id.'';
$db->execute($sql);

msg('保存成功','location="m_edit.php?sy_id='.$sy_id.'"');
?>

