<?php 
require('../common.inc.php');
require('../uploadfile.class.php');
require('upcon.php');

$kuang=(isset($_REQUEST['kuang']))?$_REQUEST['kuang']:'';

//文件路径
$sava_path=$path;
//允许上传的文件类型
$allow_types=$allowext;
//允许上传的大小
$max_size=$maxsize;
//是否可以覆盖
$overfile=false;
//文件名
$file_name=date('YmdHis').rand(10,99);

if (isset($_FILES['file_up'])){
	$file=$_FILES['file_up'];
	$up=new UploadFile();
 	if($row=$up->upLoad($file,$sava_path,$file_name,$allow_types,$max_size,$overfile)){
		$s_name=$row['name'];
		if ($kuang!=''){
			echo'<script>parent.document.getElementById("'.$kuang.'").value="'.$s_name.'";</script>';
			echo'<script>location="uploadd.php?kuang='.$kuang.'&img_sl='.$s_name.'"</script>';
		}else{
			echo '<script>alert("文件上传成功！");location="'.previous().'";</script>';
			exit();
		}
	}
	else{
		echo '<script>alert("'.$up->error().'");</script>';
		exit();
	}
}

?>