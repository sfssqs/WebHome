<?php
require('../../include/common.inc.php');
require('../kf_lm/config.php');

checklogin();

$id=isset($_GET['id'])?$_GET['id']:'';
if ($id==''||!checknum($id)){
	msg('参数错误');
}

$row=$db->getrs('select * from `'.$conf['sy']['table_lx'].'` where `id_lm`='.$id.'');
if (!$row){
	msg('该类型不存在或已删除');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改类型</title>
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
<DIV id=popImageLayer style="VISIBILITY: hidden; WIDTH: 267px; CURSOR: hand; POSITION: absolute; HEIGHT: 260px; background-image:url(../images/bbg.gif); z-index: 100;" align=center  name="popImageLayer"  ></DIV>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">修改类型</td>
  </tr>
  <tr class="tdbg">
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加类型</a></td>
  </tr>
</table>

<br />
<FORM name="form1" method="post" action="editt.php" onSubmit="return check()">
<input name="id" type="hidden" id="id" value="<?php echo $id?>"/>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
      <td colspan="2"></td>
  </tr>
  <tr class="tdbg">
    <td width="120" align="right">类型名称：</td>
    <td><INPUT name="title_lm" type="text" id="title_lm" size="30" maxlength="150" value="<?php echo $row['title_lm']?>"> <span class="red">*</span></td>
  </tr>
  <tr class="tdbg">
    <td align="right" valign="top"><br />
      类型代码：</td>
    <td ><textarea name="f_body_lm" rows="6" id="f_body_lm" style="width:670px;"><?php echo $row['f_body_lm']?></textarea></td>
  </tr>
    <tr class="tdbg">
    <td width="120" align="right">显示顺序：</td>
    <td><INPUT name="px" type="text" id="px" size="5" maxlength="10"  value="<?php echo $row['px']?>">
      <span class="red">* (从大到小排序)</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value=" 保 存 " class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value=" 取 消 " onClick="location.href='default.php';" class="btn"></td>
  </tr>
</table>
</FORM>
</body>
</html>
