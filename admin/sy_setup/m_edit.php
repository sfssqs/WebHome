<?php
require('../../include/common.inc.php');

checklogin();

$sy_id=isset($_GET['sy_id'])?$_GET['sy_id']:'';

if ($sy_id==''||!checknum($sy_id)){
	msg('参数错误');
}

$row=$db->getrs('select * from `'.$tablepre.'sy_setup` where `sy_id`='.$sy_id.'');
if (!$row){
	msg('没有该记录');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>收件箱设置</title>
<LINK href="../css/admin_style.css" rel="stylesheet" type="text/css">
<script src="../scripts/function.js"></script>
<script src="../scripts/jquery.js"></script>
</head>
<body >
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="border">
	 <tr class="topbg">
		 <td align="center">收件箱设置</td>
	 </tr>
</table>
<br />
<form action="m_editt.php" method="post" name="form1" >
<input type="hidden" name="sy_id"  value="<?php echo $sy_id?>">
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="border">
 <tr class="title">
 <td colspan="2" align="center"></td>
 </tr>

  <tr class="tdbg">
    <td width="120" height="22" align="right" class="tdbg">收件箱：</td>
    <td><textarea name="r_email" cols="80" rows="3"><?php echo rehtml($row['r_email'])?></textarea><br />
	多个收件箱请用"|"隔开
    </td>
  </tr>

</table>
<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value="保 存" class="btn"></td>
  </tr>
</table> 
</form>
</body>
</html>
