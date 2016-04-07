<?php
/**
 * Banner特效库(带数字的图片切换、带圆点的图片切换、带缩略图的图片切换)
 * ============================================================================
 */
 
if(!defined('IN_MO')){
	exit('Access Denied');
}


/**
 * 带数字的图片切换(满屏和固定宽度都适合)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $wid     宽度，例如：满屏要填写100%,1000像素要填写1000px
 * @parame  $hei     高度，例如：高度没有100%,300像素要填写300px
 * @parame  $lr_btn  左右按钮是否需要，true表示要，false表示不要
 * @parame  $cl_btn  数字按钮是否需要，true表示要，false表示不要
 * @parame  $ty      切换类型"fold","topLoop","leftLoop"当时宽度是100%时，leftLoop用不了
 */
function showban_1_1($arr,$pname,$wid,$hei,$lr_btn=true,$cl_btn=true,$ty='fold'){
	$rnd=rand(100,1000);
	$show_html = '
	<style type="text/css">
	.ban_1_1_'.$rnd.'{ width:'.$wid.'; height:'.$hei.'; position:relative; overflow:hidden; margin:0 auto;}
	.ban_1_1_'.$rnd.' .bd{ height:'.$hei.';position:relative;  z-index:0;}'."\n";
	$show_html .= ($wid=='100%')?'.ban_1_1_'.$rnd.' .bd ul{ width:'.$wid.' !important;}':''."\n";
	$show_html .= '.ban_1_1_'.$rnd.' .bd li{ width:'.$wid.' !important; height:'.$hei.'; }
	.ban_1_1_'.$rnd.' .bd li a{ position: absolute; z-index: 2; display: block; width: 100%; height: 100%; top: 0; left: 0; text-decoration: none;}
	.ban_1_1_'.$rnd.' .hd { position: absolute; z-index: 3; bottom: 0px; right: 0px;}	
	.ban_1_1_'.$rnd.' .hd li{ float: left; position: relative; width: 18px; height: 15px; line-height: 15px; overflow: hidden; text-align: center; margin-right: 1px; cursor: pointer;}
	.ban_1_1_'.$rnd.' .hd li a,.ban_1_1_'.$rnd.' .hd li span { position: absolute; z-index: 2; display: block; color: white; width: 100%; height: 100%; top: 0; left: 0; text-decoration: none;}
	.ban_1_1_'.$rnd.' .hd li span { z-index: 1; background: black; filter: alpha(opacity=50); opacity: 0.5;}
	.ban_1_1_'.$rnd.' .hd li.on a,.ban_1_1_'.$rnd.' .hd a:hover{ background:#f60;}
	.ban_1_1_'.$rnd.' .prev{width:18px; height:32px; position:absolute; left:2%; top:50%; display:block; background:url('.$GLOBALS['path'].'template/public/images/slider-left.png) 0px 0px no-repeat; filter:alpha(opacity=50);opacity:0.5; }
	.ban_1_1_'.$rnd.' .next{width:18px; height:32px; position:absolute; right:2%; top:50%; display:block; background:url('.$GLOBALS['path'].'template/public/images/slider-right.png) 0px 0px no-repeat; filter:alpha(opacity=50);opacity:0.5;}
	.ban_1_1_'.$rnd.' .prev:hover,.ban_1_1_'.$rnd.' .next:hover{ filter:alpha(opacity=100);opacity:1;}
	</style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.js')."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.SuperSlide.js')."\n";
	$show_html .= '<div class="ban_1_1_'.$rnd.'">'."\n";
	//主体
	$show_html .= '<div class="bd">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		$show_html .= '<li style="background:url('.$GLOBALS['path'].$v['img_sl'].') 50% 0px no-repeat;"><a href="'.$turl.'" '.$targ.'></a></li>'."\n";
	}
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	//点击项
	if($cl_btn){
		$show_html .= '<div class="hd">'."\n";
		$show_html .= '<ul>'."\n";
		foreach($arr as $k=>$v){
			$show_html .= '<li><a>'.($k+1).'</a><span></span></li>'."\n";
		}
		$show_html .= '</ul>'."\n";
		$show_html .= '</div>'."\n";
	}
	//左右按钮
	if($lr_btn){
		$show_html .= '<a class="prev" href="javascript:void(0)" style="display:none;"></a>'."\n";
		$show_html .= '<a class="next" href="javascript:void(0)" style="display:none;"></a>'."\n";
	}
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		$(".ban_1_1_'.$rnd.'").hover(function(){ jQuery(this).find(".prev,.next").stop(true,true).fadeTo("slow",0.5) },function(){ jQuery(this).find(".prev,.next").fadeOut() });
		$(".ban_1_1_'.$rnd.'").slide( { mainCell:".bd ul",titCell:".hd li", effect:"'.$ty.'",autoPlay:true,mouseOverStop:true,pnLoop:true });
	</script>'."\n";
	echo $show_html;
}


