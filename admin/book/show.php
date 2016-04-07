<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$id=isset($_GET['id'])?$_GET['id']:'';
$url=(isset($_GET['url'])&&$_GET['url']!='')?$_GET['url']:previous();

if ($id==''||!checknum($id)){
	msg('参数错误');
}

$htime='';
$h_body='';
$row=$db->getrs('select * from `'.$conf['sy']['table_co'].'` where `id`='.$id.'');
if (!$row){
	msg('该信息不存在或已删除');
}else{
	$db->execute('update `'.$conf['sy']['table_co'].'` set `chakan`=1 where `id`='.$id.'');
	$rs=$db->getrs('select  * from `'.$conf['sy']['table_co'].'` where `id_re`='.$id.' limit 1');
	if ($rs){
		$htime=$rs['wtime'];
		$h_body=$rs['z_body'];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看<?php echo $conf['sy']['name']?></title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
</head>
<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">查看<?php echo $conf['sy']['name']?></td>
  </tr>
</table>
<br />
<form action="addd.php" method="post"  name="form1">
<input name="id"  value="<?php echo $id?>" type="hidden">
<input name="url"  value="<?php echo $url?>" type="hidden">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
<?php
if ($conf['co']['title']==true){
?>
  <tr class="title">
    <td align="right">标题：</td>
    <td><?php echo $row['title']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['num']==true){
?>
  <tr class="tdbg">
    <td align="right">数量：</td>
    <td><?php echo $row['num']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['rename']==true){
?>
  <tr class="tdbg">
    <td align="right">姓名：</td>
    <td><?php echo $row['rename']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['sex']==true){
?>
  <tr class="tdbg">
    <td align="right">性别：</td>
    <td><?php echo $row['sex']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['phone']==true){
?>
  <tr class="tdbg">
    <td align="right">电话：</td>
    <td><?php echo $row['phone']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['fax']==true){
?>
  <tr class="tdbg">
    <td align="right">传真：</td>
    <td><?php echo $row['fax']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['email']==true){
?>
  <tr class="tdbg">
    <td align="right">邮箱：</td>
    <td><?php echo $row['email']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['qq']==true){
?>
  <tr class="tdbg">
    <td align="right">QQ：</td>
    <td><?php echo $row['qq']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['wx']==true){
?>
  <tr class="tdbg">
    <td align="right">微信：</td>
    <td><?php echo $row['wx']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['compname']==true){
?>
  <tr class="tdbg">
    <td align="right">公司名称：</td>
    <td><?php echo $row['compname']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['address']==true){
?>
  <tr class="tdbg">
    <td align="right">地址：</td>
    <td><?php echo $row['address']?></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['post']==true){
?>
  <tr class="tdbg">
    <td align="right">邮编：</td>
    <td><?php echo $row['post']?></td>
  </tr>
<?php
}
?>
  <tr class="tdbg">
    <td align="right">IP：</td>
    <td><?php echo $row['ip']?></td>
  </tr>
  <tr class="tdbg">
    <td align="right">时间：</td>
    <td><?php echo date('Y-m-d H:i:s',$row['wtime'])?></td>
  </tr>
    <TR class="tdbg2" >
      <TD width="27%" height="40" align="right" class="tdbg2">留言内容：</TD>
      <TD width="73%" align="left" valign="top" class="tdbg2"><textarea name="z_body" cols="60" rows="6"><?php echo rehtml($row['z_body'])?></textarea></TD>
    </TR>
    <?php
    if ($conf['sy']['huifu']==true){
	?>
    <?php
    if ($htime!=''){
	?>
    <tr class="tdbg">
      <td height="20" align="right">回复时间：</td>
      <td><?php echo date('Y-m-d H:i:s',$htime)?></td>
    </tr>
    <?php
    }
	?>
    <TR >
      <TD width="27%" height="50" align="right" valign="top" class="tdbg2">回复内容：</TD>
      <TD width="73%" align="left" valign="top" class="tdbg2"><textarea name="h_body" cols="60" rows="6"><?php echo rehtml($h_body)?></textarea>
        <br>
      </TD>
    </TR>
    <?php
    }
	?>
</table>
<table width="100%"  border="0" cellpadding="2" cellspacing="1">
  <tr>
  	<TD width="27%"  align="right" valign="top"></TD>
    <td height="26" style="padding-left:6px;">
    <?php
    if ($conf['sy']['huifu']==true){
	?>
      <input name="Submit" type="submit" class="btn" value="回 复">
    <?php
    }else{
	?>
      <input name="Submit" type="submit" class="btn" value="修 改">
    <?php
    }
	?>
      &nbsp;&nbsp;
    <input name="Submit2" type="button" class="btn"  value="返 回" onClick="location.href='<?php echo $url?>';"></td>
  </tr>
</table>
</form>
</body>
</html>
