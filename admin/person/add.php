<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加<?php echo $conf['sy']['name']?></title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">添加<?php echo $conf['sy']['name']?></td>
  </tr>
  <tr class="tdbg">
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加<?php echo $conf['sy']['name']?></a></td>
  </tr>
</table>
<br />
<FORM id=frm name=frm onSubmit="return checkForm('frm')" action=addd.php method=post>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
    <td colspan="2">&nbsp;</td>
  </tr>
    <tr>
    <td width="120" align="right" class="tdbg">用户名：</td>
    <td class="tdbg"><input  name="username" type="text" class="input_m" style="WIDTH: 150px" size="25" maxlength="20" canEmpty="N" checkType="username,6,20" checkStr="用户名"/>
      <span class="red">*</span> 6-20字母+数字 ，不能使用汉字 ，<span class="red">添加后不能修改</span> </td>
  </tr>
  <tr>
    <td align="right" class="tdbg">密码：</td>
    <td class="tdbg">
    <input  name="password" type="password" class="input_m" style="WIDTH: 150px" size="25" maxlength="20" canEmpty="N" checkType="password,6,20" checkStr="密码" />  
    <span class="red">*</span> 6-20字母+数字   ，不能使用汉字</td>
  </tr>
<?php
if ($conf['co']['rename']==true){
?>
    <tr>
        <td align="right" class="tdbg">姓名：</td>
        <td class="tdbg">
        <input name="rename" class=input_m style="WIDTH: 150px" size=25 maxlength="100" id="rename">    </td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['sex']==true){
?>
    <tr>
        <td align="right" class="tdbg">性别： </td>
        <td class="tdbg"><input name="sex" type="radio" class="radio" value="男" checked />男 <input name="sex" type="radio" class="radio"  value="女" />女 </td>
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
        <input name=phone class=input_m style="WIDTH: 150px" size=25 maxlength="50"></td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['fax']==true){
?>
    <tr>
        <td align="right" class="tdbg">传真： </td>
        <td class="tdbg">
        <input name=fax class=input_m style="WIDTH: 150px" size=25 maxlength="50"></td>
    </tr>
<?php
}
?>
<?php
if ($conf['co']['email']==true){
?>
    <tr>
        <td align="right" class="tdbg">邮箱：</td>
        <td class="tdbg">
        <input name=email class=input_m style="WIDTH: 150px" size=25 maxlength="50" canEmpty="Y" checkType="email,," checkStr="邮箱" id="email"/></td>   
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
          <input name=qq class=input_m style="WIDTH: 150px" size=25 maxlength="50" ></td>
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
          <input name=wx class=input_m style="WIDTH: 150px" size=25 maxlength="50" ></td>
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
        <input name="compname" class=input_m style="WIDTH: 200px" size=25 maxlength="100" id="compname">    </td>
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
          <input name=address class=input_m style="WIDTH: 200px" size=25 maxlength="50" ></td>
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
          <input name=post class=input_m style="WIDTH: 150px" size=25 maxlength="50" ></td>
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
          <textarea name="z_body" cols="25" rows="5" class="input_m" style="WIDTH: 350px;"></textarea></td>
    </tr>
<?php
}
?>
    <tr>
        <td align="right" class="tdbg">用户状态：</td>
        <td class="tdbg"><input name="pass" type="radio" value="1" /> 未审核&nbsp; <input name="pass" type="radio" value="2" /> 未通过&nbsp; <input name="pass" type="radio" value="3" /> 已通过&nbsp; <input name="pass" type="radio" value="4" /> 已屏蔽</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value="提 交" class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value="取 消" onClick="location.href='default.php';" class="btn"></td>
  </tr>
</table>
</FORM>
</body>
</html>
