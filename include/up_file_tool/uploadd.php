<?php
require('../common.inc.php');
require('upcon.php');

$ac=(isset($_GET['ac']))?$_GET['ac']:'';
$kuang=(isset($_GET['kuang']))?$_GET['kuang']:'';
$img_sl=(isset($_GET['img_sl']))?$_GET['img_sl']:'';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
body{margin:0px; padding:0px; background-color:#e5ebf1; height:21px; line-height:21px;overflow:hidden; font-size:12px;}
html{margin:0px; padding:0px;overflow:hidden;background-color:#e5ebf1;}
</style>
</head>

<body >
<?php
if($ac==''){
	if($img_sl==''){
		echo'<script>location="up.php?kuang='.$kuang.'"</script>';
	}else{
		echo'<a href="uploadd.php?kuang='.$kuang.'&img_sl='.$img_sl.'&ac=del" onclick="return confirm(\'确定要删除文件吗？\')">删除文件,重新上传</a>';
	}
}elseif($ac=='del'){
	if($img_sl!=''){
		delfile($img_sl);
	}
	echo'<script>parent.document.getElementById("'.$kuang.'").value="";</script>';
	echo'<script>location="up.php?kuang='.$kuang.'"</script>';
}
?>
</body>
</html>