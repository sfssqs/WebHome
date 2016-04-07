<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$id=isset($_GET['id'])?$_GET['id']:'';
$url=(previous())?previous():'default.php';

//读取会员数据
$row=$db->getrs('select * from `'.$conf['sy']['table_co'].'` where `id`='.$id.'');
if (!$row){
	msg('该信息不存在或已删除');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理首页</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">修改<?php echo $conf['sy']['name']?></td>
  </tr>
  <tr class="tdbg">
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加<?php echo $conf['sy']['name']?></a></td>
  </tr>
</table>
<br />
<FORM id=frm name=frm onSubmit="return checkForm('frm')" action=editt.php method=post>
<input name="id" type="hidden" id="id" value="<?php echo $id?>"/>
<input name="url" type="hidden" id="url" value="<?php echo $url?>"/>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border" id="d_1">
 <tr>
    <td width="120" align="right" class="tdbg">用户名：</td>
    <td class="tdbg"><strong><?php echo $row['username']?></strong></td>
  </tr>
  <tr>
    <td align="right" class="tdbg">密码：</td>
    <td class="tdbg">
    <input  name="password" type="password" class="input_m" style="WIDTH: 150px" size="25" maxlength="20" canEmpty="Y" checkType="password,6,20" checkStr="密码"  /> 
    6-20字母+数字   ，不能使用汉字，<span class="red">为空表示不修改</span></td>
  </tr>
<?php
if ($conf['co']['rename']==true){
?>
  <tr>
        <td align="right" class="tdbg">姓名：</td>
        <td class="tdbg">
        <input name="rename" class=input_m style="WIDTH: 150px" size=25 maxlength="100" id="rename" value="<?php echo $row['rename']?>"/>    </td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['sex']==true){
?>
    <tr>
        <td align="right" class="tdbg">性别： </td>
        <td class="tdbg"><input name="sex" type="radio" class="radio" value="男" <?php if ($row['sex']=='男'){echo 'checked="checked"';}?> />男 <input name="sex" type="radio" class="radio"  value="女" <?php if ($row['sex']=='女'){echo 'checked="checked"';}?> />女 </td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['phone']==true){
?>
    <tr>
        <td align="right" class="tdbg">电话： </td>
        <td class="tdbg">
        <input name=phone class=input_m style="WIDTH: 150px" size=25 maxlength="50" value="<?php echo $row['phone']?>"/></td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['fax']==true){
?>
    <tr>
        <td align="right"  class="tdbg">传真：</td>
        <td class="tdbg">
         <input name=fax class=input_m style="WIDTH: 150px" size=25 maxlength="50" id="mobile"  value="<?php echo $row['fax']?>"/>   </td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['email']==true){
?>
    <tr>
    <td align="right" class="tdbg">
    邮箱：</td>
    <td class="tdbg">
    <input name=email class=input_m style="WIDTH: 150px" size=25 maxlength="50" canEmpty="Y" checkType="email,," checkStr="邮箱" id="email"  value="<?php echo $row['email']?>"/></td>   
  </tr>
<?php
}
?>
<?php
if ($conf['co']['qq']==true){
?>
    <tr>
        <td align="right" class="tdbg">QQ：</td>
        <td class="tdbg">
          <input name=qq class=input_m id="qq" style="WIDTH: 150px" value="<?php echo $row['qq']?>" size=25 maxlength="50" /></td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['wx']==true){
?>
    <tr>
        <td align="right" class="tdbg">微信：</td>
        <td class="tdbg">
          <input name=wx class=input_m id="wx" style="WIDTH: 150px" value="<?php echo $row['wx']?>" size=25 maxlength="50" /></td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['compname']==true){
?> 
    <tr>
        <td align="right" class="tdbg">公司名称：</td>
        <td class="tdbg">
        <input name="compname" class=input_m style="WIDTH: 200px" size=25 maxlength="100" id="compname" value="<?php echo $row['compname']?>">    </td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['address']==true){
?>
  <tr>
        <td align="right" class="tdbg">地址：</td>
        <td class="tdbg">
          <input name=address class=input_m style="WIDTH: 200px" size=25 maxlength="50" value="<?php echo $row['address']?>" /></td>
  </tr>
<?php
}
?>
<?php
if ($conf['co']['post']==true){
?>
    <tr>
        <td align="right" class="tdbg">邮编：</td>
        <td class="tdbg">
          <input name=post class=input_m id="post" style="WIDTH: 150px" value="<?php echo $row['post']?>" size=25 maxlength="50" /></td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['z_body']==true){
?>
    <tr>
        <td align="right" class="tdbg">备注：</td>
        <td class="tdbg">
          <textarea name="z_body" cols="25" rows="5" class="input_m" style="WIDTH: 350px;"><?php echo rehtml($row['z_body'])?></textarea></td>
    </tr>
<?php
}
?>
    <tr>
    <td align="right" class="tdbg">用户状态：</td>
    <td class="tdbg"><input name="pass" type="radio" value="1" <?php if($row['pass']==1){echo ' checked="checked"';}?> /> 未审核&nbsp; <input name="pass" type="radio" value="2"  <?php if($row['pass']==2){echo ' checked="checked"';}?>/> 未通过&nbsp; <input name="pass" type="radio" value="3"  <?php if($row['pass']==3){echo ' checked="checked"';}?>/> 已通过&nbsp; <input name="pass" type="radio" value="4" <?php if($row['pass']==4){echo ' checked="checked"';}?> /> 已屏蔽 </td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value=" 保 存 " class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value=" 取 消 " onClick="location.href='<?php echo $url?>';" class="btn"></td>
  </tr>
</table>
</FORM>
</body>
</html>
