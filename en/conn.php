<?php
require_once('../include/common.inc.php');
require_once(MO_ROOT.'/lib/lib_common.php'); 
require_once(MO_ROOT.'/lib/lib_html.php'); 
require_once(MO_ROOT.'/lib/lib_banner.php'); 
require_once(MO_ROOT.'/lib/lib_move.php'); 
//表的语言字段后缀，中文版默认为空，英文版为_en，繁体版为_fr
$lang='_en';
//语言版本路径，如果该文件在根目录，此值为空，例如该文件在cn文件夹，则此值为../
$path='../';
//全局seo记录标识，指的是gl_setup表的lm字段的值，不是id的值
$gl_id=1;
//0为不启用伪静态，1为启用伪静态，2启用伪静态并且页面名称后台可控制，但必须有前缀来区分每个页面的文件
$rewrite=0;   
?>