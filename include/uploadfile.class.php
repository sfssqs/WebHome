<?php
if(!defined('IN_MO')){
	exit('Access Denied');
}
class UploadFile{
	public $max_size;
	public $allow_types;
	protected $file_type = array();
	public $sava_path;
	public $file_name;
	public $error;
	public $overfile;
	protected $save_folder;
	
	public function __construct(){

	}
	
	public function __destruct(){

	}

	/**
	 *上传文件
	 *$file文件对象
	 *$save_folder保存的文件夹
	 *$file_name文件名不带扩展名
	 *$allow_types允许上传的扩展名
	 *$max_size上传大小
	 *$overfile是否覆盖相同文件名
	 *return 上传文件的属性数组--现文件名，文件大小，文件扩展名，文件原名字，错误信息
	 */
	public function upLoad($file,$save_folder,$file_name,$allow_types='jpg|gif|png|zip|rar|txt|html|bmp|pdf',$max_size=2000000000,$overfile=false){
		
		$this->save_folder=$save_folder;
		$this->sava_path=MO_ROOT.'/'.$save_folder.'/';
		$this->file_name=$file_name;
		$this->allow_types=$allow_types;
		$this->max_size=$max_size;
		$this->overfile=$overfile;
		
		$up_file_name = $file['name']; 
		$up_file_type = $file['type'];
 		$up_file_size = $file['size']; 
		$up_file_tmp_name = $file['tmp_name'];
		$up_file_error = $file['error'];
		
		$fileext=$this->fileext($up_file_name);
		$this->file_name=$this->file_name?$this->file_name.'.'.$fileext:$up_file_name;
		$new_name=$this->sava_path.$this->file_name;
		
		//判断上传到临时文件夹的错误
		if($up_file_error!=0){
			$this->error=$up_file_error;
			return false;
		}
		//判断是否通过post上传的文件
		if (!is_uploaded_file($up_file_tmp_name)){
			$this->error = 12;
			return false;
		}
		//判断文件类型
		if(!in_array($fileext,explode('|',$this->allow_types))){
			$this->error=10;
			return false;
		}
		//判断文件大小
		if($up_file_size>$this->max_size){
			$this->error=11;
			return false;
		}
		//判断路径
		if(!$this->setSavaPath()){
			$this->error=8;
			return false;
		}
		//判断临时文件是否存在
		if(!file_exists($up_file_tmp_name)){
			$this->error=7;
			return false;
		}
		//判断出现重名是否覆盖原文件
		if(file_exists($new_name)&&!$this->overfile){
			$this->error=9;
			return false;
		}
		//移动文件
		if(function_exists('move_uploaded_file')){
			$state=move_uploaded_file($up_file_tmp_name, $new_name);
		}else if(function_exists('rename')){
			$state=rename($up_file_tmp_name, $new_name);
		}else if(function_exists('copy')){
			$state=copy($up_file_tmp_name, $new_name);
		}
		if (!$state){
			$this->error=13;
			return false;
		}else{
			$file_info = array('name'=>$this->save_folder.'/'.$this->file_name,'size'=>$up_file_size,'type'=>$fileext,'yname'=>$up_file_name,'error'=>$this->error);
			return $file_info;
		}
	}

