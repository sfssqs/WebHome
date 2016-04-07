<?php 
require('../include/common.inc.php');
chklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员密码修改</title>
<link href="css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="scripts/function.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="1"  cellpadding="2" class="border">
  <tr class="topbg">
    <td>管理员密码修改</td>
  </tr>
</table>
<br />
<form name="form1" method="post" action="admin_regg.php" >
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr class="tdbg">
    <td width="200" align="right">用户名：</td>
    <td><input name="username" type="text"  size="20" maxlength="12" style="width:100pt;" ></td>
  </tr>
  <tr class="tdbg">
    <td align="right">原密码：</td>
    <td><input name="password" type="password"  size="20" maxlength="12" style="width:100pt;"  ></td>
  </tr>
  <tr class="tdbg">
    <td align="right">新用户：</td>
    <td><input name="username1" type="text"  size="20" maxlength="12" style="width:100pt;" > <span class="red">(6-12位,大小写不区分,不能使用汉字和非法字符)</span></td>
  </tr>
  <tr class="tdbg">
    <td align="right">新密码：</td>
    <td><input name="password1" type="password"  size="20" maxlength="12" style="width:100pt;"  ></td>
  </tr>
  <tr class="tdbg">
    <td align="right">确认密码：</td>
    <td><input name="password2" type="password"  size="20" maxlength="12" style="width:100pt;"  ></td>
  </tr>
</table>
<p align="center">
<input type="submit" name="Submit" value=" 提 交 " class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value=" 取 消 " onClick="location.href='main.php';" class="btn">
</p>
</form>
</body>
</html>
