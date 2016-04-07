<?php
require('../../include/common.inc.php');
require('../job_lm/config.php');

checklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加<?php echo $conf['sy']['name'];?></title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
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
		alert('职位不能为空');
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
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">添加<?php echo $conf['sy']['name'];?></td>
  </tr>
  <tr class="tdbg">
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加<?php echo $conf['sy']['name'];?></a></td>
  </tr>
</table>
<br />
<FORM name="form1" method="post" action="addd.php" onSubmit="return check()">
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
    <select name="lm" id="lm">
      <option value="0" selected="selected">请选择分类</option>
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
					if($rs['add_xx']=='yes'){
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
    </td>
  </tr>
  <tr class="tdbg">
    <td width="120" align="right"><?php echo $conf['sy']['name'];?>职位：</td>
    <td><INPUT name="title" type="text" id="title" size="35" maxlength="80"> <span class="red">*</span></td>
  </tr>
  <?php
  if ($conf['co']['num']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right" ><?php echo $conf['sy']['name'];?>人数：</td>
    <td><INPUT name="num" type="text" id="num" size="35"  maxlength="50"></td>
  </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['co']['address']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right" >工作地点：</td>
    <td><input name="address" type="text" id="address" size="35"  maxlength="50" /></td>
  </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['co']['stime']==true){
  ?>
    <tr class="tdbg">
      <td width="120" align="right">发布日期：</td>
        <td ><input name="stime" type="text" id="stime" size="35" value="<?php echo date('Y-m-d H:i:s')?>" maxlength="50"></td>          
    </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['co']['etime']==true){
  ?>
    <tr class="tdbg">
      <td width="120" align="right">结束日期：</td>
        <td ><input name="etime" type="text" id="etime" size="35" value="<?php echo date('Y-m-d H:i:s',(time()+30*24*60*60))?>" maxlength="50" /></td>          
    </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['co']['f_body']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right">职位描述：</td>
    <td>
    <textarea id="f_body" name="f_body" style="width:670px;height:200px;display:none;"></textarea>
    </td>
  </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['co']['z_body']==true){
  ?>
  <tr class="tdbg">
    <td width="120" align="right">任职要求：</td>
    <td>
    <textarea id="z_body" name="z_body" style="width:670px;height:200px;display:none;"></textarea>
    </td>
  </tr>
  <?php
  }
  ?>
  <?php
  if ($conf['co']['f_body']==true||$conf['co']['z_body']==true){
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
		  <?php
		  if ($conf['co']['f_body']==true){
		  ?>
			K.create('textarea[name="f_body"]',options);
		  <?php
		  }
		  ?>	
		  <?php
		  if ($conf['co']['z_body']==true){
		  ?>
			K.create('textarea[name="z_body"]',options);
		  <?php
		  }
		  ?>
        });
  </script>
  <?php
  }
  ?>
  <tr class="tdbg">
    <td width="120" align="right">显示顺序：</td>
    <td><INPUT name="px" type="text" id="px" value="100" size="5" maxlength="11" >
     <span class="red">* (从大到小排序)</span></td>
  </tr>
</table>
</div>
<div id="con_2" style="display:none;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border_tab">
  <tr class="tdbg">
    <td width="120" height="22" align="right">页面标题：</td>
    <td>
    <textarea name="ym_tit" cols="80" rows="3"></textarea><br />
	建议填写不超过80个字，不要使用“回车键”换行
    </td>
  </tr>
  
  <tr class="tdbg">
    <td width="120" height="22" align="right" >页面关键字：</td>
    <td >
    <textarea name="ym_key" cols="80" rows="3"></textarea><br />
	建议填写不超过100个字，不要使用“回车键”换行
    </td>
  </tr>
  
  <tr class="tdbg">
    <td width="120" height="22" align="right" class="tdbg">页面描述：</td>
    <td><textarea name="ym_des" cols="80" rows="3"></textarea><br />
    建议填写不超过200个字，不要使用“回车键”换行
    </td>
  </tr>
</table>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value="提 交" class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value="取 消" onClick="location.href='default.php';" class="btn"></td>
  </tr>
</table>
</FORM>
</body>
</html>