	/**
	 *生成缩略图
	 *$file原文件名--upimg/d20150110101836.jpg
	 *$dtype生成目标文件类型（true固定大小，false不超过宽度和高度等比例缩小）
	 *$dwidth生成目标文件宽度
	 *$dheight生成目标文件高度
	 *$dfile生成目标文件名--upimg/20150110101836.jpg
	 */   
	public function makesmall($file,$dtyp,$dwidth,$dheight,$dfile){
		$sfile=MO_ROOT.'/'.$file;
		$dfile=MO_ROOT.'/'.$dfile;
		if (file_exists($sfile)){
			if ($info=getimagesize($sfile)){
				$swidth=$info[0];
				$sheight=$info[1];
				$stype=$info[2];
				if($sim=$this->getfileim($sfile,$stype)){
					if(!$dtyp){
						if ($swidth>$sheight){
							if ($swidth>$dwidth){
								$dwid=$dwidth;
								$dhei=ceil($dwid*$sheight/$swidth);
								if ($dhei>$dheight){
									$dwid=ceil($dheight*$swidth/$sheight);
									$dhei=$dheight;
								}
							}else{
								$dwid=$swidth;
								$dhei=$sheight;
							}
						}else{
							if($sheight>$dheight){
								$dhei=$dheight;
								$dwid=ceil($dheight*$swidth/$sheight);
								if ($dwid>$dwidth){
									$dhei=ceil($dwidth*$sheight/$swidth);
									$dwid=$dwidth;
								}
							}else{
								$dwid=$swidth;
								$dhei=$sheight;
							}
						}
					}else{
						$dwid=$dwidth;
						$dhei=$dheight;	
					}
					
					//gif 如果是gif就是先创建一个透明的图像
					if ($stype==1){
						//根据宽度和高度返回图像标识符
						$dim=imagecreatetruecolor($dwid,$dhei);
						//为一幅图像分配颜色返回颜色标识符
						$bg=imagecolorallocate($dim,255,255,255);
						//在$dim图像中画一个用$bg颜色填充了的矩形 成功返回true 不成功返回false
						imagefilledrectangle($dim,0,0,$dwid,$dhei,$bg); 
						//将$dim图像中的$bg设定为透明色。一旦设定了某个颜色为透明色，图像中之前画为该色的任何区域都成为透明的。
						imagecolortransparent($dim,$bg);
					//png
					}elseif($stype==3){
						imagesavealpha($sim,true);//设置标记以在保存 PNG 图像时保存完整的 alpha 通道信息  
						$dim=imagecreatetruecolor($dwid,$dhei);  
						imagealphablending($dim,false);//设定图像的混色模式,这里的意思是设定$dim不合并颜色;  
						imagesavealpha($dim,true);//设置标记以在保存 PNG 图像时保存完整的 alpha 通道信息
					//其他jpg bmp
					}else{
						$dim =imagecreatetruecolor($dwid,$dhei);
					}
					//重采样拷贝部分图像并调整大小--在这里是完全拷贝，只是缩小图片，此函数缩小的图片小而质量高
					imagecopyresampled($dim,$sim,0,0,0,0,$dwid,$dhei,$swidth,$sheight);

					if($this->createfileim($dim,$stype,$dfile,95)){
						imagedestroy($sim);
						imagedestroy($dim);
					}else{
						$this->error=15;
						return false;
					}
				}			
			}
		}
	}
	
