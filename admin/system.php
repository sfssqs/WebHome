<?php 
require('../include/common.inc.php');
chklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站后台管理</title>
<script src="scripts/function.js"></script>
</head>

<FRAMESET border=0 frameSpacing=0 rows=*,33 frameBorder=NO >
<FRAMESET border=0 frameSpacing=0 rows=69,* frameBorder=NO cols=*>
<FRAME name=topFrame src="head.php" noResize scrolling=no >
<FRAMESET border=0 name=downfr frameSpacing=0 rows=* frameBorder=no cols=198,*>
<FRAME name=leftFrame src="left.php" scrolling=yes >
<FRAME name=mainFrame src="main.php" scrolling=yes>
<frame src="UntitledFrame-3"></FRAMESET>
</FRAMESET>
<FRAME name=bottomFrame src="bottom.php" noResize scrolling=no>
</FRAMESET>
<noframes>
</noframes>
</html>
