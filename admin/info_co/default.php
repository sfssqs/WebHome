<?php
require('../../include/common.inc.php');
require('../info_lm/config.php');

checklogin();

$lm=isset($_GET['lm'])?$_GET['lm']:'';
$zt_val=isset($_GET['zt_val'])?$_GET['zt_val']:'';
$keyword=isset($_GET['keyword'])?html($_GET['keyword']):'';

if ($lm!=''&&!checknum($lm)){
	msg('参数错误');
}

$sq='';
//如果有分类
if($lm!=''){
	$sq.=' and locate(",'.$lm.',",a.list_lm)>0';
}
//如果有状态
if($zt_val!=''){
	if ($zt_val=='ding1'){
		$sq.=' and a.ding=1';
	}elseif($zt_val=='ding2'){
		$sq.=' and a.ding=0';
	}elseif($zt_val=='tuijian1'){
		$sq.=' and a.tuijian=1';
	}elseif($zt_val=='tuijian2'){
		$sq.=' and a.tuijian=0';
	}elseif($zt_val=='hot1'){
		$sq.=' and a.hot=1';
	}elseif($zt_val=='hot2'){
		$sq.=' and a.hot=0';
	}elseif($zt_val=='pass1'){
		$sq.=' and a.pass=1';
	}elseif($zt_val=='pass2'){
		$sq.=' and a.pass=0';
	}
}
//如果有关键字
if ($keyword!=''){
	$sq.=' and a.title like "%'.$keyword.'%"';
}

