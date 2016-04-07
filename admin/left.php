<?php 
require('../include/common.inc.php');
chklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台左侧</title>
<script src="scripts/function.js"></script>
<script src="scripts/jquery.js"></script>
<style>
html,BODY {SCROLLBAR-FACE-COLOR: #65A8E5;SCROLLBAR-HIGHLIGHT-COLOR: #65A8E5;SCROLLBAR-SHADOW-COLOR: #BDD6EE;SCROLLBAR-3DLIGHT-COLOR: #ffffff;SCROLLBAR-ARROW-COLOR: #ffffff;SCROLLBAR-TRACK-COLOR:#BDD6EE;SCROLLBAR-DARKSHADOW-COLOR: #65A8E5; font-family:Arial, Helvetica, sans-serif;overflow:scroll; overflow-x:auto;}
body{background: #fbfbfb url(images/aa_left1.gif) no-repeat left top; margin:0px; width:181px; height:100%; font-size:12px;overflow-x:auto; overflow-y:hidden;}
ul,li{list-style:none; margin:0px; padding:0px;}
a {COLOR: #000000;  TEXT-DECORATION: none}
a:link {COLOR: #000000;  TEXT-DECORATION: none}
a:visited {COLOR: #000000;  TEXT-DECORATION: none;}
a:active {COLOR: #000000;  TEXT-DECORATION: none}
a:hover {COLOR: #000000; TEXT-DECORATION: underline}
#left_main{ width:158px; border-left:1px solid #808080;border-right:1px solid #808080;border-bottom:1px solid #808080;margin:0px 0 0 8px; background-color:#f8f8f8;}
#left_main h3{ padding:0 0 0 8px; margin:0px; height:25px; line-height:25px; font-size:12px; color:#494949; background:url(images/title_bg_show.gif) no-repeat left top; cursor:pointer;}
#left_main ul{ padding:2px 0 3px;}
#left_main ul li{ background:url(images/project2.gif) no-repeat 6px 2px; padding:3px 0 1px 26px;}
#left_main ul .li_01{background:url(images/news_catch_up.gif) no-repeat 6px 2px;}
#left_main ul .li_02{background:url(images/mail_send_all.gif) no-repeat 6px 2px;}
#left_main ul .li_02 a{ color:#FF0000; font-weight:bold;}
#left_main ul .li_03{background:url(images/favorites.gif) no-repeat 6px 2px;}
</style>
<script>
$(document).ready(function() {
    $('h3').click(function(){
		$(this).next('ul').slideToggle();
		});
});
</script>
</head>

<body>
<div style="height:9px;"></div>
<div id="left_main">
    <h3>网站配置管理</h3>
    <ul>
        <li class="li_03"><a href="gl_setup/edit.php" target="mainFrame">网站基本配置</a></li>
    </ul>
	<!--资料系统-->
	<?php require('tol_lm/config.php');?>
	<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=1" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul>
    
    <!--新闻系统-->
    <?php require('news_lm/config.php');?>
    <h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=2" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul>
    
    <!--案例系统-->
    <?php require('cases_lm/config.php');?>
    <h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=3" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul>
    
    <!--下载系统-->
    <?php require('down_lm/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=4" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul> -->
    
    <!--视频系统-->
    <?php require('video_lm/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=5" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul> -->
    
    <!--信息系统-->
    <?php require('info_lm/config.php');?>
    <h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=6" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul>
    
    <!--产品系统-->
    <?php require('pro_lm/config.php');?>
    <h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=7" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <!--<li><a href="pro_tu/add.php" target="mainFrame">产品批量上传</a></li> -->
    </ul>
    
    <!--会员管理-->
    <!--<h3>会员管理</h3>
    <ul>
        <li><a href="person/default.php" target="mainFrame">会员信息管理</a> | <a href="person/add.php"  target="mainFrame">添加</a></li>
    </ul> -->
    
    <!--招聘管理-->
    <?php require('job_lm/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true||$conf['sy']['r_email']==true){
		?>
            <li>
            <?php
            if ($conf['sy']['seo']==true){
            ?>
            <a href="sy_setup/edit.php?sy_id=9" target="mainFrame">SEO设置</a>&nbsp; 
            <?php
            }
            ?>
            <?php
            if ($conf['sy']['r_email']==true){
            ?>
            <a href="sy_setup/m_edit.php?sy_id=9" target="mainFrame">收件箱设置</a>
            <?php
            }
            ?>
            </li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>信息管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/yp_default.php" target="mainFrame">应聘简历管理</a></li>
    </ul> -->
    
    <!--留言管理-->
    <?php require('book/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true||$conf['sy']['r_email']==true){
		?>
            <li>
            <?php
            if ($conf['sy']['seo']==true){
            ?>
            <a href="sy_setup/edit.php?sy_id=10" target="mainFrame">SEO设置</a>&nbsp; 
            <?php
            }
            ?>
            <?php
            if ($conf['sy']['r_email']==true){
            ?>
            <a href="sy_setup/m_edit.php?sy_id=10" target="mainFrame">收件箱设置</a>
            <?php
            }
            ?>
            </li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>信息管理</a></li>
    </ul> -->
        
    <!--在线报名-->
    <?php require('baoming/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true||$conf['sy']['r_email']==true){
		?>
            <li>
            <?php
            if ($conf['sy']['seo']==true){
            ?>
            <a href="sy_setup/edit.php?sy_id=11" target="mainFrame">SEO设置</a>&nbsp; 
            <?php
            }
            ?>
            <?php
            if ($conf['sy']['r_email']==true){
            ?>
            <a href="sy_setup/m_edit.php?sy_id=11" target="mainFrame">收件箱设置</a>
            <?php
            }
            ?>
            </li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>信息管理</a></li>
    </ul> -->
    
    <!--订单管理-->
    <?php require('pro_order/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true||$conf['sy']['r_email']==true){
		?>
            <li>
            <?php
            if ($conf['sy']['seo']==true){
            ?>
            <a href="sy_setup/edit.php?sy_id=12" target="mainFrame">SEO设置</a>&nbsp; 
            <?php
            }
            ?>
            <?php
            if ($conf['sy']['r_email']==true){
            ?>
            <a href="sy_setup/m_edit.php?sy_id=12" target="mainFrame">收件箱设置</a>
            <?php
            }
            ?>
            </li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>信息管理</a></li>
    </ul> -->

    <!--邮件管理
    <h3>邮件管理</h3>
    <ul>
        <li><a href="email/default.php" target="mainFrame">邮件订阅管理</a></li>
        <li><a href="email/default.php" target="mainFrame">邮件群发设置</a></li>
        <li><a href="email/default.php" target="mainFrame">邮件群发管理</a></li>
    </ul>
    
    < !--订单管理- ->
	<h3>防伪查询</h3>
    <ul>
       <li><a href="pro_ce/default.php" target="mainFrame">防伪码管理</a> | <a href="pro_ce/add.php" target="mainFrame">批量导入</a></li> 
       <li><a href="pro_ce_dao/default.php" target="mainFrame">导入记录管理</a></li>
    </ul>-->
    
    
    <!--横幅系统-->
    <?php require('ban_lm/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul> -->
    
    <!--广告系统-->
    <?php require('ad_lm/config.php');?>
    <h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul>
    
    <!--链接系统-->
    <?php require('link_lm/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=18" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul> -->
    
    <!--在线客服-->
    <?php require('kf_lm/config.php');?>
    <h3>客服管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lx']==true&&$conf['sy']['manage_lx']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lx'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>类型设置</a> | <a href="<?php echo $conf['sy']['folder_lx'];?>/add.php"  target="mainFrame">添加</a></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>信息管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul>
    
    <!--样本系统-->
	<?php require('demo_lm/config.php');?>
    <!--<h3><?php echo $conf['sy']['name'];?>管理</h3>
    <ul>
    	<?php
        if ($conf['sy']['seo']==true){
		?>
        <li><a href="sy_setup/edit.php?sy_id=4" target="mainFrame"><?php echo $conf['sy']['name'];?>SEO设置</a></li>
        <?php
        }
		?>
    	<?php
        if ($conf['sy']['need_lm']==true&&$conf['sy']['manage_lm']==true){
		?>
    	<li><a href="<?php echo $conf['sy']['folder_lm'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>分类管理</a><?php if ($conf['lm']['add_lm']==true){?> | <a href="<?php echo $conf['sy']['folder_lm'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
        <?php
        }
		?>
        <li><a href="<?php echo $conf['sy']['folder_co'];?>/default.php" target="mainFrame"><?php echo $conf['sy']['name'];?>内容管理</a><?php if ($conf['co']['add_xx']==true){?> | <a href="<?php echo $conf['sy']['folder_co'];?>/add.php"  target="mainFrame">添加</a><?php }?></li>
    </ul> -->
	<h3>Instant Messenger</h3>
    <ul>
    	<li class="li_01">
			<SCRIPT LANGUAGE="JavaScript">
				<!--
				document.write("Javascript 可执行") 
				//-->
            </SCRIPT>
            <noscript>Javascript 不执行</noscript>
        </li>
    	<li class="li_01">
			<SCRIPT LANGUAGE="JavaScript">   
				<!--  
				function chkFlash() {
					var isIE = (navigator.appVersion.indexOf("MSIE") >= 0);
					var hasFlash = true;
				
					if(isIE) {
						try{
							var objFlash = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
						} catch(e) {
							hasFlash = false;
						}
					} else {
						if(!navigator.plugins["Shockwave Flash"]) {
							hasFlash = false;
						}
					}
					return hasFlash;
				}
				(chkFlash)?document.write('Flash 插件已安装'):document.write('Flash 插件未安装');          
				//-->       
            </SCRIPT>
  		</li>
    </ul>
</div>
</body>
</html>
