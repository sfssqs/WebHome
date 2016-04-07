<?php 
require('../../../include/common.inc.php');
require('../../../include/uploadfile.class.php');
require('upcon.php');
checklogin();
$frameid=(isset($_REQUEST['frameid']))?$_REQUEST['frameid']:'';
$kuang=(isset($_REQUEST['kuang']))?$_REQUEST['kuang']:'';
$s_pic=(isset($_REQUEST['s_pic']))?$_REQUEST['s_pic']:'';
$s_typ=(isset($_REQUEST['s_typ']))?$_REQUEST['s_typ']:'';
$s_wid=(isset($_REQUEST['s_wid']))?$_REQUEST['s_wid']:'';
$s_hei=(isset($_REQUEST['s_hei']))?$_REQUEST['s_hei']:'';
if ($s_pic=='yes'){
	$s_pice=true;
}else{
	$s_pice=false;
}
if ($s_typ=='yes'){
	$s_type=true;
}else{
	$s_type=false;
}
//文件路径
$sava_path=$path;
//文件名,如果为空，就用上传的文件的名
if ($s_pice){
	$file_name='d'.date('YmdHis').rand(10,99);
}else{
	$file_name=date('YmdHis').rand(10,99);
}

//允许上传的文件类型
$allow_types=$allowext;
//允许上传的大小
$max_size=$maxsize;
//是否可以覆盖
$overfile=false;

if (isset($_FILES['file_up'])){
	$file=$_FILES['file_up'];
	$up=new UploadFile();
	if($row=$up->upLoad($file,$sava_path,$file_name,$allow_types,$max_size,$overfile)){
		$s_name=$row['name'];
		if($s_pice){
			//宽度或高度为0时是不会生成缩略图的
			if ($s_wid!=0&&$s_hei!=0){
				$s_name=getimgh($row['name'],'');
				$up->makesmall($row['name'],$s_type,$s_wid,$s_hei,$s_name);
			}
		}
		
		//原图片文件名--upimg/d20150110101836.jpg
		//字体大小默认10
		//文件的角度默认0--顺时针方向开始
		//文字离左边的距离--x轴坐标,必须要大于等于0才有效
		//文字离上边的距离--y轴坐标（是左下角开始的，要加上字体高度）,必须要大于等于0才有效
		//文字水印所用的字体文件路径
		//文字水印的文字
		//文字水印的位置1右上角，2右下角，3左下角，4左上角，5居中--位置依托$width,$height来计算（如果前面定义了x,y坐标$wz就不起作用了）
		//文字水印的宽度--用于设置文字水印的位置 （如果前面定义了x,y坐标$width就不起作用了）
		//文字水印的高度--用于设置文字水印的位置（如果前面定义了x,y坐标$height就不起作用了）
		
		//$up->makefont($row['name'],30,0,-1,-1,'arial.ttf','Myname',5,146,37);
		
		//原图片文件名
		//图片水印在原图上的x轴坐标(必须要大于等于0才有效)
		//图片水印在原图上的y轴坐标(必须要大于等于0才有效)
		//图片水印文件名(默认放到include文件夹里)
		//图片水印的位置1右上角，2右下角，3左下角，4左上角，5居中（如果前面定义了x,y坐标$wz就不起作用了）
		
		//$up->makepic($row['name'],-1,-1,'1.png',5);
		
		if ($frameid!=''&&$kuang!=''){
			echo'<script>parent.document.getElementById("'.$kuang.'").value="'.$s_name.'";</script>';
			echo'<script>location="uploadd.php?frameid='.$frameid.'&kuang='.$kuang.'&img_sl='.$s_name.'&s_pic='.$s_pic.'&s_typ='.$s_typ.'&s_wid='.$s_wid.'&s_hei='.$s_hei.'"</script>';
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