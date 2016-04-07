<?php
/**
 * 滚动特效库(文字垂直、图片水平、图片垂直)
 * ============================================================================
 */
 
if(!defined('IN_MO')){
	exit('Access Denied');
}


/**
 * 文字垂直滚动(新闻停顿滚动，只显示一条)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_1_1($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_1_1_'.$rnd.'{width:400px; height:24px;position: relative;margin:0 auto;}
		.move_1_1_'.$rnd.' .picbox{width:340px;position:absolute; line-height:180%; left:0px;top:0px;}
		.move_1_1_'.$rnd.' .picbox li{height:24px;line-height:24px;}
		.move_1_1_'.$rnd.' .picbox li span{float:right;}
		.move_1_1_'.$rnd.' .top_btn{width:9px;height:5px;position:absolute;right:0px;top:5px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/txtbox-top.png") no-repeat 0px 0px;}
		.move_1_1_'.$rnd.' .bottom_btn{width:9px;height:5px;position:absolute;right:0px;top:15px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/txtbox-bottom.png") no-repeat 0px 0px;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_1_1_'.$rnd.'">'."\n";
	//按钮
	$show_html .= '<a id="top_btn_'.$rnd.'"  class="top_btn"></a>'."\n";
	$show_html .= '<a id="bottom_btn_'.$rnd.'" class="bottom_btn"></a>'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断是否定义了日期时间同时日期时间大于0
		$time=(isset($v['wtime'])&&$v['wtime']>0)?'<span>'.date('Y-m-d',$v['wtime']).'</span>':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>'.$time.'<a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.arrLeftId      = "top_btn_'.$rnd.'";      //上箭头ID
		scrollPic_'.$rnd.'.arrRightId     = "bottom_btn_'.$rnd.'";   //下箭头ID
		scrollPic_'.$rnd.'.frameWidth     = 24;                      //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 24;                      //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.upright        = true                     //是否垂直滚动
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 2;                       //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 2;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/**
 * 文字水平滚动(新闻停顿滚动，只显示一条)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_1_2($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_1_2_'.$rnd.'{width:400px;height:24px;position:relative;margin:0 auto;}
		.move_1_2_'.$rnd.' .picbox{width:340px;height:24px; position:absolute; line-height:180%;left:0px;top:0px;}
		.move_1_2_'.$rnd.' .picbox li{width:340px;height:24px;line-height:24px;float:left;}
		.move_1_2_'.$rnd.' .picbox li span{float:right;}
		.move_1_2_'.$rnd.' .left_btn{width:9px;height:9px;position:absolute;right:10px;top:7px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/txtbox-left.png") no-repeat 0px 0px;}
		.move_1_2_'.$rnd.' .right_btn{width:9px;height:9px;position:absolute;right:0px;top:7px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/txtbox-right.png") no-repeat 0px 0px;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_1_2_'.$rnd.'">'."\n";
	//按钮
	$show_html .= '<a id="left_btn_'.$rnd.'"  class="left_btn"></a>'."\n";
	$show_html .= '<a id="right_btn_'.$rnd.'" class="right_btn"></a>'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断是否定义了日期时间同时日期时间大于0
		$time=(isset($v['wtime'])&&$v['wtime']>0)?'<span>'.date('Y-m-d',$v['wtime']).'</span>':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>'.$time.'<a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.arrLeftId      = "left_btn_'.$rnd.'";     //左箭头ID
		scrollPic_'.$rnd.'.arrRightId     = "right_btn_'.$rnd.'";    //右箭头ID
		scrollPic_'.$rnd.'.frameWidth     = 340;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 340;                     //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 30;                       //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 2;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/**
 * 文字垂直滚动(一篇介绍文字无缝滚动)
 *
 * @parame  $v       数据数组
 * @parame  $pname   要链接的页面名称,为空时就不链接
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_1_3($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$v=$arr;
	$show_html ='
		<style>
		.move_1_3_'.$rnd.'{width:340px;height:160px;margin:0 auto;}
		.move_1_3_'.$rnd.' .picbox{width:340px;height:160px; line-height:180%;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_1_3_'.$rnd.'">'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
	$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array(),(isset($v['apname'])?$v['apname']:'')));
	//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
	$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
	//判断内容是否要截取，一个字母算1位，一个汉字算2位
	$title=($sub>0)?getstr($v['z_body'.$GLOBALS['lang']],$sub):$v['z_body'.$GLOBALS['lang']];
	$show_html .= '<a href="'.$turl.'" '.$targ.'>'.$title.'</a>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.frameWidth     = 160;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 1;                       //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.upright        = true                     //是否垂直滚动
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 60;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 0.05;                    //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 文字垂直滚动(新闻列表无缝滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_1_4($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_1_4_'.$rnd.'{width:340px;height:160px;margin:0 auto;}
		.move_1_4_'.$rnd.' .picbox{width:340px;height:160px; line-height:180%;}
		.move_1_4_'.$rnd.' .picbox li{height:24px;line-height:24px; border-bottom:dotted 1px #a8a8a8;}
		.move_1_4_'.$rnd.' .picbox li span{float:right;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_1_4_'.$rnd.'">'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断是否定义了日期时间同时日期时间大于0
		$time=(isset($v['wtime'])&&$v['wtime']>0)?'<span>'.date('Y-m-d',$v['wtime']).'</span>':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>'.$time.'<a href="'.$turl.'" '.$targ.'>·'.$title.'</a></li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.frameWidth     = 160;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 1;                       //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.upright        = true                     //是否垂直滚动
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 60;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 0.05;                    //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 文字垂直滚动(新闻列表停顿滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_1_5($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_1_5_'.$rnd.'{width:340px;height:150px;margin:0 auto;}
		.move_1_5_'.$rnd.' .picbox{width:340px;height:160px; line-height:180%;}
		.move_1_5_'.$rnd.' .picbox li{height:24px;line-height:24px; border-bottom:dotted 1px #a8a8a8;}
		.move_1_5_'.$rnd.' .picbox li span{float:right;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_1_5_'.$rnd.'">'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断是否定义了日期时间同时日期时间大于0
		$time=(isset($v['wtime'])&&$v['wtime']>0)?'<span>'.date('Y-m-d',$v['wtime']).'</span>':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>'.$time.'<a href="'.$turl.'" '.$targ.'>·'.$title.'</a></li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.frameWidth     = 150;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 25;                      //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.upright        = true                     //是否垂直滚动
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 60;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 2;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 图片列表水平滚动(单行无缝滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_2_1($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_2_1_'.$rnd.'{width:920px;height:125px;margin:0 auto;}
		.move_2_1_'.$rnd.' .picbox{width:920px}
		.move_2_1_'.$rnd.' .picbox li{width:145px; float:left; margin:0 5px; display:inline;overflow: hidden;}
		.move_2_1_'.$rnd.' .picbox li div{width:139px; height:96px; padding:2px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_2_1_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_2_1_'.$rnd.' .picbox li span{width:145px; height:25px; line-height:25px; display:block; text-align:center;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_2_1_'.$rnd.'">'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.frameWidth     = 920;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 1;                       //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.speed          = 0.1;                     //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 1;                       //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 0.01;                    //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 图片列表水平滚动(单行停顿滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_2_2($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_2_2_'.$rnd.'{width:930px;height:125px;margin:0 auto;}
		.move_2_2_'.$rnd.' .picbox{width:930px;}
		.move_2_2_'.$rnd.' .picbox li{width:145px; float:left; margin:0 5px; display:inline;overflow: hidden;}
		.move_2_2_'.$rnd.' .picbox li div{width:139px; height:96px; padding:2px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_2_2_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_2_2_'.$rnd.' .picbox li span{width:145px; height:25px; line-height:25px; display:block; text-align:center;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_2_2_'.$rnd.'">'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.frameWidth     = 930;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 155;                     //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 60;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 2;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 图片列表水平滚动(左右按钮、单行停顿滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_2_3($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_2_3_'.$rnd.'{width:1000px;height:267px;position:relative;margin:0 auto; margin-top:70px;}
		.move_2_3_'.$rnd.' .picbox{width:864px;position:absolute;left:45px;}
		.move_2_3_'.$rnd.' .picbox li{width:282px; float:left; margin:0 10px; display:inline;overflow: hidden;}
		.move_2_3_'.$rnd.' .picbox li div{width:280px; height:96px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_2_3_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_2_3_'.$rnd.' .picbox li span{width:282px; height:25px; line-height:25px; display:block; text-align:center;}
		.move_2_3_'.$rnd.' .left_btn{width:18px;height:32px;position:absolute;left:0px;top:95px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/picbox-left.png") no-repeat 0px 0px;}
		.move_2_3_'.$rnd.' .right_btn{width:18px;height:32px;position:absolute;right:0px;top:95px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/picbox-right.png") no-repeat 0px 0px;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_2_3_'.$rnd.'">'."\n";
	//按钮
	$show_html .= '<a id="left_btn_'.$rnd.'"  class="left_btn"></a>'."\n";
	$show_html .= '<a id="right_btn_'.$rnd.'" class="right_btn"></a>'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.arrLeftId      = "left_btn_'.$rnd.'";     //左箭头ID
		scrollPic_'.$rnd.'.arrRightId     = "right_btn_'.$rnd.'";    //右箭头ID
		scrollPic_'.$rnd.'.frameWidth     = 915;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 302;                     //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 10;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 3;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 图片列表水平滚动(左右按钮、多行停顿滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_2_4($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_2_4_'.$rnd.'{width:980px;height:250px;position:relative;margin:0 auto;}
		.move_2_4_'.$rnd.' .picbox{width:930px;position:absolute;left:25px;}
		.move_2_4_'.$rnd.' .picbox ul{width:155px;height:250px; float:left;}
		.move_2_4_'.$rnd.' .picbox li{width:145px; float:left; margin:0 5px; display:inline;overflow: hidden;}
		.move_2_4_'.$rnd.' .picbox li div{width:139px; height:96px; padding:2px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_2_4_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_2_4_'.$rnd.' .picbox li span{width:145px; height:25px; line-height:25px; display:block; text-align:center;}
		.move_2_4_'.$rnd.' .left_btn{width:18px;height:32px;position:absolute;left:0px;top:100px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/picbox-left.png") no-repeat 0px 0px;}
		.move_2_4_'.$rnd.' .right_btn{width:18px;height:32px;position:absolute;right:0px;top:100px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/picbox-right.png") no-repeat 0px 0px;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_2_4_'.$rnd.'">'."\n";
	//按钮
	$show_html .= '<a id="left_btn_'.$rnd.'"  class="left_btn"></a>'."\n";
	$show_html .= '<a id="right_btn_'.$rnd.'" class="right_btn"></a>'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	foreach($arr as $k=>$v){
		$show_html .= ($k%2==0)?'<ul>'."\n":'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
		$show_html .= (($k+1)%2==0||($k+1)==count($arr))?'</ul>'."\n":'';
	}	
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.arrLeftId      = "left_btn_'.$rnd.'";     //左箭头ID
		scrollPic_'.$rnd.'.arrRightId     = "right_btn_'.$rnd.'";    //右箭头ID
		scrollPic_'.$rnd.'.frameWidth     = 930;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 155;                     //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 10;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 3;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 图片列表水平滚动(左右按钮、单行停顿滚动、带fancybox)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，有fancybox，此项不起作用
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_2_5($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_2_5_'.$rnd.'{width:980px;height:125px;position:relative;margin:0 auto;}
		.move_2_5_'.$rnd.' .picbox{width:930px;position:absolute;left:25px;}
		.move_2_5_'.$rnd.' .picbox li{width:145px; float:left; margin:0 5px; display:inline;overflow: hidden;}
		.move_2_5_'.$rnd.' .picbox li div{width:139px; height:96px; padding:2px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_2_5_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_2_5_'.$rnd.' .picbox li span{width:145px; height:25px; line-height:25px; display:block; text-align:center;}
		.move_2_5_'.$rnd.' .left_btn{width:18px;height:32px;position:absolute;left:0px;top:35px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/picbox-left.png") no-repeat 0px 0px;}
		.move_2_5_'.$rnd.' .right_btn{width:18px;height:32px;position:absolute;right:0px;top:35px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/picbox-right.png") no-repeat 0px 0px;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.js')."\n";
	$show_html .= loadcss($GLOBALS['path'].'template/fancybox/jquery.fancybox.css')."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/fancybox/jquery.fancybox.js')."\n";
	$show_html .= '<div class="move_2_5_'.$rnd.'">'."\n";
	//按钮
	$show_html .= '<a id="left_btn_'.$rnd.'"  class="left_btn"></a>'."\n";
	$show_html .= '<a id="right_btn_'.$rnd.'" class="right_btn"></a>'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$GLOBALS['path'].getimgj($v['img_sl'],'d').'"><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$GLOBALS['path'].getimgj($v['img_sl'],'d').'">'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.arrLeftId      = "left_btn_'.$rnd.'";     //左箭头ID
		scrollPic_'.$rnd.'.arrRightId     = "right_btn_'.$rnd.'";    //右箭头ID
		scrollPic_'.$rnd.'.frameWidth     = 930;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 155;                     //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 10;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 3;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化
		
		$("#picbox_'.$rnd.' a").fancybox({
			"transitionIn": "elastic", //设置打开弹出来效果. 可以设置为 "elastic", "fade" 或 "none"
			"transitionOut": "elastic", //设置关闭收回去效果. 可以设置为 "elastic", "fade" 或 "none"
		});

	</script>'."\n";
	echo $show_html;
}

	
/*
 * 图片列表水平滚动(左右按钮、单行停顿滚动、带圆点分页)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_2_6($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_2_6_'.$rnd.'{width:980px;height:147px;position:relative;margin:0 auto;}
		.move_2_6_'.$rnd.' .picbox{width:930px;position:absolute;left:25px;}
		.move_2_6_'.$rnd.' .picbox li{width:145px; float:left; margin:0 5px; display:inline;overflow: hidden;}
		.move_2_6_'.$rnd.' .picbox li div{width:139px; height:96px; padding:2px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_2_6_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_2_6_'.$rnd.' .picbox li span{width:145px; height:25px; line-height:25px; display:block; text-align:center;}
		.move_2_6_'.$rnd.' .left_btn{width:18px;height:32px;position:absolute;left:0px;top:35px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/picbox-left.png") no-repeat 0px 0px;}
		.move_2_6_'.$rnd.' .right_btn{width:18px;height:32px;position:absolute;right:0px;top:35px;cursor: pointer; z-index:10;background: url("'.$GLOBALS['path'].'template/public/images/picbox-right.png") no-repeat 0px 0px;}
		.move_2_6_'.$rnd.' .dotlist{ width:980px;  position:absolute; z-index:1; bottom:0; left:0; height:22px; line-height:22px; text-align:center; }
		.move_2_6_'.$rnd.' .dotlist span{ cursor:pointer; display:inline-block; *display:inline; zoom:1; width:18px; height:16px; margin:0px; background:url(template/public/images/slider-dot.png) 0 -16px; overflow:hidden; line-height:9999px;}	
		.move_2_6_'.$rnd.' .dotlist span.on{ background-position:0px 0px;}
		.move_2_6_'.$rnd.' .dotlist{}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_2_6_'.$rnd.'">'."\n";
	//按钮
	$show_html .= '<a id="left_btn_'.$rnd.'"  class="left_btn"></a>'."\n";
	$show_html .= '<a id="right_btn_'.$rnd.'" class="right_btn"></a>'."\n";
	//点击项
	$show_html .= '<div id="dotlist_'.$rnd.'" class="dotlist"></div>'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.arrLeftId      = "left_btn_'.$rnd.'";     //左箭头ID
		scrollPic_'.$rnd.'.arrRightId     = "right_btn_'.$rnd.'";    //右箭头ID
		scrollPic_'.$rnd.'.dotListId      = "dotlist_'.$rnd.'";      //点列表ID
		scrollPic_'.$rnd.'.dotClassName   = "";                      //点className
		scrollPic_'.$rnd.'.dotOnClassName = "on";                    //当前点className
		scrollPic_'.$rnd.'.frameWidth     = 930;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 930;                     //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 60;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 3;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 图片列表垂直滚动(单列无缝滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_3_1($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_3_1_'.$rnd.'{width:145px;height:411px;margin:0 auto;}
		.move_3_1_'.$rnd.' .picbox{width:145px;}

		.move_3_1_'.$rnd.' .picbox li{width:145px; float:left; margin:5px 0;overflow: hidden;}
		.move_3_1_'.$rnd.' .picbox li div{width:139px; height:96px; padding:2px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_3_1_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_3_1_'.$rnd.' .picbox li span{width:145px; height:25px; line-height:25px; display:block; text-align:center;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_3_1_'.$rnd.'">'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.frameWidth     = 411;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 1;                       //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.upright        = true                     //是否垂直滚动
		scrollPic_'.$rnd.'.speed          = 0.1;                     //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 1;                       //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 0.02;                    //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 图片列表垂直滚动(单列停顿滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_3_2($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_3_2_'.$rnd.'{width:145px;height:411px;margin:0 auto;}
		.move_3_2_'.$rnd.' .picbox{width:145px;}
		.move_3_2_'.$rnd.' .picbox li{width:145px; float:left; margin:5px 0;overflow: hidden;}
		.move_3_2_'.$rnd.' .picbox li div{width:139px; height:96px; padding:2px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_3_2_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_3_2_'.$rnd.' .picbox li span{width:145px; height:25px; line-height:25px; display:block; text-align:center;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_3_2_'.$rnd.'">'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.frameWidth     = 411;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 137;                     //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.upright        = true                     //是否垂直滚动
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 60;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 2;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}


/*
 * 图片列表垂直滚动(多列停顿滚动)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $sub     截取标题字数，一个字母算1位，一个汉字算2位
 */
