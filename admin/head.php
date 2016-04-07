<?php 
require('../include/common.inc.php');
chklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台头部</title>
<style>
html{ margin:0px;}
body{font-size:12px}
td{font-size:12px;font-family:Arial, Helvetica, sans-serif}
.style2 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #ffffff}
.px12 {COLOR: #ffffff}
A:link {FONT-SIZE: 9pt; COLOR: #ffffff; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none}
A:visited {FONT-SIZE: 9pt; COLOR: #ffffff; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none}
A:active {FONT-SIZE: 9pt; COLOR: #ffffff; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: none}
A:hover {FONT-SIZE: 9pt; COLOR: #ffffff; FONT-FAMILY: Arial, Helvetica, sans-serif; TEXT-DECORATION: underline}
</style>
<SCRIPT language=JavaScript type=text/JavaScript>
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function log_out()
{
	ht = parent.document.getElementsByTagName("html");
	ht[0].style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)";
		if (confirm('确定要退出网站管理系统吗？'))
	{
		return true;
	}
	else
	{
		ht[0].style.filter = "";
		return false;
	}
}
//-->
</script>
<script src="scripts/function.js"></script>
</head>

<body style="margin:0px;">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD width=189 height="69" rowSpan=2 valign="bottom" background="images/aa_1.gif"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" style="color:#ffffff">今日：<?php echo date('Y').'年'.date('m').'月'.date('d').'日 ';?></td>
      </tr>
      <tr>
        <td height=4></td>
      </tr>
    </table></TD>
    <TD vAlign=top background=images/aa_3.gif height=39>
		<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
		<TBODY>
		<TR>
		  <TD vAlign=bottom align=right height=39 style="background:url(images/aa_2.gif) no-repeat left top; color:#FFFFFF;">
			<script language="javaScript">
				now = new Date(),hour = now.getHours()
				if (hour<06) {document.write("凌晨好！")}
				else if (hour<08) {document.write("早上好！")}
				else if (hour<12) {document.write("上午好！")}
				else if (hour<14) {document.write("中午好！")}
				else if (hour<17) {document.write("下午好！")}
				else if (hour<22) {document.write("晚上好！")}
				else {document.write("夜里好！")}
			</script><?php echo $_SESSION['pyadmin']?>&nbsp;&nbsp;		  </TD>
		</TR>
		</TBODY>
		</TABLE>	 </TD>
  </TR>
  <TR>
    <TD vAlign=top background=images/aa_3_2.gif><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
			<TBODY>
			<TR>
			  <TD width=78><A class=nav  onmouseover="MM_swapImage('Image19','','images/aa_top_b1-.gif',1)"  onmouseout=MM_swapImgRestore()  href="main.php" target="mainFrame"><IMG height=30 src="images/aa_top_b1.gif" width=78 border=0 name=Image19></A></TD>
			  <TD width=79><A  href="../" target="_blank" class=nav onmouseover="MM_swapImage('Image23','','images/aa_top_b5-.gif',1)"  onmouseout=MM_swapImgRestore() ><IMG  height=30 src="images/aa_top_b5.gif" width=79 border=0 name=Image23></A></TD>
			  
			  <TD width=79><A  href="admin_reg.php" target="mainFrame" class=nav  onmouseover="MM_swapImage('Image25','','images/ch2.gif',1)" onmouseout=MM_swapImgRestore() ><IMG height=30 src="images/ch1.gif" border=0 name=Image25></A></TD>
			  <TD width=79><A  href="admin_logout.php" target="_top" class=nav onmouseover="MM_swapImage('Image26','','images/lg2.gif',1)" onmouseout=MM_swapImgRestore() ><IMG height=30 src="images/lg1.gif" border=0 name=Image26></A></TD>
			  <TD><A  onmouseover="MM_swapImage('Image27','','images/out2.gif',1)" onmouseout=MM_swapImgRestore() href="admin_logout.php" target="_parent" onclick="return log_out()"><IMG height=30 src="images/out1.gif" border=0 name=Image27></A></TD>
			 </TR>
			 </TBODY>
			</TABLE>	 </TD>
   </TR>
  </TBODY>
  </TABLE>
</body>
</html>
