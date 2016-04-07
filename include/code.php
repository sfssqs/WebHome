<?php
$s=isset($_GET['s'])?$_GET['s']:'';//如果需要多个session时，请传入值
if($s!=''&&!is_integer($s)){
	$s='';
} 
$len=4;
$width=60;//验证码宽度
$height=20;//验证码高度
$code=getrandnum($len);
session_start();
$_SESSION['safecode'.$s]=strtolower($code);
$im=imagecreate($width,$height);//根据宽度和高度创建一个图片
$back=imagecolorallocate($im,240,243,248);//创建一个颜色，第一个默认为图片的背景
$pix=imagecolorallocate($im,105,148,220);//点的颜色
$line[0]=imagecolorallocate($im,rand(0,30),rand(0,15),rand(140,260));//创建线条和字体的颜色
$line[1]=imagecolorallocate($im,rand(0,30),rand(0,15),rand(140,260));
$line[2]=imagecolorallocate($im,rand(0,30),rand(0,15),rand(140,260));
$line[3]=imagecolorallocate($im,rand(0,30),rand(0,15),rand(140,260));
//在$im图片上创建100个模糊点
for($i=0;$i<100;$i++)
{
imagesetpixel($im,rand(0,$width),rand(0,$height),$pix);
}
//在$im图片上创建3条直线
for($i=0;$i<1;$i++)
{
imageline($im,rand(0,$height),rand(0,$height),rand($width-$height,$width),rand(0,$height),$line[rand(0,3)]);
}
for($i=0;$i<3;$i++){
    $arc_color = imagecolorallocate($im,rand(190,210),rand(190,210),rand(190,210)); //弧线颜色
    imagearc($im,rand(0,$width),rand(0,$height),$width,$height,rand(0,$width),rand(0,$height),$arc_color); //画弧线
}
//在$im图片上创建验证码
for($i=0;$i<$len;$i++)
{
imagestring($im,rand(4,10),$i*rand(13,16)+rand(1,3),rand(0,$height-14),$code[$i],$line[rand(0,$i)]);
}
//头部文件，禁止缓存
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
//把验证码图片那image/gif编码 
header("Content-Type:image/jpeg");
//输出jpeg格式图片
imagegif($im);
imagedestroy($im);
//创建随机验证码
function getrandnum($len)
{
$chars=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','R','S','T','U','V','W','S','Y','Z',1,2,3,4,5,6,7,8,9);
$charslen=count($chars)-1;
shuffle($chars);
$strs="";
for($a=0;$a<$len;$a++)
{
$strs.=$chars[rand(0,$charslen)];
}
return $strs;
}
?>
