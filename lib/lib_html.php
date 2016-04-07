<?php
/**
 * 常用的显示html程序(seo、banner、分类、资料、新闻、产品、客服)
 * ============================================================================
 */
 
if(!defined('IN_MO')){
	exit('Access Denied');
}


//以下是显示SEOhtml的程序=========================================================
/**
 * 获取seo信息html
 *
 * @parame  $arr    数据数组
 */
function showseohtml($arr){
	$show_html='';
	$v=$arr;
	if ($v){
		$show_html .= '<title>'.$v['ym_tit'.$GLOBALS['lang']].'</title>'."\n";
		$show_html .= '<meta name="keywords" content="'.$v['ym_key'.$GLOBALS['lang']].'"/>'."\n";
		$show_html .= '<meta name="description" content="'.$v['ym_des'.$GLOBALS['lang']].'"/>'."\n";
	}
	echo $show_html;
}


//以下是显示Bannerhtml的程序=========================================================
/**
 * 一张Banner的html(图片方式)
 *
 * @parame  $arr       数据数组
 * @parame  $pname     链接的页面名称，为空时就是没有链接
 */
function showbanhtml_1($arr,$pname=''){
	if (isset($arr[0])){
		$v=$arr[0];
	}else{
		$v=$arr;
	}
	$show_html = '';
	if ($v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		$show_html .= '<div ><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"/></a></div>'."\n";
	}
	echo $show_html;
}

/**
 * 一张Banner的html(背景方式)
 *
 * @parame  $arr       数据数组
 * @parame  $pname     链接的页面名称，为空时就是没有链接
 */
function showbanhtml_2($arr,$pname=''){
	if (isset($arr[0])){
		$v=$arr[0];
	}else{
		$v=$arr;
	}
	$show_html = '';
	if($v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		$show_html .= '<div style="background:url('.$GLOBALS['path'].$v['img_sl'].') 50% 0px no-repeat;width:100%;height:100%;"><a href="'.$turl.'" '.$targ.' style="width:100%;height:100%;display:block;"></a></div>'."\n";
	}
	echo $show_html;
}

/**
 * 多张Banner的html(图片方式)
 *
 * @parame  $arr       数据数组
 * @parame  $pname     链接的页面名称，为空时就是没有链接
 */
