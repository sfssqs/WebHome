<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$zt_val=isset($_GET['zt_val'])?$_GET['zt_val']:'';
$keyword=isset($_GET['keyword'])?html($_GET['keyword']):'';

$sq='';

//如果有状态
if($zt_val!=''){
	if ($zt_val=='chakan1'){
		$sq.=' and chakan=1';
	}elseif($zt_val=='chakan2'){
		$sq.=' and chakan=0';
	}elseif($zt_val=='chuli1'){
		$sq.=' and chuli=1';
	}elseif($zt_val=='chuli2'){
		$sq.=' and chuli=0';
	}
}

//如果有关键字
if ($keyword!=''){
	$sq.=' and (title like "%'.$keyword.'%" or rename like "%'.$keyword.'%" or phone like "%'.$keyword.'%" or qq like "%'.$keyword.'%" or compname like "%'.$keyword.'%")';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理首页</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">管理首页</td>
  </tr>
</table>
<br />
<form id="sform" name="sform" method="get" action="default.php">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="tdbg3">
    <td width="70" align="right"><strong><?php echo $conf['sy']['name']?>检索：</strong></td>
    <td>
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
<td>
                <select name="zt_val" id="zt_val" onchange="location='default.php?zt_val='+this.value+'&keyword=<?php echo $keyword?>'">
                    <option value="">所有状态</option>

                    <option value="chakan1">已看</option>
                    <option value="chakan2">未看</option>
                    <option value="chuli1">已处</option>
                    <option value="chuli2">未处</option>

                </select>&nbsp;
				 <script language="javascript">
					gt("zt_val").value="<?php echo $zt_val?>";
                 </script>
            </td>
            <td><input name="keyword" type="text" id="keyword" size="15" maxlength="50"  value="<?php echo $keyword?>" />&nbsp;</td>
            <td><input type="submit" name="button" id="button" value="检索" class="btn "/></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</form>
<br />
<form name="form1" id="form1" action="make.php" method="post" >
<input name="ac" id="ac" type="hidden" value="del"/>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
    <td width="40" align="center">选中</td>
    <td width="40" align="center">ID</td>
    <?php
    if ($conf['co']['title']==true){
		echo '<td>标题</td>';
	}
	?>
    <?php
    if ($conf['co']['rename']==true){
		echo '<td>姓名</td>';
	}
	?>
    <td width="160" align="center">时间</td>
    <td width="120" align="center">状态</td>
    <td width="200" align="center" ><strong>管理操作</strong></td>
  </tr>
<?php
//开始读留言
$sql='select `id`,`title`,`rename`,`chakan`,`wtime`,`chuli` from `'.$conf['sy']['table_co'].'`  where 1=1 '.$sq.' order by `id` desc';
$p=new page(array('pagesize'=>25));
$rss=$p->getrss($db,$sql);
foreach($rss as $row){
$zt='';
$zt=($row['chakan']==1)?'<span class="hui">已看 </span>&nbsp;':'<span class="blue">未看 </span>&nbsp;';
$zt.=($row['chuli']==1)?'<span class="hui">已处 </span>&nbsp;':'<span class="blue">未处 </span>&nbsp;';
?>
    <tr class="tdbg">
        <td align="center"><input name="id[]" type="checkbox" id="id[]" value="<?php echo $row['id']?>"/></td>
        <td align="center"><?php echo $row['id']?></td>
		<?php
        if ($conf['co']['title']==true){
            echo '<td>'.$row['title'].'</td>';
        }
        ?>
        <?php
        if ($conf['co']['rename']==true){
            echo '<td>'.$row['rename'].'</td>';
        }
        ?>
        <td  align="center"><?php echo date('Y-m-d H:i:s',$row['wtime'])?></td>
        <td align="center"><?php echo $zt?></td>
        <td align="center">
        <a href="show.php?id=<?php echo $row['id']?>" >查看</a> | 
        <a href="make.php?id=<?php echo $row['id']?>&ac=del"  onClick="return confirm('确定要删除该数据吗?')">删除</a>
        </td>
    </tr>
<?php
}
?>
</table>
<p class="p">
<a href="javascript:CheckAll('form1');">全选</a>/<a href="javascript:CheckOthers('form1');">反选</a>&nbsp;<input name="" type="button"  class="btn" value="删除选中" onclick="act('form1','del');"/>
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
