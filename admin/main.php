<?php 
require('../include/common.inc.php');
chklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台主窗口</title>
<style type="text/css">
<!--
	body{
		font-size:12px;
		margin-left: 0px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
	}
	td{font-size:12px;}
	
	.khwz {
	color: #FF0000;
	font-weight: bold;
	font-family:"黑体";
	filter: shadow(color=999999,direction=150); 
	zoom:1; 
	padding:10px;
	font-size: 36px; 
	}
	.pysm{
	color: #003399;
	font-weight: bold;
	font-size: 26px;
	font-family:"隶书"
	}
-->
</style>
<script src="scripts/function.js"></script>
</head>

<body background="images/bg.gif" scroll="no">
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top"><img src="images/aa_rig1.gif" width="7" height="18"></td>
      <td height="31"><table border="0" cellspacing="0" cellpadding="0" height="31" width="100%" align="center">
        <tr>
          <td width="1%" height="31" valign="top" ><img src="images/i9_2.gif" width="14" height="31"> </td>
          <td width="99%" height="31" ><table width="100%">
            <tr>
              <td align="center" valign="bottom">
			  
			</td>
            </tr>
          </table> </td>
        </tr>
      </table></td>
      <td valign="top"><img src="images/aa_rig2.gif" width="7" height="18"></td>
    </tr>
    <tr>
      <td width="7">&nbsp;</td>
      <td valign="top"><br>
  
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td style="font-family:Arial, Helvetica, sans-serif"><strong><br>
    服务器类型：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo PHP_OS?>(IP:<?php echo $_SERVER['REMOTE_ADDR']?>)<br>
    <br>
    脚本解释引擎：<?php echo phpversion()?><br>
    <br>
    站点物理路径：<?php echo dirname(dirname(__FILE__))?><br>
    <br>
    本地操作IP：&nbsp;&nbsp;&nbsp;&nbsp;<?php echo getip()?><br>
    
</strong>
  <br>
  
</td></tr>
  </table>
  <table width="600"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="190"></td>
    </tr>
  </table>
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
   
  <font face="Arial, Helvetica, Sans Serif" size="3" color="#999999"><b>
    <span id="clock">
    
<SCRIPT LANGUAGE="JavaScript">

<!-- Begin
var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
function getthedate(){
var mydate=new Date()
var year=mydate.getYear()
if (year < 1000)
year+=1900
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10)
daym="0"+daym
var hours=mydate.getHours()
var minutes=mydate.getMinutes()
var seconds=mydate.getSeconds()
var dn="AM"
if (hours>=12)
dn="PM"
if (hours>12){
hours=hours-12
}
{
 d = new Date();
 Time24H = new Date();
 Time24H.setTime(d.getTime() + (d.getTimezoneOffset()*60000) + 3600000);
 InternetTime = Math.round((Time24H.getHours()*60+Time24H.getMinutes()) / 1.44);
 if (InternetTime < 10) InternetTime = '00'+InternetTime;
 else if (InternetTime < 100) InternetTime = '0'+InternetTime;
}
if (hours==0)
hours=12
if (minutes<=9)
minutes="0"+minutes
if (seconds<=9)
seconds="0"+seconds
//change font size here
var cdate=dayarray[day]+", "+montharray[month]+" "+daym+" "+year+" | "+hours+":"+minutes+":"+seconds+" "+dn+""
if (document.all)
document.all.clock.innerHTML=cdate
else if (document.getElementById)
document.getElementById("clock").innerHTML=cdate
else
document.write(cdate)
}
if (!document.all&&!document.getElementById)
getthedate()
function goforit(){
if (document.all||document.getElementById)
setInterval("getthedate()",1000)
}
window.onload=goforit
//  End -->
</script>
    
</span></b></font>
  </td>
    </tr>
    <tr>
      <td align="center" valign="bottom" style="line-height:30px;color:#cccccc"><!--技术支持 &copy;  广州合优网络科技有限公司&#8482;-->
  </td>
    </tr>
</table></td><td width="7" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
</table>
</body>
</html>