	/**
	 *生成文字水印
	 *$file原图片文件名--upimg/d20150110101836.jpg
	 *$font字体大小默认10
	 *$jd文件的角度默认0--顺时针方向开始
	 *$x文字离左边的距离--x轴坐标,必须要大于等于0才有效
	 *$y文字离上边的距离--y轴坐标（是左下角开始的，要加上字体高度）,必须要大于等于0才有效
	 *$ttf文字水印所用的字体文件路径
	 *$text文字水印的文字
	 *$wz文字水印的位置1右上角，2右下角，3左下角，4左上角，5居中--位置依托$width,$height来计算（如果前面定义了x,y坐标$wz就不起作用了）
	 *$width文字水印的宽度--用于设置文字水印的位置 （如果前面定义了x,y坐标$width就不起作用了）
	 *$height文字水印的高度--用于设置文字水印的位置（如果前面定义了x,y坐标$height就不起作用了）
	 */
	public function makefont($file,$font=10,$jd=0,$x=0,$y=0,$ttf,$text,$wz=5,$width=0,$height=0){
		$sfile=MO_ROOT.'/'.$file;
		$ttf=MO_ROOT.'/include/'.$ttf;
		if (file_exists($sfile)){
			if ($info=getimagesize($sfile)){
				$swidth=$info[0];
				$sheight=$info[1];
				$stype=$info[2];
				if($sim=$this->getfileim($sfile,$stype)){
				
					//png的图片要保留透明
					if($stype==3){
						imagesavealpha($sim,true);//设置标记以在保存 PNG 图像时保存完整的 alpha 通道信息  
					}

					//设置两个颜色是想字体更好看
					$black = imagecolorallocatealpha($sim, 0,0,0,100);
					$white = imagecolorallocatealpha($sim, 255,255,255,80);
					
					//如果$x,$y设置了大于等于0的值（负数代表不设置坐标），就直接定位
					if ($x>=0&&$y>=0){
						$textsx=$x-($font*0.08)-1;
						$textsy=$y+$font-1;
						$textxx=$x-($font*0.08);
						$textxy=$y+$font;
					//右上角
					}elseif($wz==1){
						$textsx=($swidth-$width)-($font*0.08)-1;
						$textsy=$font-1;
						$textxx=($swidth-$width)-($font*0.08);
						$textxy=$font;
					//右下角
					}elseif($wz==2){
						$textsx=($swidth-$width)-($font*0.08)-1;
						$textsy=($sheight-$height)+$font-1;
						$textxx=($swidth-$width)-($font*0.08);
						$textxy=($sheight-$height)+$font;
					//左下角
					}elseif($wz==3){
						$textsx=-($font*0.08)-1;
						$textsy=($sheight-$height)+$font-1;
						$textxx=-($font*0.08);
						$textxy=($sheight-$height)+$font;
					//左上角	
					}elseif($wz==4){
						$textsx=-($font*0.08)-1;
						$textsy=$font-1;
						$textxx=-($font*0.08);
						$textxy=$font;
					//居中
					}elseif($wz==5){
						$textsx=($swidth-$width)/2-($font*0.08)-1;
						$textsy=($sheight-$height)/2+$font-1;
						$textxx=($swidth-$width)/2-($font*0.08);
						$textxy=($sheight-$height)/2+$font;
					}
					
					//文件 字体 角度 文字在图片上x轴坐标 文字在图片上y轴坐标 文字水印字体文件路径 文字
					imagettftext($sim,$font,$jd,$textsx,$textsy,$black,$ttf,$text);
					imagettftext($sim,$font,$jd,$textxx,$textxy,$white,$ttf,$text);
					
					if($this->createfileim($sim,$stype,$sfile,95)){
						imagedestroy($sim);
					}else{
						$this->error=15;
						return false;
					}
				}			
			}
		}
	}
	
	
	/**
	 *生成图片水印
	 *$sfile原图片文件名--upimg/d20150110101836.jpg
	 *$x图片水印离左边的距离--x轴坐标,必须要大于等于0才有效
	 *$y图片水印离上边的距离--y轴坐标,必须要大于等于0才有效
	 *$wfile图片水印文件名（默认放在include文件夹里）
	 *$wz图片水印的位置1右上角，2右下角，3左下角，4左上角，5居中（如果前面定义了x,y坐标$wz就不起作用了）
	 */
	public function makepic($sfile,$x=0,$y=0,$wfile,$wz=5){
		$sfile=MO_ROOT.'/'.$sfile;
		$wfile=MO_ROOT.'/include/'.$wfile;
		if (file_exists($sfile)&&file_exists($wfile)){
			if ($sinfo=getimagesize($sfile)){
				$swidth=$sinfo[0];
				$sheight=$sinfo[1];
				$stype=$sinfo[2];
				
				$winfo=getimagesize($wfile);
				$wwidth=$winfo[0];
				$wheight=$winfo[1];
				$wtype=$winfo[2];
				
				if($sim=$this->getfileim($sfile,$stype)){
				$wim=$this->getfileim($wfile,$wtype);
					//gif					
					if ($stype==1){
						$dim=imagecreatetruecolor($swidth,$sheight);
						$bg=imagecolorallocate($dim,255,255,255);  
						imagefilledrectangle($dim,0,0,$swidth,$sheight,$bg);  
						imagecolortransparent($dim,$bg);
						imagecopy($dim,$sim,0,0,0,0,$swidth,$sheight);
						$sim=$dim;
					//png
					}elseif($stype==3){
						imagealphablending($sim, true);
						imagesavealpha($sim, true);
					}
					
					//如果$x,$y设置了大于等于0的值（负数代表不设置坐标），就直接定位
					if ($x>=0&&$y>=0){
						$waterx=$x;
						$watery=$y;
					//右上角
					}elseif($wz==1){
						$waterx=$swidth-$wwidth;
						$watery=0;
					//右下角
					}elseif($wz==2){
						$waterx=$swidth-$wwidth;
						$watery=$sheight-$wheight;
					//左下角
					}elseif($wz==3){
						$waterx=0;
						$watery=$sheight-$wheight;
					//左上角	
					}elseif($wz==4){
						$waterx=0;
						$watery=0;
					//居中
					}elseif($wz==5){
						$waterx=($swidth-$wwidth)/2;
						$watery=($sheight-$wheight)/2;
					}
					
					imagecopy($sim, $wim, $waterx, $watery, 0, 0, $wwidth,$wheight);
					
					if($this->createfileim($sim,$stype,$sfile,95)){
						imagedestroy($sim);
						imagedestroy($wim);
					}else{
						$this->error=16;
						return false;
					}
				}			
			}
		}
	}

	
	//根据文件类型创建$im图片资源标识符
	protected function getfileim($file,$type){
		switch($type){
			case 1:
			$im=imagecreatefromgif($file);
			break;
			case 2:
			$im=imagecreatefromjpeg($file);
			break;
			case 3:
			$im=imagecreatefrompng($file);
			break;
			case 6:
			$im=imagecreatefromwbmp($file);
			break;
			default:
			$im=false;
		}
		return $im;
	}
	
