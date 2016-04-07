<?php
require('../../include/common.inc.php');
require('config.php');

checklogin();

$keyword=isset($_GET['keyword'])?html($_GET['keyword']):'';
$s_wtime=isset($_GET['s_wtime'])?html($_GET['s_wtime']):'';
$e_wtime=isset($_GET['e_wtime'])?html($_GET['e_wtime']):'';
$s_etime=isset($_GET['s_etime'])?html($_GET['s_etime']):'';
$e_etime=isset($_GET['e_etime'])?html($_GET['e_etime']):'';
$pass=isset($_GET['pass'])?html($_GET['pass']):'';

if ($s_wtime!=''){
	if(!checkd($s_wtime)){
		msg('开始注册日期错误');
	}
}
if ($e_wtime!=''){
	if(!checkd($e_wtime)){
		msg('结束注册日期错误');
	}
}
if ($s_etime!=''){
	if(!checkd($s_etime)){
		msg('开始登录日期错误');
	}
}
if ($e_etime!=''){
	if(!checkd($e_etime)){
		msg('结束登录日期错误');
	}
}

$sq='';

//如果有关键字
if ($keyword!=''){
	$sq.=' and (`username` like "%'.$keyword.'%" or `rename` like "%'.$keyword.'%" or `compname` like "%'.$keyword.'%" or `email` like "%'.$keyword.'%" or `phone` like "%'.$keyword.'%")';
}


//注册时间
if($s_wtime!=''&&$e_wtime!=''){
	$sq.=' and (wtime>='.strtotime($s_wtime).' and wtime<='.(strtotime($e_wtime)+60*60*24).')';
}elseif($s_wtime!=''){
	$sq.=' and (wtime>='.strtotime($s_wtime).' )';
}elseif($e_wtime!=''){
	$sq.=' and (wtime<='.(strtotime($e_wtime)+60*60*24).' )';
}

//登录时间
if($s_etime!=''&&$e_etime!=''){
	$sq.=' and (etime>='.strtotime($s_etime).' and etime<='.(strtotime($e_etime)+60*60*24).')';
}elseif($s_etime!=''){
	$sq.=' and (etime>='.strtotime($s_etime).' )';
}elseif($e_etime!=''){
	$sq.=' and (etime<='.(strtotime($e_etime)+60*60*24).' )';
}

