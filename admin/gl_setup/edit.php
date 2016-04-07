<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$row=$db->getrs('select * from `'.$tablepre.'gl_setup` where `id`=1');
if (!$row){
	msg('该信息不存在或已删除');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>网站基本配置</title>
<LINK href="../css/admin_style.css" rel="stylesheet" type="text/css">
<script src="../scripts/function.js"></script>
<script src="../scripts/jquery.js"></script>
</head>
<body >
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="border">
	 <tr class="topbg">
		 <td   align="center">网站基本配置</td>
	 </tr>
</table>
<br />
<form action="editt.php" method="post" name="form1" >
<input type="hidden" name="id"  value="1">
<div id="tits" class="subnav">
    <ul>
    	<?php
			if ($conf['co']['email']==true){
				echo '<li onclick="settab(\'tits\',\'con\',1)" class="cur" >基本设置</li>';
				echo '<li onclick="settab(\'tits\',\'con\',2)" class="">发件箱设置</li>';
			}
		?>
    </ul>
</div>
<div id="con_1">
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg">
    <td width="120" height="22" align="right">网站标题：</td>
    <td><textarea name="ym_tit" cols="80" rows="3"  ><?php echo $row['ym_tit']?></textarea><br />
	<font color="red">建议填写不超过80个字，不要使用“回车键”换行</font>
      </td>
  </tr>
  
  <?php
  if ($conf['co']['en']==true){
  ?>
  <tr class="tdbg">
    <td width="120" height="22" align="right">英文网站标题：</td>
    <td><textarea name="ym_tit_en" cols="80" rows="3"  ><?php echo $row['ym_tit_en']?></textarea><br />
	<font color="red">建议填写不超过80个字，不要使用“回车键”换行</font>
      </td>
  </tr>
  <?php
  }
  ?>
  
  <tr class="tdbg">
    <td width="120" height="22" align="right" >关 键 字：</td>
    <td ><textarea name="ym_key" cols="80" rows="3"   ><?php echo $row['ym_key']?></textarea><br />
	<font color="red">建议填写不超过100个字，不要使用“回车键”换行</font></td>
  </tr>
  
  <?php
  if ($conf['co']['en']==true){
  ?>
  <tr class="tdbg">
    <td width="120" height="22" align="right" >英文关键字：</td>
    <td ><textarea name="ym_key_en" cols="80" rows="3"   ><?php echo $row['ym_key_en']?></textarea><br />
	<font color="red">建议填写不超过100个字，不要使用“回车键”换行</font></td>
  </tr>
  <?php
  }
  ?>
  
  <tr class="tdbg">
    <td width="120" height="22" align="right" class="tdbg">网站描述：</td>
    <td><textarea name="ym_des" cols="80" rows="3"   ><?php echo $row['ym_des']?></textarea><br />
    <font color="red">建议填写不超过200个字，不要使用“回车键”换行</font></td>
  </tr>
  
  <?php
  if ($conf['co']['en']==true){
  ?>
  <tr class="tdbg">
    <td width="120" height="22" align="right" class="tdbg">英文网站描述：</td>
    <td><textarea name="ym_des_en" cols="80" rows="3"   ><?php echo $row['ym_des_en']?></textarea><br />
    <font color="red">建议填写不超过200个字，不要使用“回车键”换行</font></td>
  </tr>
  <?php
  }
  ?>
  
  <?php
  if ($conf['co']['ym_bot']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right">网站底部：</td>
    <td>
    <textarea id="ym_bot" name="ym_bot" style="width:670px;height:200px;display:none;"><?php echo $row['ym_bot']?></textarea>
    </td>
  </tr>
  
  <?php
  if ($conf['co']['en']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right">英文网站底部：</td>
    <td>
    <textarea id="ym_bot_en" name="ym_bot_en" style="width:670px;height:200px;display:none;"><?php echo $row['ym_bot_en']?></textarea>
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
			K.create('textarea[name="ym_bot"]',options);
			K.create('textarea[name="ym_bot_en"]',options);
        });
  </script>
  <?php
  }
  ?>
</table>
</div>
<div id="con_2" style="display:none;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg">
    <td width="120" height="22" align="right">发件箱：</td>
    <td><input name="s_email" type="text" maxlength="50" size="30" value="<?php echo $row['s_email']?>"/></td>
  </tr>
  <tr class="tdbg">
    <td width="120" height="22" align="right" >发件箱密码：</td>
    <td><input name="s_password" type="text" maxlength="50" size="30" value="<?php echo $row['s_password']?>"/></td>
  </tr>
  <tr class="tdbg">
    <td width="120" height="22" align="right" class="tdbg">发件服务器：</td>
    <td><input name="s_server" type="text" maxlength="50" size="30" value="<?php echo $row['s_server']?>"/><br />
	QQ邮箱：smtp.qq.com  &nbsp; 163邮箱：smtp.163.com  &nbsp; 网易企业邮箱：smtp.+贵公司域名
	</td>
  </tr>
  <?php
  if ($conf['co']['r_email']==true){
  ?>
  <tr class="tdbg">
    <td width="120" height="22" align="right" class="tdbg">收件箱：</td>
    <td><textarea name="r_email" cols="80" rows="3"><?php echo rehtml($row['r_email'])?></textarea><br />
	多个收件箱请用"|"隔开
    </td>
  </tr>
  <?php
  }
  ?>
</table>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value="保 存" class="btn"></td>
  </tr>
</table>

</form>
</body>
</html>
