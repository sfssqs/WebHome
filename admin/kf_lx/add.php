<?php
require('../../include/common.inc.php');
require('../kf_lm/config.php');

checklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加类型</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
<SCRIPT language="JavaScript" type="text/JavaScript">
function check(){
	if(gt('title_lm').value==''){
		alert('类型名称不能为空');
		gt('title_lm').focus();
		return false;
	}
	if(gt('px').value==''){
		alert('类型的显示顺序不能为空');
		gt('px').focus();
		return false;
	}
}
</SCRIPT>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">添加类型</td>
  </tr>
  <tr class="tdbg" >
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加类型</a></td>
  </tr>
</table>

<br />
<FORM name="form1" method="post" action="addd.php" onSubmit="return check()">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
      <td colspan="2"></td>
  </tr>
  <tr class="tdbg">
    <td width="120" align="right">类型名称：</td>
    <td><INPUT name="title_lm" type="text" id="title_lm" size="30" maxlength="150"> <span class="red">*</span></td>
  </tr>
  <tr class="tdbg">
    <td align="right" valign="top"><br />
      类型代码：</td>
    <td ><textarea name="f_body_lm" rows="6" id="f_body_lm" style="width:670px;"></textarea></td>
  </tr>
    <tr class="tdbg">
    <td width="120" align="right">显示顺序：</td>
    <td><INPUT name="px" type="text" id="px" value="100" size="5" maxlength="11" >
     <span class="red">* (从大到小排序)</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value=" 提 交 " class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value=" 取 消 " onClick="location.href='default.php';" class="btn"></td>
  </tr>
</table>
</FORM>
</body>
</html>
