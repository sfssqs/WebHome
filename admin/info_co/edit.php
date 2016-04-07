<?php
require('../../include/common.inc.php');
require('../info_lm/config.php');

checklogin();

$id=isset($_GET['id'])?$_GET['id']:'';
$url=(previous())?previous():'default.php';

if ($id==''||!checknum($id)){
	msg('参数错误');
}

$id_lm='';
$add_xx='';
$row=$db->getrs('select * from `'.$conf['sy']['table_co'].'` where `id`='.$id.'');
if (!$row){
	msg('该信息不存在或已删除');
}else{
	$rs=$db->getrs('select * from `'.$conf['sy']['table_lm'].'` where `id_lm`='.$row["lm"].'');
	if ($rs){
		$id_lm=$rs['id_lm'];
		$add_xx=$rs['add_xx'];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改<?php echo $conf['sy']['name'];?></title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
<script src="../scripts/jquery.js"></script>
<SCRIPT language="JavaScript" type="text/JavaScript">
function check(){
	<?php
	if ($conf['sy']['need_lm']==true){
	?>
	if (gt('lm').value=="0"){
		alert("请选择分类");
		gt('lm').focus();
		return false;
	}
	<?php
	}
	?>
	if (gt('lm').value=="no"){
		alert("所选分类不允许添加信息");
		gt('lm').focus();
		return false;
	}
	if(gt('title').value==''){
		alert('标题不能为空');
		gt('title').focus();
		return false;
	}
	if(gt('px').value==''){
		alert('信息的显示顺序不能为空');
		gt('px').focus();
		return false;
	}
}
function tanchuchuang(url,width,height) {
	tit='';
	var winWinth = $(window).width(), winHeight = $(document).height();
	$("body").append("<div class='winbj'></div>");
	$("body").append("<div class='tanChu' style='z-index:100;'><div class='winIframe' ></div></div>");
	str='<iframe id="fra_add" name="fra_add" src="'+url+'" style="width:'+width+'px; height:'+height+'px;" frameborder="0" scrolling="auto"></iframe>';
	$(".winIframe").html(str);
	$(".winbj").css({ width: winWinth, height: winHeight, background: "#000", position: "absolute", left: "0", top: "0" });
	$(".winbj").fadeTo(0, 0.3);
	var tanchuLeft = $(window).width() / 2 - width / 2;
	var tanchuTop = $(window).height() / 2 - height / 2 + $(window).scrollTop();
	$(".tanChu").css({ width: width, height: height, border: "3px #ccc solid",padding:"0px", left: tanchuLeft, top: tanchuTop, background: "#fff", position: "absolute"});
	var winIframeHeight = height - 26;

	$(".tanchuCancle").click(function() {
		$(".winbj").remove();
		$(".tanChu").remove();
		$(".winIframe").remove();
		return false
	});
}

function tanchuCancle(){
	$(".winbj").remove();
	$(".tanChu").remove();
	$(".winIframe").remove();
}
</SCRIPT>
<script>
<?php 
echo'shu_lm=new Array();'."\n";
$sql='select * from `'.$conf['sy']['table_lm'].'`';
$result=$db->query($sql);
$a=0;
while($rs=$db->getrow($result)){
	echo'shu_lm['.$a.']=new Array('.$rs['id_lm'].',"'.$rs['info_keyword'].'","'.$rs['info_link'].'","'.$rs['info_from'].'","'.$rs['info_f_body'].'","'.$rs['info_z_body'].'","'.$rs['info_img_sl'].'","'.$rs['info_img_txt'].'","'.$rs['info_img_pic'].'","'.$rs['info_img_typ'].'","'.$rs['info_img_wid'].'","'.$rs['info_img_hei'].'","'.$rs['info_pic_sl'].'","'.$rs['info_pic_txt'].'","'.$rs['info_pic_pic'].'","'.$rs['info_pic_typ'].'","'.$rs['info_pic_wid'].'","'.$rs['info_pic_hei'].'","'.$rs['info_fil_sl'].'","'.$rs['info_vid_sl'].'","'.$rs['info_duotu'].'","'.$rs['info_info'].'","'.$rs['info_file'].'","'.$rs['info_video'].'","'.$rs['info_wtime'].'")'."\n";
	$a++;
}
$db->freeresult($result);
echo'var counter='.$a.';'."\n";
?>
function check_display(){
	var dis_keyword=gt("dis_keyword");
	var dis_uselink=gt("dis_uselink");
	var dis_info_from=gt("dis_info_from");
	var dis_f_body=gt("dis_f_body");
	var dis_z_body=gt("dis_z_body");
	var dis_img_sl=gt("dis_img_sl");
	var img_sl_txt=gt("img_sl_txt");
	var dis_frame1=gt("frame1");
	var dis_pic_sl=gt("dis_pic_sl");
	var pic_sl_txt=gt("pic_sl_txt");
	var dis_frame4=gt("frame4");
	var dis_fil_sl=gt("dis_fil_sl");
	var dis_vid_sl=gt("dis_vid_sl");
	var dis_duotu=gt("dis_duotu");
	var dis_info=gt("dis_info");
	var dis_file=gt("dis_file");
	var dis_video=gt("dis_video");
 	var dis_wtime=gt("dis_wtime");
	var lm=gt('lm').value;
	var img_sl=gt("img_sl").value;
	var pic_sl=gt("pic_sl").value;
	for(i=0;i<counter;i++){
		if(lm==shu_lm[i][0]){
			(shu_lm[i][1]=='yes')?dis_keyword.style.display='':dis_keyword.style.display='none';
			(shu_lm[i][2]=='yes')?dis_uselink.style.display='':dis_uselink.style.display='none';
			(shu_lm[i][3]=='yes')?dis_info_from.style.display='':dis_info_from.style.display='none';
			(shu_lm[i][4]=='yes')?dis_f_body.style.display='':dis_f_body.style.display='none';
			(shu_lm[i][5]=='yes')?dis_z_body.style.display='':dis_z_body.style.display='none';
			if(shu_lm[i][6]=="yes"){
				dis_img_sl.style.display="";
				img_sl_txt.innerHTML=''+shu_lm[i][7]+'';
				dis_frame1.src="up_info_tool/uploadd.php?frameid=frame1&kuang=img_sl&img_sl="+img_sl+"&s_pic="+shu_lm[i][8]+"&s_typ="+shu_lm[i][9]+"&s_wid="+shu_lm[i][10]+"&s_hei="+shu_lm[i][11];
			}else{
				dis_img_sl.style.display="none";
			}
			if(shu_lm[i][12]=="yes"){
				dis_pic_sl.style.display="";
				pic_sl_txt.innerHTML=''+shu_lm[i][13]+'';
				dis_frame4.src="up_info_tool/uploadd.php?frameid=frame4&kuang=pic_sl&img_sl="+pic_sl+"&s_pic="+shu_lm[i][14]+"&s_typ="+shu_lm[i][15]+"&s_wid="+shu_lm[i][16]+"&s_hei="+shu_lm[i][17];
			}else{
				dis_pic_sl.style.display="none";
			}
			(shu_lm[i][18]=='yes')?dis_fil_sl.style.display='':dis_fil_sl.style.display='none';
			(shu_lm[i][19]=='yes')?dis_vid_sl.style.display='':dis_vid_sl.style.display='none';
			(shu_lm[i][20]=='yes')?dis_duotu.style.display='':dis_duotu.style.display='none';
			(shu_lm[i][21]=='yes')?dis_info.style.display='':dis_info.style.display='none';
			(shu_lm[i][22]=='yes')?dis_file.style.display='':dis_file.style.display='none';
			(shu_lm[i][23]=='yes')?dis_video.style.display='':dis_video.style.display='none';
			(shu_lm[i][24]=='yes')?dis_wtime.style.display='':dis_wtime.style.display='none';
			break;
		}
	}
}
</script>
</head>

<body>
<DIV id=popImageLayer style="VISIBILITY: hidden; WIDTH: 267px; CURSOR: hand; POSITION: absolute; HEIGHT: 260px; background-image:url(../images/bbg.gif); z-index: 100;" align=center  name="popImageLayer"  ></DIV>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">修改<?php echo $conf['sy']['name'];?></td>
  </tr>
  <tr class="tdbg" <?php if ($conf['co']['add_xx']==false){echo ' style="display:none;"';}?>>
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加<?php echo $conf['sy']['name'];?></a></td>
  </tr>
</table>
<br />
<FORM name="form1" id="form1" method="post" action="editt.php" onSubmit="return check()">
<input name="id" type="hidden" id="id" value="<?php echo $id?>"/>
<input name="url" type="hidden" id="url" value="<?php echo $url?>"/>
<div id="tits" class="subnav">
    <ul>
    	<?php
        if ($conf['co']['seo']==true){
			echo '<li onclick="settab(\'tits\',\'con\',1)" class="cur" >详细信息</li>';
			echo '<li onclick="settab(\'tits\',\'con\',2)" class="">seo设置</li>';
        }
		?>
    </ul>
</div>
<div id="con_1">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg" <?php if ($conf['sy']['need_lm']==false){echo ' style="display:none;"';}?>>
    <td width="120" align="right">所属分类：</td>
    <td>
    <select name="lm" id="lm" onchange="check_display()">
      <option value="0" selected="selected">请选择分类</option>
    	<?php
		//把所有分类放到$rss数组里
        $rss=$db->getrss('select * from `'.$conf['sy']['table_lm'].'` order by `px` desc,`id_lm` desc');
		//无限级分类开始
		addlm($rss,0,'');
		//通过$fid来判读当前循环哪个级别，然后不断地递归循环
		function addlm($rss,$fid,$i){
			global $id_lm,$add_xx;
			//通过判断$i为空设定一级分类的标志为"• "，同时为二级判断留下标志
			if ($i==''){
				$i='• ';
			//通过判断$i为"• "设定二级分类的标志为" 　|—"
			}elseif ($i=='• '){
				$i=' 　|—';
			//其他级别的标志全部都是" 　|"加上上一级的标志
			}else{
				$i=' 　|'.$i;
			}
			//遍历所有分类数组根据传入的$fid来显示哪个级别，同时继续执行自己
			foreach($rss as $rs){
				if($rs['fid']==$fid){
					if($rs['add_xx']=='yes'||($rs['id_lm']==$id_lm&&$add_xx=='no')){
						echo'<option value="'.$rs["id_lm"].'">'.$i.$rs["title_lm"].'</option>'."\n";	
					}else{
						echo'<option value="no">'.$i.$rs["title_lm"].'×</option>'."\n";
					}
					addlm($rss,$rs['id_lm'],$i);
				}
			}
		}
		?>
    </select>
    <?php
    if($add_xx=='no'){
		echo '<script>gt("lm").value="'.$row['lm'].'";gt("lm").disabled="disabled";</script>'."\n";	
		echo'<input name="lm" id="lm" type="hidden" value="'.$row["lm"].'"/>';	
	}else{
		echo '<script>gt("lm").value="'.$row['lm'].'";</script>'."\n";		
	}
	?>
    </td>
  </tr>
  <tr class="tdbg">
    <td width="120" align="right">标　　题：</td>
    <td>
    <INPUT name="title" type="text" id="title" size="50" maxlength="150" value="<?php echo $row['title']?>"> <span class="red">*</span>
    <select name="color_font" id="color_font" style="display:none;">
      <option value="" selected>颜色</option>
      <option value="#000000" style="background-color:#000000"></option>
      <option value="#FFFFFF" style="background-color:#FFFFFF"></option>
      <option value="#008000" style="background-color:#008000"></option>
      <option value="#800000" style="background-color:#800000"></option>
      <option value="#808000" style="background-color:#808000"></option>
      <option value="#000080" style="background-color:#000080"></option>
      <option value="#800080" style="background-color:#800080"></option>
      <option value="#808080" style="background-color:#808080"></option>
      <option value="#FFFF00" style="background-color:#FFFF00"></option>
      <option value="#00FF00" style="background-color:#00FF00"></option>
      <option value="#00FFFF" style="background-color:#00FFFF"></option>
      <option value="#FF00FF" style="background-color:#FF00FF"></option>
      <option value="#FF0000" style="background-color:#FF0000"></option>
      <option value="#0000FF" style="background-color:#0000FF"></option>
      <option value="#008080" style="background-color:#008080"></option>
    </select>
    <script>
    	gt('color_font').value='<?php echo $row['color_font']?>';
    </script>    </td>
  </tr>
  
   <?php
  if ($conf['co']['en']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right">英文标题：</td>
    <td><INPUT name="title_en" type="text" id="title_en" size="50" maxlength="150" value="<?php echo $row['title_en']?>" <?php if($add_xx=='no'){echo' readonly="readonly" style="background-color:#e4e4e4;"';}?>> <span class="red">*</span></td>
  </tr>
  <?php
    }
	?>
  
  
  <tr class="tdbg" id="dis_keyword" style="display:none;">
    <td width="120" align="right">&nbsp;关&nbsp; 键&nbsp; 字：</td>
    <td><INPUT name="keyword" type="text" id="keyword" size="50" maxlength="50" value="<?php echo $row['keyword']?>"></td>
  </tr>
  <tr  class="tdbg" id="dis_uselink">
    <td align="right">连接地址：</td>
    <td>
    <input name="link_url" type="text" id="link_url" size="57" maxlength="250" value="<?php echo $row['link_url']?>">    </td>
  </tr>
  <tr class="tdbg" id="dis_info_from" style="display:none;">           
    <td width="120" align="right">信息来源：</td>          
    <td ><input name="info_from" type="text" id="info_from" value="<?php echo $row['info_from']?>" size="24"   maxlength="50">
          &nbsp; 信息作者：<input name="info_author" type="text" id="info_author" value="<?php echo $row['info_author']?>" size="23"   maxlength="50"/>    </td >
  </tr>
  <tr class="tdbg"  id="dis_f_body" style="display:none;">
    <td align="right" valign="top"><strong><br>
    </strong>简要介绍：</td>
    <td ><textarea name="f_body" rows="4" id="f_body" style="width:574px;"><?php echo rehtml($row['f_body'])?></textarea></td>
  </tr>
  
  
  <?php
  if ($conf['co']['en']==true){
  ?>
  <tr class="tdbg" style="display:none;">
    <td align="right" valign="top"><br />
      英文简要介绍：</td>
    <td ><textarea name="f_body_en" rows="4" id="f_body_en" style="width:450px;"><?php echo rehtml($row['f_body_en'])?></textarea></td>
  </tr>
  <?php
    }
	?>
  
  
  <tr class="tdbg" id="dis_z_body">
    <td width="120" align="right">详细介绍：</td>
    <td>
    <textarea id="z_body" name="z_body" style="width:670px;height:300px;display:none;"><?php echo $row['z_body']?></textarea>
    </td>
  </tr>
  
  <?php
  if ($conf['co']['en']==true){
  ?>
  <tr class="tdbg" style="display:none;">
    <td width="120" align="right">英文内容：</td>
    <td>
    <textarea id="z_body_en" name="z_body_en" style="width:670px;height:300px;display:none;"><?php echo $row['z_body_en']?></textarea>
    </td>
  </tr>
  <?php
    }
	?>
  
  
    <link rel="stylesheet" href="../kd_html/themes/default/default.css" />
    <script charset="utf-8" src="../kd_html/kindeditor.js"></script>
    <script charset="utf-8" src="../kd_html/lang/zh_CN.js"></script>
    <script>
        //设置参数
        var options = {
            allowFileManager : true,
            newlineTag : 'br'
        };
        KindEditor.ready(function(K) {
            //如需创建多个编辑器：
			//1.添加一个文本区域
			//2.只要复制多下面这行代码"K.create('textarea[name="z_body"]',options);"
			//3.然后改一下文本区域的名字
            K.create('textarea[name="z_body"]',options);
            K.create('textarea[name="z_body_en"]',options);
        });
    </script>
  <tr class="tdbg" id="dis_img_sl" style="display:none;">          
    <td width="120" align="right">图片上传：</td>          
    <td >
    <iframe name="frame1" id="frame1" src="up_info_tool/uploadd.php?frameid=frame1&kuang=img_sl" style="margin-top:2px; width:auto;width:380px; height:22px; overflow:hidden;" frameborder="0"  scrolling="no"></iframe>
    <input type="hidden" name="img_sl" id="img_sl" value="<?php echo $row['img_sl']?>">
    <br />
    <span id="img_sl_txt" class="red"></span></td>
  </tr>
  <tr class="tdbg" id="dis_pic_sl" style="display:none;">          
    <td width="120" align="right">图片2上传：</td>          
    <td >
    <iframe name="frame4" id="frame4" src="up_info_tool/uploadd.php?frameid=frame4&kuang=pic_sl" style="margin-top:2px; width:auto;width:380px; height:22px; overflow:hidden;" frameborder="0"  scrolling="no"></iframe>
    <input type="hidden" name="pic_sl" id="pic_sl" value="<?php echo $row['pic_sl']?>">
    <br />
    <span id="pic_sl_txt" class="red"></span></td>
  </tr>
  <?php
  require('up_file_tool/upcon.php');
  ?>
   <tr class="tdbg" id="dis_fil_sl" style="display:none;"> 
    <td width="120" align="right" valign="top">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>链接地址：</td>
      </tr>
      <tr>
        <td>上传文件：</td>
      </tr>
    </table>
    </td>          
    <td >
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><input type="text" name="fil_sl" id="fil_sl" maxlength="250" style="width:380px;"  value="<?php echo $row['fil_sl']?>"></td>
            </tr>
            <tr>
                <td><iframe name="frame2" id="frame2" src="up_file_tool/uploadd.php?frameid=frame2&kuang=fil_sl&img_sl=<?php echo $row['fil_sl']?>" style="margin-top:2px; width:auto;width:380px; height:22px; overflow:hidden;" frameborder="0"  scrolling="no"></iframe>
					<?php
                    if(isset($s_txt)&&$s_txt!=''){
                    ?>
                        <br />
                        <span class="red"><?php echo $s_txt?></span>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        </table>     </td>
  </tr>
  <?php
  require('up_video_tool/upcon.php');
  ?>
    <tr class="tdbg" id="dis_vid_sl" style="display:none;">          
        <td width="120" align="right" valign="top">
          <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>链接地址：</td>
          </tr>
          <tr>
            <td>上传视频：</td>
          </tr>
        </table>
        </td>          
        <td >
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><input type="text" name="vid_sl" id="vid_sl" maxlength="250" style="width:380px;"  value="<?php echo $row['vid_sl']?>"></td>
            </tr>
            <tr>
                <td><iframe name="frame3" id="frame3" src="up_video_tool/uploadd.php?frameid=frame3&kuang=vid_sl&img_sl=<?php echo $row['vid_sl']?>" style="margin-top:2px; width:auto;width:380px; height:22px; overflow:hidden;" frameborder="0"  scrolling="no"></iframe>
					<?php
                    if(isset($s_txt)&&$s_txt!=''){
                    ?>
                        <br />
                        <span class="red"><?php echo $s_txt?></span>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        </table></td>
    </tr>
  <tr class="tdbg" id="dis_duotu" style="display:none;">
    <td width="120" align="right">多图上传：</td>
    <td >
    <iframe id="fra_duotu" name="fra_duotu" src="pl_image_tool/pl_default.php?pl_id=<?php echo $id?>" style="width:670px; height:285px;" frameborder="0" scrolling="auto"></iframe>
    </td>
  </tr>
  <tr class="tdbg" id="dis_info" style="display:none;">
    <td width="120" align="right">相关信息：</td>
    <td >
	<iframe id="fra_info" name="fra_info" src="pl_info_tool/pl_default.php?pl_id=<?php echo $id?>" style="width:670px; height:285px;" frameborder="0" scrolling="auto"></iframe>
    </td>
  </tr>
  <tr class="tdbg" id="dis_file" style="display:none;">
    <td width="120" align="right">相关文件：</td>
    <td >
	<iframe id="fra_file" name="fra_file" src="pl_file_tool/pl_default.php?pl_id=<?php echo $id?>" style="width:670px; height:285px;" frameborder="0" scrolling="auto"></iframe>
    </td>
  </tr>
  <tr class="tdbg" id="dis_video" style="display:none;">
    <td width="120" align="right">相关视频：</td>
    <td >
	<iframe id="fra_video" name="fra_video" src="pl_video_tool/pl_default.php?pl_id=<?php echo $id?>" style="width:670px; height:285px;" frameborder="0" scrolling="auto"></iframe>
    </td>
  </tr>

  <tr class="tdbg" id="dis_wtime">
    <td width="120" align="right">发布时间：</td>
    <td ><input name="wtime" type="text" id="wtime" value="<?php echo date('Y-m-d H:i:s',$row['wtime'])?>" maxlength="50">              时间格式为“年-月-日 时:分:秒”，如：<font color="#0000FF">2003-5-12 12:32:47</font></td>
  </tr>
    <tr class="tdbg">
    <td width="120" align="right">显示顺序：</td>
    <td><INPUT name="px" type="text" id="px" size="5" maxlength="11" value="<?php echo $row['px']?>" >
     <span class="red">* (从大到小排序)</span></td>
  </tr>
</table>
</div>
<div id="con_2" style="display:none;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg">
    <td width="120" height="22" align="right">页面标题：</td>
    <td>
    <textarea name="ym_tit" cols="80" rows="3"><?php echo rehtml($row['ym_tit'])?></textarea><br />
	建议填写不超过80个字，不要使用“回车键”换行
    </td>
  </tr>
  
  <tr class="tdbg">
    <td width="120" height="22" align="right" >页面关键字：</td>
    <td >
    <textarea name="ym_key" cols="80" rows="3"><?php echo rehtml($row['ym_key'])?></textarea><br />
	建议填写不超过100个字，不要使用“回车键”换行
    </td>
  </tr>
  
  <tr class="tdbg">
    <td width="120" height="22" align="right" class="tdbg">页面描述：</td>
    <td><textarea name="ym_des" cols="80" rows="3"><?php echo rehtml($row['ym_des'])?></textarea><br />
    建议填写不超过200个字，不要使用“回车键”换行
    </td>
  </tr>
</table>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value=" 保 存 " class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value=" 取 消 " onClick="location.href='<?php echo $url?>';" class="btn"></td>
  </tr>
</table>
</FORM>
<script>check_display();</script>
</body>
</html>
