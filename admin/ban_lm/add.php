<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加分类</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
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
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">添加分类</td>
  </tr>
  <tr class="tdbg" <?php if ($conf['lm']['add_lm']==false){echo ' style="display:none;"';}?>>
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加分类</a></td>
  </tr>
</table>

<br />
<FORM name="form1" method="post" action="addd.php" onSubmit="return check()">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
      <td colspan="2"></td>
  </tr>
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
				if($rs['fid']==$fid&&$rs['add_xia']=='yes'){
					echo'<option value="'.$rs["id_lm"].'">'.$i.$rs["title_lm"].'</option>'."\n";
					addlm($rss,$rs['id_lm'],$i);
				}
			}
		}
		?>
    </select>
    </td>
  </tr>
  <tr class="tdbg">
    <td width="120" align="right">分类名称：</td>
    <td><INPUT name="title_lm" type="text" id="title_lm" size="30" maxlength="150"> <span class="red">*</span></td>
  </tr>
  <tr class="tdbg" <?php if ($conf['lm']['con_att']==false){echo 'style="display:none;"';}?>>
    <td width="120" align="right">分类属性：</td>
    <td><table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="23">
              <input name="add_xx" type="radio" class="radio" id="add_xx" value="yes" checked>
              可以添加信息
			  <input name="add_xx" type="radio" class="radio" id="add_xx2" value="no">			
			  不可以添加信息
            </td>
            </tr>
            <tr>
              <td height="23">
              <input name="add_xia" type="radio" class="radio" id="add_xia" value="yes" checked />
                可以添加下级分类
                <input name="add_xia" type="radio" class="radio" id="add_xia2" value="no" />
                不可以添加下级分类
              </td>
            </tr>
            <tr>
              <td height="23">
                <input name="con_att" type="radio" class="radio" id="con_att" value="1" checked="checked" />
                完全控制
                <input name="con_att" type="radio" class="radio" id="con_att2" value="2" />
                只能读取、修改(不能删除)
                <input name="con_att" type="radio" class="radio" id="con_att3" value="3" />
                只能读取(不能修改，不能删除)
              </td>
            </tr>
      </table></td>
  </tr>
    <tr class="tdbg">
    <td width="120" align="right">显示顺序：</td>
    <td><INPUT name="px" type="text" id="px" value="100" size="5" maxlength="11" >
     <span class="red">* (从大到小排序)</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="2" style="margin-top:3px;">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input type="submit" name="Submit" value=" 提 交 " class="btn"> &nbsp; &nbsp; &nbsp;<input name="Cancel" type="button" id="Cancel" value=" 取 消 " onClick="location.href='default.php';" class="btn"></td>
  </tr>
</table>
</FORM>
</body>
</html>
