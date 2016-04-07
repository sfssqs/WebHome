<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$id=isset($_GET['id'])?$_GET['id']:'';
if ($id==''||!checknum($id)){
	msg('参数错误');
}

$row=$db->getrs('select * from `'.$conf['sy']['table_lm'].'` where `id_lm`='.$id.'');
if (!$row){
	msg('该分类不存在或已删除');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改分类</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<SCRIPT language="JavaScript" type="text/JavaScript">
function check(){
	if(gt('title_lm').value==''){
		alert('分类名称不能为空');
		gt('title_lm').focus();
		return false;
	}
	if(gt('px').value==''){
		alert('分类的显示顺序不能为空');
		gt('px').focus();
		return false;
	}
}
</SCRIPT>
<script src="../scripts/function.js"></script>
</head>

<body>
<DIV id=popImageLayer style="VISIBILITY: hidden; WIDTH: 267px; CURSOR: hand; POSITION: absolute; HEIGHT: 260px; background-image:url(../images/bbg.gif); z-index: 100;" align=center  name="popImageLayer"  ></DIV>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">修改分类</td>
  </tr>
  <tr class="tdbg" <?php if ($conf['lm']['add_lm']==false){echo ' style="display:none;"';}?>>
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加分类</a></td>
  </tr>
</table>

<br />
<FORM name="form1" method="post" action="editt.php" onSubmit="return check()">
<input name="id" type="hidden" id="id" value="<?php echo $id?>"/>
<div id="tits" class="subnav">
    <ul>
    	<?php
        if ($conf['lm']['seo']==true){
			echo '<li onclick="settab(\'tits\',\'con\',1)" class="cur" >详细信息</li>';
			echo '<li onclick="settab(\'tits\',\'con\',2)" class="">seo设置</li>';
        }
		?>
    </ul>
</div>
<div id="con_1">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg">
    <td width="120" align="right">上级分类：</td>
    <td>
    <select name="fid" id="fid">
      <option value="0" selected="selected">无{作为一级分类}</option>
    	<?php
		//把所有分类放到$rss数组里
        $rss=$db->getrss('select * from `'.$conf['sy']['table_lm'].'` order by `px` desc,`id_lm` desc');
		//无限级分类开始
		addlm($rss,0,'');
		//通过$fid来判读当前循环哪个级别，然后不断地递归循环
		function addlm($rss,$fid,$i){
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
					echo'<option value="'.$rs["id_lm"].'">'.$i.$rs["title_lm"].'</option>'."\n";
					addlm($rss,$rs['id_lm'],$i);
				}
			}
		}
		?>
    </select>
    <script>
    gt('fid').value='<?php echo $row['fid']?>';
    </script>
    </td>
  </tr>
  <tr class="tdbg">
    <td width="120" align="right">分类名称：</td>
    <td><INPUT name="title_lm" type="text" id="title_lm" size="30" maxlength="150" value="<?php echo $row['title_lm']?>"> <span class="red">*</span></td>
  </tr>
    <?php
  if ($conf['lm']['en']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right">英文分类名称：</td>
    <td><INPUT name="title_lm_en" type="text" id="title_lm_en" size="30" maxlength="150" value="<?php echo $row['title_lm_en']?>"> <span class="red">*</span></td>
  </tr>
  <?php }?>
  <?php
  if ($conf['lm']['url_lm']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right">连接地址：</td>
    <td><INPUT name="url_lm" type="text" id="url_lm" size="57" maxlength="250" value="<?php echo $row['url_lm']?>"></td>
  </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['lm']['f_body_lm']==true){
  ?>
  <tr class="tdbg">
    <td align="right" valign="top"><br />
      简要介绍：</td>
    <td ><textarea name="f_body_lm" rows="4" id="f_body_lm" style="width:450px;"><?php echo rehtml($row['f_body_lm'])?></textarea></td>
  </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['lm']['z_body_lm']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right">内　　容：</td>
    <td>
    <textarea id="z_body_lm" name="z_body_lm" style="width:670px;height:300px;display:none;"><?php echo $row['z_body_lm']?></textarea>
    </td>
  </tr>
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
			//2.只要复制多下面这行代码"K.create('textarea[name="z_body_lm"]',options);"
			//3.然后改一下文本区域的名字
            K.create('textarea[name="z_body_lm"]',options);
        });
    </script>
  <?php
  }
  ?>
  <?php
  if ($conf['lm']['img_sl_lm']==true){
	require('up_image_tool/upcon.php');
  ?>
  <tr class="tdbg" >          
    <td width="120" align="right">图片上传：</td>          
    <td >
    <IFRAME name="frame1" id="frame1" src="up_image_tool/uploadd.php?frameid=frame1&kuang=img_sl_lm&img_sl=<?php echo $row['img_sl_lm']?>" style="margin-top:2px; width:auto; width:380px; height:22px; overflow:hidden;" frameborder="0"  scrolling="no"></iframe>  			    
    <input type="hidden" name="img_sl_lm" id="img_sl_lm" value="<?php echo $row['img_sl_lm']?>" />
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
  <?php
  }
  ?>
  <tr class="tdbg">
    <td width="120" align="right">显示顺序：</td>
    <td><INPUT name="px" type="text" id="px" size="5" maxlength="10"  value="<?php echo $row['px']?>">
      <span class="red">* (从大到小排序)</span></td>
  </tr>
    <tr class="tdbg" <?php if ($conf['lm']['con_att']==false){echo 'style="display:none;"';}?>>
    <td align="right">分类属性：</td>
    <td>
      <input name="gao" type="checkbox" class="checkbox" id="gao" value="yes" onClick="if(this.checked==true){gt('gaoji').style.display='';}else{gt('gaoji').style.display='none';}">
    显示高级设置</td>
  </tr>
  <tr class="tdbg"  id="gaoji" style="display:none;">
    <td align="right">&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30"><label>
          <input name="add_xx" type="radio" class="radio" id="add_xx" value="yes" <?php if ($row['add_xx']=='yes'){echo' checked';}?>>
          是
          <input type="radio" name="add_xx" class="radio" id="add_xx" value="no" <?php if ($row['add_xx']=='no'){echo' checked';}?>>
        否 可以添加信息</label></td>
      </tr>
      <tr>
        <td height="30"><label>
          <input name="add_xia" type="radio" class="radio" id="add_xia" value="yes" <?php if ($row['add_xia']=='yes'){echo' checked';}?>>
          是
          <input type="radio" name="add_xia" class="radio" id="add_xia" value="no" <?php if ($row['add_xia']=='no'){echo' checked';}?>>
        否 有下级分类</label></td>
      </tr>
        <tr>
          <td height="23">
            <input name="con_att" type="radio" class="radio" id="con_att" value="1" <?php if ($row['con_att']=='1'){echo' checked="checked"';}?> />
            完全控制
            <input name="con_att" type="radio" class="radio" id="con_att2" value="2" <?php if ($row['con_att']=='2'){echo' checked="checked"';}?> />
            只能读取、修改(不能删除)
            <input name="con_att" type="radio" class="radio" id="con_att3" value="3" <?php if ($row['con_att']=='3'){echo' checked="checked"';}?> />
            只能读取(不能修改，不能删除)
          </td>
        </tr>
      <tr>
        <td height="30"><label>
          <input name="info_keyword" type="radio" class="radio" id="info_keyword" value="yes" <?php if ($row['info_keyword']=='yes'){echo' checked';}?>>
          是
          <input name="info_keyword" type="radio" class="radio" id="info_keyword" value="no" <?php if ($row['info_keyword']=='no'){echo' checked';}?>>
        否 有关键字</label></td>
      </tr>
      <tr>
        <td height="30"><label>
          <input name="info_link" type="radio" class="radio" id="info_link" value="yes" <?php if ($row['info_link']=='yes'){echo' checked';}?>>
          是
          <input name="info_link" type="radio" class="radio" id="info_link" value="no"  <?php if ($row['info_link']=='no'){echo' checked';}?>>
        否 有链接地址</label></td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_from" type="radio" class="radio" id="info_from" value="yes" <?php if ($row['info_from']=='yes'){echo' checked';}?>>
          是
          <input name="info_from" type="radio" class="radio" id="info_from" value="no"  <?php if ($row['info_from']=='no'){echo' checked';}?>>
        否 有信息来源和信息作者</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_f_body" type="radio" class="radio" id="info_f_body" value="yes" <?php if ($row['info_f_body']=='yes'){echo' checked';}?>>
          是
          <input name="info_f_body" type="radio" class="radio" id="info_f_body" value="no"  <?php if ($row['info_f_body']=='no'){echo' checked';}?>>
        否 有简要介绍</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_z_body" type="radio" class="radio" id="info_z_body" value="yes" <?php if ($row['info_z_body']=='yes'){echo' checked';}?>>
          是
          <input name="info_z_body" type="radio" class="radio" id="info_z_body" value="no"  <?php if ($row['info_z_body']=='no'){echo' checked';}?>>
        否 有详细介绍</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_img_sl" type="radio" class="radio" id="info_img_sl" value="yes" <?php if ($row['info_img_sl']=='yes'){echo' checked';}?> onclick="document.getElementById('tr_s').style.display=''">
          是
          <input name="info_img_sl" type="radio" class="radio" id="info_img_sl" value="no"  <?php if ($row['info_img_sl']=='no'){echo' checked';}?>  onclick="document.getElementById('tr_s').style.display='none'">
        否 有图片上传</td>
      </tr>
	  <tr  id="tr_s" <?php if ($row['info_img_sl']=='no'){echo 'style="display:none;"';}?>>
        <td height="30"  style="background-color:#F9D2D0; padding:5px;">
        图片上传提示尺寸：<input name="info_img_txt" id="info_img_txt" type="text" style="width:180px;" value="<?php echo $row['info_img_txt']?>" /><br />
          <input type="radio" name="info_img_pic" id="info_img_pic" value="yes" <?php if ($row['info_img_pic']=='yes'){echo' checked';}?> onclick="document.getElementById('tb_s').style.display=''">
          是
          <input name="info_img_pic" type="radio" id="info_img_pic" value="no" <?php if ($row['info_img_pic']=='no'){echo' checked';}?> onclick="document.getElementById('tb_s').style.display='none'">
        否 生成缩略图
        <table border="0" cellspacing="0" cellpadding="2" id="tb_s" <?php if ($row['info_img_pic']=='no'){echo 'style="display:none;"';}?> >
          <tr>
          <td>类型</td>
            <td>
            <select name="info_img_typ" id="info_img_typ">
                <option value="yes">固定尺寸</option>
                <option value="no">不超过尺寸</option>
            </select>
            <script>
            document.getElementById("info_img_typ").value="<?php echo $row['info_img_typ']?>";
            </script>
            </td>
            <td>宽度</td>
            <td><input type="text" size="8" name="info_img_wid" value="<?php echo $row['info_img_wid']?>"/></td>
            <td>高度</td>
            <td><input type="text" size="8" name="info_img_hei"  value="<?php echo $row['info_img_hei']?>"/></td>
          </tr>
        </table>
        </td>
      </tr>
