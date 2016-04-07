<?php 
require('../../../include/common.inc.php');
require('../../../include/uploadfile.class.php');
require('upcon.php');
checklogin();
$frameid=(isset($_REQUEST['frameid']))?$_REQUEST['frameid']:'';
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
if ($s_pic){
	//如果启用生成缩略图，上传的原始图片为大图，生成的缩略图为列表图
	$file_name=$s_arr[0]['s_nam'].date('YmdHis').rand(10,99);
}else{
	//如果不启用生成缩略图，上传的原始图片就是列标图
	$file_name=date('YmdHis').rand(10,99);
}

if (isset($_FILES['file_up'])){
	$file=$_FILES['file_up'];
	$up=new UploadFile();
 	if($row=$up->upLoad($file,$sava_path,$file_name,$allow_types,$max_size,$overfile)){
		$s_name=$row['name'];
		if($s_pic){
			foreach($s_arr as $k=>$v){
				//宽度或高度为0时是不会生成缩略图的
				if ($v['s_wid']!=0&&$v['s_hei']!=0){
					//缩略图的字母名字为空时，这张图作为列表图
					if($v['s_nam']==''){
						//如果是第1张图的缩略图字母名字为空，代表原图自己生成自己
						if ($k==0){
							$k_name=getimgj($row['name'],$v['s_nam']);
						}else{
							$k_name=getimgh($row['name'],$v['s_nam']);
						}
						$s_name=$k_name;
					}else{
						$k_name=getimgh($row['name'],$v['s_nam']);
					}
					$up->makesmall($row['name'],$v['s_typ'],$v['s_wid'],$v['s_hei'],$k_name);
				}
			}
		}
		if ($frameid!=''&&$kuang!=''){
			echo'<script>parent.document.getElementById("'.$kuang.'").value="'.$s_name.'";</script>';
			echo'<script>location="uploadd.php?frameid='.$frameid.'&kuang='.$kuang.'&img_sl='.$s_name.'"</script>';
		}else{
			echo '<script>alert("文件上传成功！");location="'.previous().'";</script>';
			exit();
		}
	}
	else{
		echo '<script>alert("'.$up->error().'");parent.frames["'.$frameid.'"].history.back();</script>';
		exit();
	}
}

?>