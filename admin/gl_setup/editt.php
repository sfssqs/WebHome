<?php
require('../../include/common.inc.php');

checklogin();

$ym_tit=isset($_POST['ym_tit'])?html($_POST['ym_tit']):'';
$ym_key=isset($_POST['ym_key'])?html($_POST['ym_key']):'';
$ym_des=isset($_POST['ym_des'])?html($_POST['ym_des']):'';
$ym_bot=isset($_POST['ym_bot'])?$_POST['ym_bot']:'';

$ym_tit_en=isset($_POST['ym_tit_en'])?html($_POST['ym_tit_en']):'';
$ym_key_en=isset($_POST['ym_key_en'])?html($_POST['ym_key_en']):'';
$ym_des_en=isset($_POST['ym_des_en'])?html($_POST['ym_des_en']):'';
$ym_bot_en=isset($_POST['ym_bot_en'])?$_POST['ym_bot_en']:'';

$s_email=isset($_POST['s_email'])?html($_POST['s_email']):'';
$s_password=isset($_POST['s_password'])?html($_POST['s_password']):'';
$s_server=isset($_POST['s_server'])?html($_POST['s_server']):'';
$r_email=isset($_POST['r_email'])?html($_POST['r_email']):'';

$sql='update `'.$tablepre.'gl_setup` set `ym_tit`="'.$ym_tit.'",`ym_key`="'.$ym_key.'",`ym_des`="'.$ym_des.'",`ym_bot`="'.$ym_bot.'",`ym_tit_en`="'.$ym_tit_en.'",`ym_key_en`="'.$ym_key_en.'",`ym_des_en`="'.$ym_des_en.'",`ym_bot_en`="'.$ym_bot_en.'",`s_email`="'.$s_email.'",`s_password`="'.$s_password.'",`s_server`="'.$s_server.'",`r_email`="'.$r_email.'" where `id`=1';
$db->execute($sql);

msg('保存成功','location="edit.php"');

?>

