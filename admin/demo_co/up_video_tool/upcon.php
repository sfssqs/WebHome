<?php 
//上传文件保存目录,默认是保存到后台的上一级目录upfile文件夹里
$path="upvideo";

//允许上传的文件格式
$allowext="aiff|asf|avi|fla|flv|mid|mov|mp3|mp4|mpc|mpeg|mpg|qt|ram|rm|rmi|rmvb|swf|wav|wma|wmv";

//允许上传的文件大小
$maxsize=20000000;

//上传文件提示尺寸
$s_txt='';

//是否启用生成缩略图
$s_pic=false;

//上面启用生成缩略图后下面的配置才有效
$s_arr=array();

//s_typ true代表生成下面的固定宽度和高度的缩略图 false代表生成不超过下面宽度和高度的缩略图 
//s_nam缩略图的字母名字 例如：upimg/d201409201104.jpg中的d
//s_wid图片的宽度
//s_hei图片的高度
//如果上传一张图要生成多张缩略图增加数组数量就可以了

//原始大图
$s_arr[0]=array('s_typ'=>false,'s_nam'=>'d','s_wid'=>0,'s_hei'=>0);//如果启用生成缩略图，此项不能删除，此数组宽度或高度为0时是不会生成缩略图的
//列表小图
$s_arr[1]=array('s_typ'=>false,'s_nam'=>'','s_wid'=>140,'s_hei'=>100); //如果启用生成缩略图，此项不能删除
//中图
//$s_arr[2]=array('s_typ'=>false,'s_nam'=>'z','s_wid'=>280,'s_hei'=>200);
//小图
//$s_arr[3]=array('s_typ'=>false,'s_nam'=>'x','s_wid'=>70,'s_hei'=>50);

?>
