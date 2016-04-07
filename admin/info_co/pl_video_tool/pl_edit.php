<?php
require('../../../include/common.inc.php');
require('pl_con.php');

checklogin();

$id=isset($_GET['id'])?$_GET['id']:'';
$pl_id=isset($_GET['pl_id'])?$_GET['pl_id']:'';

if ($id==''||!checknum($id)){
	msg('参数错误');
}
if ($pl_id!=''&&!checknum($pl_id)){
	msg('参数错误');
}

$row=$db->getrs('select * from `'.$pl_table.'` where `id`='.$id.'');
if (!$row){
	msg('该信息不存在或已删除');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改视频</title>
<link href="../../css/admin_style.css" rel="stylesheet" />
<script src="../../scripts/function.js"></script>
<SCRIPT language="JavaScript" type="text/JavaScript">
function check(){
	if(gt('title').value==''){
		alert('标题不能为空');
		gt('title').focus();
		return false;
	}
	if(gt('px').value==''){
		alert('显示顺序不能为空');
		gt('px').focus();
		return false;
	}
}
</SCRIPT>
</head>

<body>
<FORM name="form1" method="post" action="pl_editt.php" onSubmit="return check()">
<div id="tits" class="subnav">
    <ul>
    	<?php
        if ($conf['pl']['seo']==true){
			echo '<li onclick="settab(\'tits\',\'con\',1)" class="cur" >详细信息</li>';
			echo '<li onclick="settab(\'tits\',\'con\',2)" class="">seo设置</li>';
        }
		?>
    </ul>
</div>
<div id="con_1">
<input type="hidden" name="id" value="<?php echo $id;?>" />
<input type="hidden" name="pl_id" value="<?php echo $pl_id;?>" />
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg">
    <td width="100" align="right">标　　题：</td>
    <td><INPUT name="title" type="text" id="title" size="50" maxlength="150" value="<?php echo $row['title']?>"> <span class="red">*</span></td>
  </tr>
  <?php
  if ($conf['pl']['link_url']==true){
  ?>
  <tr class="tdbg">
    <td align="right">连接地址：</td>
    <td><INPUT name="link_url" type="text" id="link_url" size="57" maxlength="250" value="<?php echo $row['link_url']?>"></td>
  </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['pl']['z_body']==true){
  ?>
  <tr class="tdbg">
    <td align="right">详细介绍：</td>
    <td>
    <textarea id="z_body" name="z_body" style="width:670px;height:300px;display:none;"><?php echo $row['z_body']?></textarea>
    </td>
  </tr>
    <link rel="stylesheet" href="../../kd_html/themes/default/default.css" />
    <script charset="utf-8" src="../../kd_html/kindeditor.js"></script>
    <script charset="utf-8" src="../../kd_html/lang/zh_CN.js"></script>
    <script>
        //设置参数
        var options = {
            allowFileManager : true,
            newlineTag : 'br',
			height: '290px'
        };
        KindEditor.ready(function(K) {
            //如需创建多个编辑器：
			//1.添加一个文本区域
			//2.只要复制多下面这行代码"K.create('textarea[name="z_body"]',options);"
			//3.然后改一下文本区域的名字
            K.create('textarea[name="z_body"]',options);
        });
    </script>
  <?php
  }
  ?>
  <?php
  if ($conf['pl']['img_sl']==true){
	require('up_image_tool/upcon.php');
  ?>
  <tr class="tdbg" >          
    <td align="right">图片上传：</td>          
    <td >
    <iframe name="frame1" id="frame1" src="up_image_tool/uploadd.php?frameid=frame1&kuang=img_sl&img_sl=<?php echo $row['img_sl']?>" style="margin-top:2px; width:auto; width:380px; height:22px; overflow:hidden;" frameborder="0"  scrolling="no"></iframe>  			    
    <input type="hidden" name="img_sl" id="img_sl" value="<?php echo $row['img_sl']?>" >
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
  <?php
  require('up_video_tool/upcon.php');
  ?>
   <tr class="tdbg"> 
    <td width="120" align="right" valign="top"><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>链接地址：</td>
      </tr>
      <tr>
        <td>上传视频：</td>
      </tr>
    </table></td>          
    <td >
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><input type="text" name="vid_sl" id="vid_sl" maxlength="250" style="width:380px;"  value="<?php echo $row['vid_sl']?>"></td>
            </tr>
            <tr>
                <td><iframe name="frame2" id="frame2" src="up_video_tool/uploadd.php?frameid=frame2&kuang=vid_sl&img_sl=<?php echo $row['vid_sl']?>" style="margin-top:2px; width:auto;width:380px; height:22px; overflow:hidden;" frameborder="0"  scrolling="no"></iframe>
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
        </table>
     </td>
  </tr>
  
    <tr class="tdbg">
    <td align="right">显示顺序：</td>
    <td><INPUT name="px" type="text" id="px" size="5" maxlength="11" value="<?php echo $row['px']?>" >
     <span class="red">* (从小到大排序)</span></td>
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
    <td width="100">&nbsp;</td>
    <td><input type="submit" name="Submit" value="保 存" class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value="取 消" onClick="parent.tanchuCancle()" class="btn"></td>
  </tr>
</table>
</FORM>


</body>
</html>