/**
 * 带圆点的图片切换(满屏和固定宽度都适合)
 * 
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $wid     宽度，例如：满屏要填写100%,1000像素要填写1000px
 * @parame  $hei     高度，例如：高度没有100%,300像素要填写300px
 * @parame  $lr_btn  左右按钮是否需要，true表示要，false表示不要
 * @parame  $cl_btn  圆点按钮是否需要，true表示要，false表示不要
 * @parame  $ty      切换类型"fold","topLoop","leftLoop"当时宽度是100%时，leftLoop用不了
*/
function showban_1_2($arr,$pname,$wid,$hei,$lr_btn=true,$cl_btn=true,$ty='fold'){
	$rnd=rand(100,1000);
	$show_html = '
	<style type="text/css">
	.ban_1_2_'.$rnd.'{ width:'.$wid.'; height:'.$hei.'; position:relative; overflow:hidden; margin:0 auto;}
	.ban_1_2_'.$rnd.' .bd{ height:'.$hei.';position:relative;  z-index:0;}'."\n";
	$show_html .= ($wid=='100%')?'.ban_1_2_'.$rnd.' .bd ul{ width:'.$wid.' !important;}':''."\n";
	$show_html .= '.ban_1_2_'.$rnd.' .bd li{ width:'.$wid.' !important; height:'.$hei.'; }
	.ban_1_2_'.$rnd.' .bd li a{ position: absolute; z-index: 2; display: block; width: 100%; height: 100%; top: 0; left: 0; text-decoration: none;}
	.ban_1_2_'.$rnd.' .hd{ width:'.$wid.';  position:absolute; z-index:1; bottom:0; left:0; height:22px; line-height:22px; text-align:center; }
	.ban_1_2_'.$rnd.' .hd ul li{ cursor:pointer; display:inline-block; *display:inline; zoom:1; width:18px; height:16px; margin:0px; background:url(template/public/images/slider-dot.png) 0 -16px; overflow:hidden; line-height:9999px;}	
	.ban_1_2_'.$rnd.' .hd ul .on{ background-position:0px 0px;}
	.ban_1_2_'.$rnd.' .prev{width:18px; height:32px; position:absolute; left:2%; top:50%; display:block; background:url('.$GLOBALS['path'].'template/public/images/slider-left.png) 0px 0px no-repeat; filter:alpha(opacity=50);opacity:0.5; }
	.ban_1_2_'.$rnd.' .next{width:18px; height:32px; position:absolute; right:2%; top:50%; display:block; background:url('.$GLOBALS['path'].'template/public/images/slider-right.png) 0px 0px no-repeat; filter:alpha(opacity=50);opacity:0.5;}
	.ban_1_2_'.$rnd.' .prev:hover,.ban_1_2_'.$rnd.' .next:hover{ filter:alpha(opacity=100);opacity:1;}
	</style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.js')."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.SuperSlide.js')."\n";
	$show_html .= '<div class="ban_1_2_'.$rnd.'">'."\n";
	//主体
	$show_html .= '<div class="bd">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		$show_html .= '<li style="background:url('.$GLOBALS['path'].$v['img_sl'].') 50% 0px no-repeat;"><a href="'.$turl.'"  '.$targ.'></a></li>'."\n";
	}
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	//点击项
	if($cl_btn){
		$show_html .= '<div class="hd">'."\n";
		$show_html .= '<ul>'."\n";
		foreach($arr as $k=>$v){
			$show_html .= '<li>'.($k+1).'</li>'."\n";
		}
		$show_html .= '</ul>'."\n";
		$show_html .= '</div>'."\n";
	}
	//按钮
	if($lr_btn){
		$show_html .= '<a class="prev" href="javascript:void(0)" style="display:none;"></a>'."\n";
		$show_html .= '<a class="next" href="javascript:void(0)" style="display:none;"></a>'."\n";
	}
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		$(".ban_1_2_'.$rnd.'").hover(function(){ jQuery(this).find(".prev,.next").stop(true,true).fadeTo("slow",0.5) },function(){ jQuery(this).find(".prev,.next").fadeOut() });
		$(".ban_1_2_'.$rnd.'").slide( { mainCell:".bd ul",titCell:".hd li", effect:"'.$ty.'",autoPlay:true,mouseOverStop:true,pnLoop:true });
	</script>'."\n";
	echo $show_html;
}

