<?php
require('../../../include/common.inc.php');
require('upcon.php');
checklogin();
$frameid=(isset($_REQUEST['frameid']))?$_REQUEST['frameid']:'';
$kuang=(isset($_REQUEST['kuang']))?$_REQUEST['kuang']:'';
$s_pic=(isset($_REQUEST['s_pic']))?$_REQUEST['s_pic']:'';
$s_typ=(isset($_REQUEST['s_typ']))?$_REQUEST['s_typ']:'';
$s_wid=(isset($_REQUEST['s_wid']))?$_REQUEST['s_wid']:'';
$s_hei=(isset($_REQUEST['s_hei']))?$_REQUEST['s_hei']:'';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传文件</title>
<link href="../../css/admin_style.css"  type="text/css" rel="stylesheet">
<style>
body{margin:0px; padding:0px; background-color:#e5ebf1; height:21px; line-height:21px;overflow:hidden;}
html{margin:0px; padding:0px;overflow:hidden;background-color:#e5ebf1;}
.btn{ height:20px;}
input{ font-size:12px;}
</style>
<script src="../../scripts/function.js"></script>
<script language="javascript">
function check()
{
var sAllowExt="<?php echo $allowext?>";
file_up=document.formn.file_up;
if (file_up.value=="")
{
  alert('提示：请选择要上传的文件！');
  return false
}

if (!IsExt(file_up.value,sAllowExt))
{
	alert("提示：\n\n请选择一个有效的文件，\n支持的格式有（"+sAllowExt+"）！");
	return false;
}

gt('formn').action="upload.php?frameid=<?php echo $frameid?>&kuang=<?php echo $kuang?>&s_pic=<?php echo $s_pic?>&s_typ=<?php echo $s_typ?>&s_wid=<?php echo $s_wid?>&s_hei=<?php echo $s_hei?>"
gt('formn').submit();
} 
// 是否有效的扩展名
function IsExt(url, opt){
	var sTemp;
	var b=false;
	var s=opt.toUpperCase().split("|");
	for (var i=0;i<s.length ;i++ ){
		sTemp=url.substr(url.length-s[i].length-1);
		sTemp=sTemp.toUpperCase();
		s[i]="."+s[i];
		if (s[i]==sTemp){
			b=true;
			break;
		}
	}
	return b;
}
</script>

</head>

<body>
<form name="formn" id="formn" method="POST" enctype="multipart/form-data" >  
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxsize?>" />  
<input type="file" name="file_up" size="20" enctype="multipart/form-data">
<input name=mysubm  type="button" value="上传"  onclick="check()" class="btn">     
</form> 
</body>
</html>