function showmove_3_3($arr,$pname='',$sub=0){
	//随机名
	$rnd=rand(100,1000);
	$show_html ='
		<style>
		.move_3_3_'.$rnd.'{width:465px;height:411px;margin:0 auto;}
		.move_3_3_'.$rnd.' .picbox{width:465px;}
		.move_3_3_'.$rnd.' .picbox li{width:145px; float:left; margin:5px 5px;overflow: hidden;}
		.move_3_3_'.$rnd.' .picbox li div{width:139px; height:96px; padding:2px; overflow: hidden;  border: 1px solid #ccc; text-align:center;display:table;}
		.move_3_3_'.$rnd.' .picbox li div a{vertical-align:middle;display:table-cell;}
		.move_3_3_'.$rnd.' .picbox li span{width:145px; height:25px; line-height:25px; display:block; text-align:center;}
	   </style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/ScrollPic.js')."\n";
	$show_html .= '<div class="move_3_3_'.$rnd.'">'."\n";
	//滚动内容
	$show_html .= '<div id="picbox_'.$rnd.'"  class="picbox">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li>';
		$show_html .= '<div class="li_img"><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></div>';
		$show_html .= '<span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></span>';
		$show_html .= '</li>'."\n";
	}	
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		var scrollPic_'.$rnd.' = new ScrollPic();
		scrollPic_'.$rnd.'.scrollContId   = "picbox_'.$rnd.'";       //内容容器ID
		scrollPic_'.$rnd.'.frameWidth     = 411;                     //显示框宽度  跟上面的内容容器css样式宽度一致，宽度=容器宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.pageWidth      = 137;                     //翻页宽度    跟上面的图片css样式宽度一致，宽度=图片宽度+边框大小+margin+padding
		scrollPic_'.$rnd.'.upright        = true                     //是否垂直滚动
		scrollPic_'.$rnd.'.speed          = 30;                      //移动速度(单位毫秒，越小越快)
		scrollPic_'.$rnd.'.space          = 60;                      //每次移动像素(单位px，越大越快)
		scrollPic_'.$rnd.'.autoPlay       = true;                    //自动播放
		scrollPic_'.$rnd.'.autoPlayTime   = 2;                       //自动播放间隔时间(秒)
		scrollPic_'.$rnd.'.circularly     = true;                    //循环滚动(无缝循环)
		scrollPic_'.$rnd.'.initialize();                             //初始化		
	</script>'."\n";
	echo $show_html;
}

?>
