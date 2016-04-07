<?php
require('../../../include/common.inc.php');
require('pl_con.php');

checklogin();

//获取哪条信息id需要多图，添加信息时是没有id系统自动生成一个临时id用session来保存，等信息添加后，再用信息的id来替换session保存的临时id
$pl_id=isset($_GET['pl_id'])?$_GET['pl_id']:'';
if ($pl_id!=''&&!checknum($pl_id)){
	msg('参数错误');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加信息</title>
<link href="../../css/admin_style.css" type="text/css" rel="stylesheet"/>
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
<FORM name="form1" method="post" action="pl_addd.php" onSubmit="return check()">
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
<input type="hidden" name="pl_id" value="<?php echo $pl_id;?>" />
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg">
    <td width="100" align="right">标　　题：</td>
    <td><INPUT name="title" type="text" id="title" size="50" maxlength="150"> <span class="red">*</span></td>
  </tr>
  <?php
  if ($conf['pl']['link_url']==true){
  ?>
  <tr class="tdbg">
    <td align="right">连接地址：</td>
    <td><INPUT name="link_url" type="text" id="link_url" size="57" maxlength="250"></td>
  </tr>
  <?php
  }
  ?>
  <tr class="tdbg">
    <td align="right">详细介绍：</td>
    <td>
    <textarea id="z_body" name="z_body" style="width:670px;height:300px;display:none;"></textarea>
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
  if ($conf['pl']['img_sl']==true){
	require('up_image_tool/upcon.php');
  ?>
  <tr class="tdbg" >          
    <td align="right">图片上传：</td>          
    <td >
    <iframe name="frame1" id="frame1" src="up_image_tool/up.php?frameid=frame1&kuang=img_sl" style="margin-top:2px; width:auto; width:380px; height:22px; overflow:hidden;" frameborder="0"  scrolling="no"></iframe>  			    
    <input type="hidden" name="img_sl" id="img_sl">
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
    <td align="right">显示顺序：</td>
    <td><INPUT name="px" type="text" id="px" value="100" size="5" maxlength="11" >
     <span class="red">* (从小到大排序)</span></td>
  </tr>
</table>
</div>
<div id="con_2" style="display:none;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg">
    <td width="100" height="22" align="right">页面标题：</td>
    <td>
    <textarea name="ym_tit" cols="80" rows="3"></textarea><br />
	建议填写不超过80个字，不要使用“回车键”换行
    </td>
  </tr>
  
  <tr class="tdbg">
    <td height="22" align="right" >页面关键字：</td>
    <td >
    <textarea name="ym_key" cols="80" rows="3"></textarea><br />
	建议填写不超过100个字，不要使用“回车键”换行
    </td>
  </tr>
  
  <tr class="tdbg">
    <td height="22" align="right" class="tdbg">页面描述：</td>
    <td><textarea name="ym_des" cols="80" rows="3"></textarea><br />
    建议填写不超过200个字，不要使用“回车键”换行
    </td>
  </tr>
</table>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="100">&nbsp;</td>
    <td><input type="submit" name="Submit" value="提 交" class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value="取 消" onClick="parent.tanchuCancle()" class="btn"></td>
  </tr>
</table>
</FORM>
</body>
</html>