/**
 * 带缩略图的图片切换(满屏和固定宽度都适合)
 *
 * @parame  $arr     数据数组
 * @parame  $pname   要链接的页面名称，如果link_url不为空，link_url为页面的链接，此值将不起作用。如果记录中的link_url为空时，此值为空时，将没有链接，如果此值不为空时才会结合id一起做链接。
 * @parame  $wid     宽度，例如：满屏要填写100%,1000像素要填写1000px
 * @parame  $hei     高度，例如：高度没有100%,300像素要填写300px
 * @parame  $lr_btn  左右按钮是否需要，true表示要，false表示不要
 * @parame  $cl_btn  缩略图按钮是否需要，true表示要，false表示不要
 * @parame  $ty      切换类型"fold","topLoop","leftLoop"当时宽度是100%时，leftLoop用不了
 */
function showban_1_3($arr,$pname,$wid,$hei,$lr_btn=true,$cl_btn=true,$ty='fold'){
	$rnd=rand(100,1000);
	$show_html = '
	<style type="text/css">
	.ban_1_3_'.$rnd.'{ width:'.$wid.'; height:'.$hei.'; position:relative; overflow:hidden; margin:0 auto;}
	.ban_1_3_'.$rnd.' .bd{ height:'.$hei.';position:relative;  z-index:0;}'."\n";
	$show_html .= ($wid=='100%')?'.ban_1_3_'.$rnd.' .bd ul{ width:'.$wid.' !important;}':''."\n";
	$show_html .= '.ban_1_3_'.$rnd.' .bd li{ width:'.$wid.' !important; height:'.$hei.'; }
	.ban_1_3_'.$rnd.' .bd li a{ position: absolute; z-index: 2; display: block; width: 100%; height: 100%; top: 0; left: 0; text-decoration: none;}
	.ban_1_3_'.$rnd.' .hd{right:2%; bottom:2%; position:absolute; z-index:1; bottom:15px; overflow:hidden;}
	.ban_1_3_'.$rnd.' .hd ul{ float:right;}	
	.ban_1_3_'.$rnd.' .hd ul li{float:left; margin:0 5px; display:inline; cursor:pointer;}
	.ban_1_3_'.$rnd.' .hd ul li img{ width:80px; height:40px; display:block; border:2px solid #fff; filter:alpha(opacity=50);opacity:0.5;  }	
	.ban_1_3_'.$rnd.' .hd ul .on img{ border-color:#FF8106; filter:alpha(opacity=100);opacity:1;}
	.ban_1_3_'.$rnd.' .prev{width:18px; height:32px; position:absolute; left:2%; top:50%; display:block; background:url('.$GLOBALS['path'].'template/public/images/slider-left.png) 0px 0px no-repeat; filter:alpha(opacity=50);opacity:0.5; }
	.ban_1_3_'.$rnd.' .next{width:18px; height:32px; position:absolute; right:2%; top:50%; display:block; background:url('.$GLOBALS['path'].'template/public/images/slider-right.png) 0px 0px no-repeat; filter:alpha(opacity=50);opacity:0.5;}
	.ban_1_3_'.$rnd.' .prev:hover,.ban_1_3_'.$rnd.' .next:hover{ filter:alpha(opacity=100);opacity:1;}
	</style>'."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.js')."\n";
	$show_html .= loadjs($GLOBALS['path'].'template/public/js/jquery.SuperSlide.js')."\n";
	$show_html .= '<div class="ban_1_3_'.$rnd.'">'."\n";
	//主体
	$show_html .= '<div class="bd">'."\n";
	$show_html .= '<ul>'."\n";
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		$show_html .= '<li style="background:url('.$GLOBALS['path'].$v['img_sl'].') 50% 0px no-repeat;"><a href="'.$turl.'" '.$targ.'></a></li>'."\n";
	}
	$show_html .= '</ul>'."\n";
	$show_html .= '</div>'."\n";
	//点击项
	if($cl_btn){
		$show_html .= '<div class="hd">'."\n";
		$show_html .= '<ul>'."\n";
		foreach($arr as $k=>$v){
			$show_html .= '<li><a href="javascript:void(0)" ><img src="'.$GLOBALS['path'].$v['img_sl'].'"></a></li>'."\n";
		}
		$show_html .= '</ul>'."\n";
		$show_html .= '</div>'."\n";
	}
	//按钮
	if($lr_btn){
		$show_html .= '<a class="prev" href="javascript:void(0)" style="display:none;"></a>'."\n";
		$show_html .= '<a class="next" href="javascript:void(0)" style="display:none;"></a>'."\n";
	}
	$show_html .= '</div>'."\n";
	$show_html .= '
	<script type="text/javascript">
		$(".ban_1_3_'.$rnd.'").hover(function(){ jQuery(this).find(".prev,.next").stop(true,true).fadeTo("slow",0.5) },function(){ jQuery(this).find(".prev,.next").fadeOut() });
		$(".ban_1_3_'.$rnd.'").slide( { mainCell:".bd ul",titCell:".hd li", effect:"'.$ty.'",autoPlay:true,mouseOverStop:true,pnLoop:true });
	</script>'."\n";
	echo $show_html;
}
?>
