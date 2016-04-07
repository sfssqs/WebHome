<?php
require('../../include/common.inc.php');
require('config.php');
checklogin();

//判断是否会显示状态
if ($conf['lm']['tuijian']||$conf['lm']['hot']||$conf['lm']['pass']){
	$zt=true;
}else{
	$zt=false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分类管理</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/jquery.js"></script>
<script src="../scripts/function.js"></script>
<script>
$(document).ready(function(){
	//如果鼠标移到class为msgtable的表格的tr上时，执行函数
	$(".listtable tr").mouseover(function(){  
	//给这行添加class值为over，并且当鼠标移出该行时执行函数
	$(this).addClass("over");}).mouseout(function(){ 
	//移除该行的class
	$(this).removeClass("over");}).click(function(){ 
		$(".listtable tr").removeClass("click");
		$(this).addClass("click");
	})
});
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">分类管理</td>
  </tr>
  <tr class="tdbg" <?php if ($conf['lm']['add_lm']==false){echo ' style="display:none;"';}?>>
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加分类</a></td>
  </tr>
</table>
<br />

<form id="form1" name="form1" action="make.php?ac=px" method="post" >
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border listtable">
  <tr class="title">
    <td width="40" align="center">排序</td>
    <td width="40" align="center">ID</td>
    <td>分类名称</td>
    <?php
    if ($zt==true){
	?>
    <td width="90" align="center">状态</td>
    <?php
    }
	?>
    <td width="120" align="center">管理操作</td>
  </tr>
  <?php
	//把所有分类放到$rss数组里
	$rss=$db->getrss('select * from `'.$conf['sy']['table_lm'].'` order by `px` desc,`id_lm` desc');
	deflm($rss,0,'• ');
   //无限级分类开始
	function deflm($rss,$fid,$i){
		global $conf,$zt;
		if ($i=='• '){
			$i='';
		}elseif ($i==''){
			$i=' &nbsp;&nbsp;|—';
		}else{
			$i=' &nbsp;│&nbsp;'.$i;
		}
		foreach($rss as $rsk){
			if($rsk['fid']==$fid){
				echo '<tr class="tdbg" >'."\n";
				echo'<td align="center"><input name="px['.$rsk["id_lm"].']" id="px['.$rsk["id_lm"].']" type="text" value="'.$rsk["px"].'" maxlength="11" class="num"></td>'."\n";
				echo'<td align="center">'.$rsk["id_lm"].'</td>'."\n";
				$img=($rsk['add_xia']=='yes')?'<img src="../images/tree_folder4.gif" />':'<img src="../images/tree_folder3.gif" />';
				$title_lm=($i=='')?'<b>'.$rsk["title_lm"].'</b>':$rsk['title_lm'];
				echo'<td>'.$i.$img.$title_lm.'</td>'."\n";
				$zt_t=($conf['lm']['tuijian']==true)?(($rsk['tuijian']==0)?'<a class="icon t" href="make.php?id='.$rsk["id_lm"].'&ac=tuijian1" title="点击成为推荐"></a>':'<a class="icon tn" href="make.php?id='.$rsk["id_lm"].'&ac=tuijian2" title="点击取消推荐"></a>'):'';
				$zt_h=($conf['lm']['hot']==true)?(($rsk['hot']==0)?'<a class="icon h" href="make.php?id='.$rsk["id_lm"].'&ac=hot1" title="点击成为热门"></a>':'<a class="icon hn" href="make.php?id='.$rsk["id_lm"].'&ac=hot2" title="点击取消热门"></a>'):'';
				$zt_b=($conf['lm']['pass']==true)?(($rsk['pass']==1)?'<a class="icon b" href="make.php?id='.$rsk["id_lm"].'&ac=pass2" title="点击成为屏蔽"></a>':'<a class="icon bn" href="make.php?id='.$rsk["id_lm"].'&ac=pass1" title="点击取消屏蔽"></a>'):'';
				echo($zt==true)?'<td><table align="center"><tr><td>'.$zt_t.$zt_h.$zt_b.'</td></tr></table></td>'."\n":'';
				$edit_a=($rsk['con_att']==3)?'<span class="hui">修改</span>':'<A href="edit.php?id='.$rsk["id_lm"].'">修改</A>';
				$del_a=($rsk['con_att']==2||$rsk['con_att']==3)?'<span class="hui"> | 删除</span>':' | <A href="make.php?id='.$rsk["id_lm"].'&ac=del"  onClick="return confirm(\'真的要删除该分类吗?\n\n该分类下的所有信息将被删除！\')" >删除</A>';
				$del_a=($conf['lm']['add_lm']==false)?'':$del_a;
				echo'<td align="center">'.$edit_a.$del_a.'</td>'."\n";
				echo'</tr>'."\n";
				deflm($rss,$rsk['id_lm'],$i);
			}
		}
	}
  ?> 
</table>
<p class="p">
<input name="" type="submit"  class="btn" value="排序"/>
</p>
</form>
</body>
</html>