//状态
if ($pass!=''){
	$sq.=' and pass = '.$pass.' ';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理首页</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
<script src="../scripts/cleander.js"></script>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td colspan="2">管理首页</td>
  </tr>
  <tr class="tdbg">
    <td width="70" height="26" align="right"><strong>管理导航：</strong></td>
    <td><a href="default.php">管理首页</a>&nbsp;|&nbsp;<a href="add.php">添加<?php echo $conf['sy']['name']?></a></td>
  </tr>
</table>
<br />
<form id="sform" name="sform" method="get" action="default.php">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="tdbg3">
    <td width="70" align="right"><strong><?php echo $conf['sy']['name']?>检索：</strong></td>
    <td>
        <table border="0" cellspacing="2" cellpadding="0" style="float:left;">
          <tr>
            <td align="right">关&nbsp; 键&nbsp; 字：</td>
            <td><input name="keyword" type="text" id="keyword" size="20" maxlength="50" value="<?php echo $keyword?>"/></td>
          </tr>
          <tr>
            <td align="right">注册日期：</td>
            <td><input name="s_wtime" type="text" id="s_wtime" size="10" maxlength="50"  onFocus="HS_setDate(this)" value="<?php echo $s_wtime?>" />
            &nbsp;到&nbsp;<input name="e_wtime" type="text" id="e_wtime" size="10" maxlength="50"  onFocus="HS_setDate(this)" value="<?php echo $e_wtime?>"/></td>
          </tr>
          <tr>
            <td align="right">登录日期：</td>
            <td><input name="s_etime" type="text" id="s_etime" size="10" maxlength="50"  onFocus="HS_setDate(this)" value="<?php echo $s_etime?>" />
            &nbsp;到&nbsp;<input name="e_etime" type="text" id="e_etime" size="10" maxlength="50"  onFocus="HS_setDate(this)" value="<?php echo $e_etime?>"/></td>
          </tr>
            <tr>
                <td align="right" >状态：</td>
                <td ><select name="pass" id="pass">
              <option value="">请选择</option>
              <option value="1">未审核</option>
              <option value="2">未通过</option>
              <option value="3">已通过</option>
              <option value="4">已屏蔽</option>
            </select><?php
            if ($pass!=''){
				echo'<script>document.getElementById("pass").value="'.$pass.'"</script>';	
			}
			?></td>
            </tr>
            
          <tr>
            <td align="right"></td>
            <td><input name="submitt" type="submit" class="btn" id="submitt" value=" 搜 索 " /> <input onclick="location='default.php'" name="button" type="button" class="btn" id="submitt" value=" 重 置 " /></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</form>
<br />
<table width="100%" border="0" cellspacing="1" cellpadding="2" class="border">
  <tr>
    <td class="tdbgo">
    <?php
    $sql='select count(*) as acount,sum(if(pass=1,1,0)) as pass1,sum(if(pass=2,1,0)) as pass2,sum(if(pass=3,1,0)) as pass3,sum(if(pass=4,1,0)) as pass4 from `'.$conf['sy']['table_co'].'` where 1=1 '.$sq;
    $rs=$db->getrs($sql);
    if ($rs){
	?>
		总个数：<span style="color:#ff0000;font-weight:bold;"><?php echo $rs['acount']?></span><br />
        未审核：<span style="color:blue;font-weight:bold;"><?php echo $rs['pass1']?></span>
        &nbsp; &nbsp; 未通过：<span style="color:#999;font-weight:bold;"><?php echo $rs['pass2']?></span>
        &nbsp; &nbsp; 已通过：<span style="color:green;font-weight:bold;"><?php echo $rs['pass3']?></span>
        &nbsp; &nbsp; 已屏蔽：<span style="color:red;font-weight:bold;"><?php echo $rs['pass4']?></span>
	<?php
    }
    ?>
    </td>
  </tr>
</table><br />

<form name="form1" id="form1" action="make.php" method="post" >
<input name="ac" id="ac" type="hidden" value="px"/>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
    <td width="40" align="center">选中</td>
    <td>用户名</td>
    <td align="left">姓名</td>
    <td align="center">注册时间</td>
    <td align="center">登录时间</td>
    <td align="center">登录次数</td>
    <td width="70" align="center">状态</td>
    <td width="200" align="center">管理操作</td>
  </tr>
<?php
$sql='select `id`,`username`,`rename`,`wtime`,`etime`,`login_num`,`pass` from `'.$conf['sy']['table_co'].'` where 1=1 '.$sq.' order by `id` desc';
$p=new page(array('pagesize'=>25));
$rss=$p->getrss($db,$sql);
foreach($rss as $row){
?>
    <tr class="tdbg">
        <td align="center"><input name="id[]" type="checkbox" id="id[]" value="<?php echo $row['id']?>"/></td>
        <td align="left"><?php echo $row['username']?></td>
        <td align="left"><?php echo $row['rename']?></td>
        <td align="center"><?php echo date('Y-m-d H:i:s',$row['wtime'])?></td>
        <td align="center"><?php echo ($row['etime']>0)?date('Y-m-d H:i:s',$row['etime']):'';?></td>
        <td align="center"><?php echo $row['login_num']?></td>
        <td align="center"><?php echo person_z($row['pass'])?></td>
        <td align="center">
        <a href="edit.php?id=<?php echo $row['id']?>">修改</a> |  <a href="make.php?id=<?php echo $row['id']?>&ac=del"  onClick="return confirm('确定要删除该数据吗?')">删除</a>        </td>
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
    	<?php $p->getpagemenu()?></td>
  </tr>
</table>
</form>
</body>
</html>
