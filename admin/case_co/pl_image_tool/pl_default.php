<?php
require('../../../include/common.inc.php');
require('pl_con.php');
require('upcon.php');
checklogin();
//获取哪条信息id需要多图，添加信息时是没有id系统自动生成一个临时id用session来保存，等信息添加后，再用信息的id来替换session保存的临时id
$pl_id=isset($_GET['pl_id'])?$_GET['pl_id']:'';
if ($pl_id!=''&&!checknum($pl_id)){
	msg('参数错误');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多图上传</title>
<link href="../../css/admin_style.css" rel="stylesheet" />
<style>
html{overflow-x:hidden;}
body{margin:0px; padding:0px;overflow-x:hidden;}

.filelist{ width:600px;}
.filelist li{width:80px;float:left; margin:3px 6px 0 6px; padding:0px; list-style:none;position:relative; display:inline;}
.filelist b{ display:block;height:5px; overflow:hidden;}
.filelist .del_btn{ width:8px; height:8px; overflow:hidden;background:url(js/del.png);position:absolute; top:8px; right:1px; cursor:pointer; }
.filelist p{ margin:2px 0 0 0; padding:1px; border:1px solid #ccc; background-color:#fff; display:block;}
.filelist p img{ width:76px; height:76px;}
.inputclass { width:76px; height:15px; line-height:15px; margin-top:1px; padding:1px;}
</style>
<script type="text/javascript" src="js/plupload.full.min.js"></script>
<script>
function submit_pl(act){
	var formu=document.getElementById("formu");
	if (act=='edit_pl'){
		formu.action='pl_make.php?act=edit_pl&pl_id=<?php echo $pl_id?>';
		formu.submit();
	}else if(act=='del_pl'){
		formu.action='pl_make.php?act=del_pl&pl_id=<?php echo $pl_id?>';
		formu.submit();
	}
}
</script>
</head>

<body>
<FORM name="formp" id="formp" method="post" action="pl_addd.php">
<table border="0" cellpadding="0" cellspacing="0"  >
  <tr>
    <td>
    <!--显示报错-->
    <span id="errlist" style="color:#FF0000;"></span>
    <!--浏览按钮-->
    <div id="container" style="margin:8px 0 0 6px;"><input type="hidden" name="pl_id" value="<?php echo $pl_id;?>" /><input id="pickfiles" type="button" name="Submit1" value="选 择 图 片" class="btn" style="_padding:0px;"> <input id="clearfiles" type="button" name="Submit2" value="删 除 选 择" class="btn" style="_padding:0px;" > <input id="uploadfiles" type="button" name="Submit2" value="上传" class="btn" > <span class="red"><?php echo $s_txt;?></span></div>
    <!--总的进度条-->
    <div id="up_zong" style="width:200px; border:1px solid #ccc; height:10px; display:none;"><div id="up_pro" style="background-color:#0000FF;height:10px;"></div></div>
    <!--文件阅览列表-->
    <span id="filelist" class="filelist"></span>
    </td>
  </tr>
</table>
</FORM>
<?php
//已经上传的数量
$ynum=0;
//把图片列出来
if (($pl_id!=''&&checknum($pl_id))||(isset($_SESSION[$pl_sesname])&&$_SESSION[$pl_sesname]!=''&&checknum($_SESSION[$pl_sesname]))){
	if ($pl_id!=''){
		$sql='select * from '.$pl_table.' where sy_id='.$pl_sy_id.' and pl_id='.$pl_id.' order by px asc,id asc';
	}else{
		$sql='select * from '.$pl_table.' where sy_id='.$pl_sy_id.' and pl_id='.$_SESSION[$pl_sesname].' order by px asc,id asc';
	}
	$row=$db->getrss($sql);
	if ($row){
?>
<FORM name="formu" id="formu" method="post" action="">
<table border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
  <tr>
    <?php
		$a=1;
		foreach($row as $rs){
	?>
    <td width="92" align="center" style="padding-bottom:6px;">
    <table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="border:1px solid #e4e4e4" width="80" height="80" align="center" valign="middle"><img src="../../../<?php echo $rs['img_sl']?>" border="0" width="78" height="78" /></td>
      </tr>
    <tr <?php if ($conf['pl']['title']==false){echo ' style="display:none;"';}?>>
        <td align="center" height="23"><input name="title[<?php echo $rs['id']?>]" type="text" class="inputclass" value="<?php echo $rs['title']?>"></td>
    </tr>
    <tr <?php if ($conf['pl']['px']==false){echo ' style="display:none;"';}?>>
        <td align="center" height="23"><input name="px[<?php echo $rs['id']?>]" type="text" class="inputclass" value="<?php echo $rs['px']?>"></td>
    </tr>
      <tr>
        <td align="center" height="23"><input name="12" type="button" value="重传" onclick="location='pl_edit.php?id=<?php echo $rs['id']?>&pl_id=<?php echo $pl_id?>'" class="btn" style="padding:0 6px;_padding:0 1px;" />&nbsp;<input name="32" type="button" value="删除" onclick="location='pl_make.php?act=del&id=<?php echo $rs['id']?>&pl_id=<?php echo $pl_id?>'"  class="btn" style="padding:0 6px;_padding:0 1px;"/><input name="id[<?php echo $rs['id']?>]" type="hidden" class="inputclass" value="<?php echo $rs['id']?>"></td>
      </tr>
    </table>
    </td>
    <?php
			if($a%7==0){
				echo'</tr><tr>';
			}
			$a++;
		}
		$ynum=$a-1;
	?>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" style="margin:0px 0 0 6px;">
  <tr>
  	<?php
    //如果图片标题和图片排序都隐藏的话，批量更新的按钮也隐藏
	if (!($conf['pl']['title']==false&&$conf['pl']['px']==false)){
	?>
    <td><input type="button" name="button2" value="批量更新" class="btn" onclick="submit_pl('edit_pl')" />&nbsp;</td>
    <?php
    }
	?>
    <td><input type="button" name="button2" value="批量删除" class="btn" onclick="submit_pl('del_pl')"  /></td>
  </tr>
</table>
</FORM>
<?php
	}
}
?>
<script type="text/javascript">
//基本配置
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	url : 'upload.php',
	flash_swf_url : 'js/Moxie.swf',
	silverlight_xap_url : 'js/Moxie.xap',
	file_data_name:'file_up',
	filters : {
		max_file_size : '<?php echo $maxsize?>',
		prevent_duplicates : true, //不允许队列中存在重复文件
		mime_types: [
			{title : "Image files", extensions : "<?php echo str_replace("|",",",$allowext);?>"}
		]
	},
	
	init: {
		//安装后触发
		PostInit: function() {
			//点击上传按钮触发
			document.getElementById('uploadfiles').onclick = function() {
				//document.getElementById("up_zong").style.display="";
				//document.getElementById("up_pro").style.width="0px";
				uploader.start(); //上传开始，等全部上传完毕自动提交表单
			};
			//点击清除所有触发
			document.getElementById('clearfiles').onclick = function() {
				var files=uploader.files;
				var len = files.length;
				//清除阅览的图片
				for(var i = 0; i<len; i++){
					document.getElementById("filelist").removeChild(document.getElementById(files[i].id));
				};
				//清除图片对象
				uploader.splice(0,len);
			};
		},
		//选好要上传的文件后触发
		FilesAdded: function(up, files) {
			<?php
			//控制上传数量
			if ($allownum>0){
				if ($ynum>=$allownum){
					echo 'alert("最多只能上传'.$allownum.'张图片")'."\n";
					echo 'uploader.splice(uploader.files.length-files.length,files.length);'."\n";
					echo 'return false'."\n";
				}else{
					echo 'if (uploader.files.length>'.($allownum-$ynum).'){'."\n";
					echo '	alert("最多只能上传'.$allownum.'张图片")'."\n";
					echo 'uploader.splice(uploader.files.length-files.length,files.length);'."\n";
					echo 'return false}'."\n";
				}
			}
			?>
			var yli=document.getElementById('filelist').getElementsByTagName('li').length;
			for(var i = 0, len = files.length; i<len; i++){
				var file_name = files[i].name;
				//b标签放进度条 div放删除按钮 p放阅览图片 一个隐藏的文本框放文件路径 一个文本框放文件标题(默认读取文件名称作为文件标题，如要取消请删除赋值/即可)
				document.getElementById('filelist').innerHTML+= '<li id="' + files[i].id +'"><b></b><div class="del_btn" onclick=del("'+files[i].id+'")></div><p></p><input name="title[]" id="title_'+files[i].id+'" type="text" class="inputclass" <?php if ($conf['pl']['title']==false){echo ' style="display:none;"';}?> value='+files[i].name.substr(0,files[i].name.lastIndexOf("."))+'><input name="img_sl[]" type="text" class="inputclass" style="display:none;" id="img_sl_'+files[i].id +'"><input name="px[]" id="px_'+files[i].id+'" type="text" class="inputclass" <?php if ($conf['pl']['px']==false){echo ' style="display:none;"';}?> value="'+(<?php echo $ynum.'+'?>i+yli+1)+'"></li>';
				!function(i){
					previewImage(files[i],function(imgsrc){
						document.getElementById(files[i].id).getElementsByTagName('p')[0].innerHTML='<img src="'+ imgsrc +'" />';
					})
				}(i);
			}
		},
		//上传队列中每一个文件开始上传后触发
		UploadFile:function (up,files){

		},
		//在文件上传过程中不断触发，可以用此事件来显示上传进度
		UploadProgress: function(up, file) {
			//document.getElementById("up_pro").style.width=(up.total.percent/100)*200+"px"
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span style="width:'+((file.percent/100)*80)+'px;height:5px;display:block;background-color:#0000FF;">&nbsp;</span>';
		},
		//上传队列中每一个文件上传完成后触发
		FileUploaded:function(up,file,respon){
			//每个文件上传完了以后把服务器返回的值赋给每张图片的文本框
			if (respon.response!=""){
				document.getElementById("img_sl_"+file.id).value=(respon.response);
			}
		},
		//上传队列中所有文件都上传完成后触发
		UploadComplete:function(up,files){
			//document.getElementById("up_zong").style.display="none";
			document.getElementById("formp").submit();
		},
		//上传队列中每一个文件上传出错后触发
		Error: function(up, err) {
			str="";
			//提示超文件大小
			if (err.code=='-600'){
				str=" 超过<?php echo ($maxsize/1000)?>KB";
			//提示文件格式错误
			}else if (err.code=='-601'){
				str=" 文件格式不正确";
			//其他都显示“出错”
			}else{
				str=" 出错";
			}
			if (err.code=='-602'){
				str="";
			}else{
				str=err.file.name+str+"<br/>";
			}
			document.getElementById('errlist').innerHTML+=str;
		}
	}
});

uploader.init();

//阅览图片
function previewImage(file,callback){//file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
	if(!file || !(/image\//.test(file.type))) return; //确保文件是图片
	if(file.type=='image/gif'){//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
		var fr = new mOxie.FileReader();
		fr.onload = function(){
			callback(fr.result);
			fr.destroy();
			fr = null;
		}
		fr.readAsDataURL(file.getSource());
	}else{
		var preloader = new mOxie.Image();
		preloader.onload = function() {
			preloader.downsize( 300, 300 );//先压缩一下要预览的图片,宽300，高300
			var imgsrc = preloader.type=='image/jpeg' ? preloader.getAsDataURL('image/jpeg',80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
			callback && callback(imgsrc); //callback传入的参数为预览图片的url
			preloader.destroy();
			preloader = null;
		};
		preloader.load( file.getSource() );
	}	
}
//删除单个图片
function del(id){ 
	uploader.removeFile(id); 
	document.getElementById("filelist").removeChild(document.getElementById(id));
}
</script>
</body>
</html>