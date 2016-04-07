<?php
require('../../include/common.inc.php');
require('../job_lm/config.php');

checklogin();

$id=isset($_GET['id'])?$_GET['id']:'';
$url=(previous())?previous():'default.php';

if ($id==''||!checknum($id)){
	msg('参数错误');
}

$row=$db->getrs('select * from `'.$conf['sy']['table_yp'].'` where `id`='.$id.'');
if (!$row){
	msg('该招聘不存在或已删除');
}
$db->execute('update `'.$conf['sy']['table_yp'].'` set chakan=1 where `id`='.$id.'');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改招聘</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td>查看应聘</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="tdbg">
    <td width="120" height="20"  align="right">应聘职位：</td>
    <td><?php echo $row['job_title']?></td>
  </tr>
    <tr class="tdbg">
    <td width="120" height="20"  align="right">姓　　名：</td>
    <td><?php echo $row['username']?></td>
  </tr>
    <tr class="tdbg">
    <td width="120" height="20"  align="right">联系电话：</td>
    <td><?php echo $row['phone']?></td>
  </tr>
    <tr class="tdbg">
    <td width="120" height="20"  align="right">电子邮箱：</td>
    <td><?php echo $row['email']?></td>
  </tr>
      <tr class="tdbg">
    <td width="120" height="20"  align="right">备　　注：</td>
    <td><textarea name="textarea" cols="45" rows="6"><?php echo rehtml($row['z_body'])?></textarea></td>
  </tr>
     <tr class="tdbg">
    <td width="120" height="20"  align="right">上传附件：</td>
    <td>
    
    <a href="<?php echo '../../'.$row['up_sl']?>" target="_blank">下载附件</a>
    </td>
  </tr>
  <tr class="tdbg">
    <td width="120" height="20"  align="right">应聘时间：</td>
    <td><?php echo date('Y-m-d H:i:s',$row['wtime'])?></td>
  </tr>
     <tr class="tdbg">
    <td width="120" height="20"  align="right">应聘　IP：</td>
    <td><?php echo $row['ip']?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input name="Cancel" type="button" id="Cancel" value="返回列表" onClick="location='<?php echo $url?>';" class="btn"></td>
  </tr>
</table>
</body>
</html>