<tr>
        <td height="30">
          <input name="info_pic_sl" type="radio" class="radio" value="yes" <?php if ($row['info_pic_sl']=='yes'){echo' checked';}?> onclick="document.getElementById('tr_d').style.display=''">
          是
          <input name="info_pic_sl" type="radio" class="radio" value="no"  <?php if ($row['info_pic_sl']=='no'){echo' checked';}?>  onclick="document.getElementById('tr_d').style.display='none'">
        否 有图片2上传</td>
      </tr>
	  <tr  id="tr_d" <?php if ($row['info_pic_sl']=='no'){echo 'style="display:none;"';}?>>
        <td height="30"  style="background-color:#F9D2D0; padding:5px;">
        图片2上传提示尺寸：
          <input name="info_pic_txt" id="info_pic_txt" type="text" style="width:180px;" value="<?php echo $row['info_pic_txt']?>" /><br />
          <input type="radio" name="info_pic_pic"  value="yes" <?php if ($row['info_pic_pic']=='yes'){echo' checked';}?> onclick="document.getElementById('tb_d').style.display=''">
          是
          <input name="info_pic_pic" type="radio"  value="no" <?php if ($row['info_pic_pic']=='no'){echo' checked';}?> onclick="document.getElementById('tb_d').style.display='none'">
        否 生成缩略图
        <table border="0" cellspacing="0" cellpadding="2" id="tb_d" <?php if ($row['info_pic_pic']=='no'){echo 'style="display:none;"';}?> >
          <tr>
          <td>类型</td>
            <td>
            <select name="info_pic_typ" id="info_pic_typ">
                <option value="yes">固定尺寸</option>
                <option value="no">不超过尺寸</option>
            </select>
            <script>
            document.getElementById("info_pic_typ").value="<?php echo $row['info_pic_typ']?>";
            </script>
            </td>
            <td>宽度</td>
            <td><input type="text" size="8" name="info_pic_wid" value="<?php echo $row['info_pic_wid']?>"/></td>
            <td>高度</td>
            <td><input type="text" size="8" name="info_pic_hei"  value="<?php echo $row['info_pic_hei']?>"/></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_fil_sl" type="radio" class="radio" value="yes" <?php if ($row['info_fil_sl']=='yes'){echo' checked';}?>>
          是
          <input name="info_fil_sl" type="radio" class="radio" value="no"  <?php if ($row['info_fil_sl']=='no'){echo' checked';}?>>
        否 有文件上传</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_vid_sl" type="radio" class="radio" value="yes" <?php if ($row['info_vid_sl']=='yes'){echo' checked';}?>>
          是
          <input name="info_vid_sl" type="radio" class="radio" value="no"  <?php if ($row['info_vid_sl']=='no'){echo' checked';}?>>
        否 有视频上传</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_duotu" type="radio" class="radio" value="yes" <?php if ($row['info_duotu']=='yes'){echo' checked';}?>>
          是
          <input name="info_duotu" type="radio" class="radio" value="no"  <?php if ($row['info_duotu']=='no'){echo' checked';}?>>
        否 有多图上传</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_info" type="radio" class="radio" value="yes" <?php if ($row['info_info']=='yes'){echo' checked';}?>>
          是
          <input name="info_info" type="radio" class="radio" value="no"  <?php if ($row['info_info']=='no'){echo' checked';}?>>
        否 有相关信息</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_file" type="radio" class="radio" value="yes" <?php if ($row['info_file']=='yes'){echo' checked';}?>>
          是
          <input name="info_file" type="radio" class="radio" value="no"  <?php if ($row['info_file']=='no'){echo' checked';}?>>
        否 有相关文件</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_video" type="radio" class="radio" value="yes" <?php if ($row['info_video']=='yes'){echo' checked';}?>>
          是
          <input name="info_video" type="radio" class="radio" value="no"  <?php if ($row['info_video']=='no'){echo' checked';}?>>
        否 有相关视频</td>
      </tr>
      <tr>
        <td height="30">
          <input name="info_wtime" type="radio" class="radio" id="info_wtime" value="yes" <?php if ($row['info_wtime']=='yes'){echo' checked';}?>>
          是
          <input name="info_wtime" type="radio" class="radio" id="info_wtime" value="no"  <?php if ($row['info_wtime']=='no'){echo' checked';}?>>
        否 有发布时间</td>
      </tr>

    </table></td>
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
    <td><input type="submit" name="Submit" value=" 保 存 " class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value=" 取 消 " onClick="location.href='default.php';" class="btn"></td>
  </tr>
</table>
</FORM>
</body>
</html>