//判断是否会显示状态
if ($conf['co']['ding']||$conf['co']['tuijian']||$conf['co']['hot']||$conf['co']['pass']){
	$zt=true;
}else{
	$zt=false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理首页</title>
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
<DIV id=popImageLayer style="VISIBILITY: hidden; WIDTH: 267px; CURSOR: hand; POSITION: absolute; HEIGHT: 260px; background-image:url(../images/bbg.gif); z-index: 100;" align=center  name="popImageLayer"  ></DIV>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">管理首页</td>
  </tr>
  <tr class="tdbg" <?php if ($conf['co']['add_xx']==false){echo ' style="display:none;"';}?>>
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加<?php echo $conf['sy']['name'];?></a></td>
  </tr>
</table>
<br />
<form id="sform" name="sform" method="get" action="default.php">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="tdbg3">
    <td width="70" align="right"><strong>分类检索：</strong></td>
    <td>
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td <?php if ($conf['sy']['need_lm']==false){echo ' style="display:none;"';}?>>
                <select name="lm" id="lm" onchange="location='default.php?lm='+this.value+'&zt_val=<?php echo $zt_val?>&keyword=<?php echo $keyword?>'">
                	<option value="" selected>所有分类</option>
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
                </select>&nbsp;
				 <script language="javascript">
					gt("lm").value="<?php echo $lm?>";
                 </script>
            </td>
            <?php 
			if ($zt==true){
			?>
            <td>
                <select name="zt_val" id="zt_val" onchange="location='default.php?zt_val='+this.value+'&lm=<?php echo $lm?>&keyword=<?php echo $keyword?>'">
                    <option value="">所有状态</option>
                    <?php
                    if ($conf['co']['ding']==true){
					?>
                    <option value="ding1">已置顶</option>
                    <option value="ding2">未置顶</option>
                    <?php
                    }
					?>
                    <?php
                    if ($conf['co']['tuijian']==true){
					?>
                    <option value="tuijian1">已推荐</option>
                    <option value="tuijian2">未推荐</option>
                    <?php
                    }
					?>
                    <?php
                    if ($conf['co']['hot']==true){
					?>
                    <option value="hot1">已热门</option>
                    <option value="hot2">未热门</option>
                    <?php
                    }
					?>
                    <?php
                    if ($conf['co']['pass']==true){
					?>
                    <option value="pass2">已屏蔽</option>
                    <option value="pass1">未屏蔽</option>
                    <?php
                    }
					?>
                </select>&nbsp;
				 <script language="javascript">
					gt("zt_val").value="<?php echo $zt_val?>";
                 </script>
            </td>
            <?php 
			}
			?>
            <td><input name="keyword" type="text" id="keyword" size="15" maxlength="50"  value="<?php echo $keyword?>" />&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="检索" class="btn "/></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</form>
<br />

<form id="form1" name="form1" action="make.php" method="post" >
<input name="ac" id="ac" type="hidden" value="px"/>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border listtable">
  <tr class="title">
    <td width="48" align="center">选中</td>
    <td width="40" align="center">排序</td>
    <td width="40" align="center">ID</td>
    <td >标题</td>
    <td width="77"  align="center">点击量</td>
    <td width="154"  align="center">发布日期</td>
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
$sql='select a.`id`,a.`lm`,a.`title`,a.`color_font`,a.`img_sl`,a.`ding`,a.`tuijian`,a.`hot`,a.`pass`,a.`read_num`,a.`px`,a.`wtime`,b.`title_lm`,b.`add_xx` from `'.$conf['sy']['table_co'].'` a left join `'.$conf['sy']['table_lm'].'` b on a.`lm`=b.`id_lm` where 1=1 '.$sq.' order by a.ding desc,a.`px` desc,a.`id` desc';
$p=new page(array('pagesize'=>25));
$rss=$p->getrss($db,$sql);
foreach($rss as $row){
?>
    <tr class="tdbg">
        <td align="center"><input name="id[]" type="checkbox" id="id[]" value="<?php echo $row['id']?>" <?php echo ($row['add_xx']=='no')?' disabled="disabled"':'';?> /></td>
        <td align="center"><input name="px[<?php echo $row['id']?>]" type="text" id="px[<?php echo $row['id']?>]" value="<?php echo $row['px']?>" class="num"/></td>
        <td align="center"><?php echo $row['id']?></td>
        <td>
		<?php 
		echo ($conf['sy']['need_lm']==true)?'<b>[</b>'.$row['title_lm'].'<b>]</b>':'';
		echo '<a href="edit.php?id='.$row['id'].'" '.(($row['color_font']!='')?'style="color:'.$row["color_font"].'"':'').' >'.$row['title'].'</a>'.(($row['img_sl']!='')?'<a href="../../'.$row['img_sl'].'"  target=_blank><img src="../images/img.gif" border="0" onmouseover="popImage(this,\'../../'.$row['img_sl'].'\');" onmouseout="hideLayer();"/></a>':'');
		?>
        </td>
        <td align="center"><?php echo $row['read_num']?></td>
        <td align="center"><?php echo date('Y-m-d H:i:s',$row['wtime'])?></td>
        <?php
		$zt_d=($conf['co']['ding']==true)?(($row['ding']==0)?'<a class="icon d" href="make.php?id='.$row["id"].'&ac=ding1" title="点击成为置顶"></a>':'<a class="icon dn" href="make.php?id='.$row["id"].'&ac=ding2" title="点击取消置顶"></a>'):'';
		$zt_t=($conf['co']['tuijian']==true)?(($row['tuijian']==0)?'<a class="icon t" href="make.php?id='.$row["id"].'&ac=tuijian1" title="点击成为推荐"></a>':'<a class="icon tn" href="make.php?id='.$row["id"].'&ac=tuijian2" title="点击取消推荐"></a>'):'';
		$zt_h=($conf['co']['hot']==true)?(($row['hot']==0)?'<a class="icon h" href="make.php?id='.$row["id"].'&ac=hot1" title="点击成为热门"></a>':'<a class="icon hn" href="make.php?id='.$row["id"].'&ac=hot2" title="点击取消热门"></a>'):'';
		$zt_b=($conf['co']['pass']==true)?(($row['pass']==1)?'<a class="icon b" href="make.php?id='.$row["id"].'&ac=pass2" title="点击成为屏蔽"></a>':'<a class="icon bn" href="make.php?id='.$row["id"].'&ac=pass1" title="点击取消屏蔽"></a>'):'';
		?>
        <?php
        if($zt==true){
		?>
        <td><table align="center"><tr><td><?php echo $zt_d.$zt_t.$zt_h.$zt_b;?></td></tr></table></td>
        <?php
        }
		?>
        <td align="center">
        <a href="edit.php?id=<?php echo $row['id']?>">修改</a>
		<?php 
		$del_a=($row['add_xx']=='no')?'<span class="hui"> | 删除</span>':' | <a href="make.php?id='.$row['id'].'&ac=del"  onClick="return confirm(\'确定要删除该数据吗?\')" >删除</a>';
		$del_a=($conf['co']['add_xx']==false)?'':$del_a;
		echo $del_a;
		?>
        </td>
    </tr>
<?php
}
?>
</table>
<p class="p">
<a href="javascript:CheckAll('form1');">全选</a>/<a href="javascript:CheckOthers('form1');">反选</a>&nbsp;<input name="" type="submit"  class="btn" value="排序" /><?php if ($conf['co']['add_xx']==false){echo '';}else{?>&nbsp;<input name="" type="button"  class="btn" value="删除选中" onclick="act('form1','del');"/><?php }?>
</p>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="tdbg3">
    <td align="center">
	<?php
	if ($p->counter>0){
        $p->getpagehou();
	}
    ?>
    </td>
  </tr>
</table>
</form>
</body>
</html>