function showbanhtml_3($arr,$pname=''){
	$show_html = '';
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		$show_html .= '<li ><a href="'.$turl.'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'"/></a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 多张Banner的html(背景方式)
 *
 * @parame  $arr       数据数组
 * @parame  $pname     链接的页面名称，为空时就是没有链接
 */
function showbanhtml_4($arr,$pname=''){
	$show_html = '';
	foreach($arr as $k=>$v){
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		$show_html .= '<li style="background:url('.$GLOBALS['path'].$v['img_sl'].') 50% 0px no-repeat;width:100%;height:100%;"><a href="'.$turl.'" '.$targ.' style="width:100%;height:100%;display:block;"></a></li>'."\n";
	}
	echo $show_html;
}


//以下是显示分类列表html的程序=====================================================
/**
 * 分类列表1(标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlmhtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:($pname==''?'javascript:;':zurl($pname,array('lm'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title_lm'.$GLOBALS['lang']],$sub):$v['title_lm'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 分类列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlmhtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title_lm'.$GLOBALS['lang']],$sub):$v['title_lm'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl_lm'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 分类列表3(上标题+下简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlmhtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title_lm'.$GLOBALS['lang']],$sub):$v['title_lm'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body_lm'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body_lm'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 分类列表4(左图片+右标题+右简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlmhtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title_lm'.$GLOBALS['lang']],$sub):$v['title_lm'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body_lm'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body_lm'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl_lm'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 分类列表5(上标题+中图片+下简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlmhtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['url_lm'])&&$v['url_lm']!='')?$v['url_lm']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id_lm']),(isset($v['apname_lm'])?$v['apname_lm']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['url_lm'])&&$v['url_lm']!=''&&strpos($v['url_lm'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title_lm'.$GLOBALS['lang']],$sub):$v['title_lm'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body_lm'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body_lm'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl_lm'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}


//以下是显示资料列表html的程序=====================================================
/**
 * 资料列表1(标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showtolhtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 资料列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showtolhtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 资料列表3(上标题+下简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showtolhtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 资料列表4(左图片+右标题+右简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showtolhtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 资料列表5(上标题+中图片+中简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showtolhtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}


//以下是显示新闻列表html的程序=====================================================
/**
 * 新闻列表1(标题+时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function shownewshtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'.date('Y-m-d',$v['wtime']).'</span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 新闻列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function shownewshtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 新闻列表3(上标题+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function shownewshtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 新闻列表4(左图片+右标题+右简要介绍+右时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function shownewshtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 新闻列表5(上标题+中图片+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function shownewshtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}


//以下是显示案例列表html的程序=====================================================
/**
 * 案例列表1(标题+时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showcaseshtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'.date('Y-m-d',$v['wtime']).'</span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 案例列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showcaseshtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 案例列表3(上标题+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showcaseshtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 案例列表4(左图片+右标题+右简要介绍+右时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showcaseshtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){

		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 案例列表5(上标题+中图片+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showcaseshtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}


//以下是显示下载列表html的程序=====================================================
/**
 * 下载列表1(标题+时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showdownhtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'.date('Y-m-d',$v['wtime']).'</span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 下载列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showdownhtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 下载列表3(上标题+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showdownhtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 下载列表4(左图片+右标题+右简要介绍+右时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showdownhtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){

		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 下载列表5(上标题+中图片+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showdownhtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}


//以下是显示视频列表html的程序=====================================================
/**
 * 视频列表1(标题+时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showvideohtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'.date('Y-m-d',$v['wtime']).'</span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 视频列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showvideohtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 视频列表3(上标题+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showvideohtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 视频列表4(左图片+右标题+右简要介绍+右时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showvideohtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){

		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 视频列表5(上标题+中图片+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showvideohtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}



//以下是显示信息列表html的程序=====================================================
/**
 * 信息列表1(标题+时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showinfohtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'.date('Y-m-d',$v['wtime']).'</span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 信息列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showinfohtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 信息列表3(上标题+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showinfohtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 信息列表4(左图片+右标题+右简要介绍+右时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showinfohtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){


		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 信息列表5(上标题+中图片+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showinfohtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}


//以下是显示产品列表html的程序=====================================================
/**
 * 产品列表1(标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showprohtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 产品列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showprohtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 产品列表3(上标题+下简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showprohtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 产品列表4(左图片+右标题+右简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showprohtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 产品列表5(上标题+中图片+中简要介绍)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showprohtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}


//以下是显示新闻列表html的程序=====================================================
/**
 * 新闻列表1(标题+时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlinkhtml_1($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'.date('Y-m-d',$v['wtime']).'</span><a href="'.$turl.'" '.$targ.'>'.$title.'</a></li>'."\n";
	}
	echo $show_html;
}

/**
 * 新闻列表2(上图片+下标题)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数(此处无用)
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlinkhtml_2($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 新闻列表3(上标题+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlinkhtml_3($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 新闻列表4(左图片+右标题+右简要介绍+右时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlinkhtml_4($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){

		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<div class="li_con">'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</div>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}

/**
 * 新闻列表5(上标题+中图片+中简要介绍+下时间)
 *
 * @parame  $arr    数据数组
 * @parame  $pname  要链接的页面名称
 * @parame  $sub    截取标题字数
 * @parame  $f_sub  截取简要介绍字数
 * @parame  $last   每行最后一条信息所在位置，例如1行4列，那$last=4
 */
function showlinkhtml_5($arr,$pname='',$sub=0,$f_sub=0,$last=0){
	$show_html = '';
	foreach($arr as $k=>$v){
		//每行最后一条信息加上last样式名
		$tlast = ($last>0&&($k+1)%$last==0)?'class="last"':'';
		//判断如果有外部链接，就直接外链，没有的话如果传入的页面名称为空，就不做链接，如果传入的页面名称不为空则按传入的页面名称做链接
		$turl=(isset($v['link_url'])&&$v['link_url']!='')?$v['link_url']:($pname==''?'javascript:;':zurl($pname,array('id'=>$v['id']),(isset($v['apname'])?$v['apname']:'')));
		//判断如果有外部链接，就是新窗口打开，没有的话就是当前窗口打开
		$targ=(isset($v['link_url'])&&$v['link_url']!=''&&strpos($v['link_url'],'http://')!==false)?'target="_blank"':'';
		//判断标题是否要截取，一个字母算1位，一个汉字算2位
		$title=($sub>0)?getstr($v['title'.$GLOBALS['lang']],$sub):$v['title'.$GLOBALS['lang']];
		//简要介绍
		$f_body =($f_sub>0)?getstr(strip_tags($v['f_body'.$GLOBALS['lang']]),$f_sub):strip_tags($v['f_body'.$GLOBALS['lang']]);
		$show_html .= '<li '.$tlast.'>'."\n";
		$show_html .= '<span><a href="'.$turl .'" '.$targ.'>'.$title.'</a></span>'."\n";
		$show_html .= '<div class="li_img"><a href="'.$turl .'" '.$targ.'><img src="'.$GLOBALS['path'].$v['img_sl'].'" /></a></div>'."\n";
		$show_html .= '<p>'.$f_body.'</p>'."\n";
		//$show_html .= '<i>'.date('Y-m-d',$v['wtime']).'</i>'."\n";
		$show_html .= '<a class="li_more" href="'.$turl .'" '.$targ.'>查看更多</a>'."\n";
		$show_html .= '</li>'."\n";
	}
	echo $show_html;
}


//以下是显示在线客服html的程序=====================================================
/**
 * 在线客服(图标+名称)
 *
 * @parame  $arr    数据数组
 */
function showkfhtml($arr){
	$show_html = '';
	foreach($arr as $k=>$v){
		if ($v['f_body_lm']!=''){
			$str=str_replace('###',$v['title'],$v['f_body_lm']);
			$str=str_replace('$$$',$v['rename'.$GLOBALS['lang']],$str);
			$show_html .= '<li>'.$str.'</li>'."\n";
		}
	}
	echo $show_html;
}

?>