	//根据文件类型创建该类型的图片
	protected function createfileim($im,$type,$file,$qty=95){
		switch($type){
			case 1:
			$im=imagegif($im,$file);
			break;
			case 2:
			$im=imagejpeg($im,$file,$qty);
			break;
			case 3:
			$im=imagepng($im,$file);
			break;
			case 6:
			$im=imagewbmp($im,$file);
			break;
			default:
			$im=false;
		}
		return $im;
	}
	
	//检查上传文件夹，没有就创建一个新的文件夹
	protected function setSavaPath(){
		$this->sava_path = str_replace("\\", "/", $this->sava_path);
		$this->sava_path = (preg_match('/\/$/',$this->sava_path)) ? $this->sava_path : $this->sava_path . '/';
		if(!is_dir($this->sava_path)){
			$this->makeDir($this->sava_path);
		}
		return true;
	}
	
	//创建文件夹
	protected function makeDir($dir, $mode = 0777){
	  if (is_dir($dir) || mkdir($dir, $mode)) return TRUE;
	  if (!makeDir(dirname($dir), $mode)) return FALSE;
	  return @mkdir($dir, $mode);
	}
	
	//去后缀名
	protected function fileext($filename){
		return strtolower(trim(substr(strrchr($filename, '.'), 1)));
	}
	
	//错误
	function error(){
		$UPLOAD_ERROR = array(0 => '文件上传成功',
							  1 => '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值',
							  2 => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
							  3 => '文件只有部分被上传',
							  4 => '没有文件被上传',
							  5 => '上传文件大小为0',
							  6 => '找不到临时文件夹。',
							  7 => '需要移动的文件不存在',
							  8 => '附件目录创建不成功',
							  9 => '发现同名文件',
							  10 => '不允许上传该类型文件',
							  11 => '文件超过了管理员限定的大小',
							  12 => '非法上传文件',
							  13 => '文件移动失败',
							  14 => '附件目录没有写入权限',
							  15 => '文件上传成功，但缩略图无法生成'
							 );
		return $UPLOAD_ERROR[$this->error];
	}
	
}
?>