<?php
require('../../include/common.inc.php');
require('upcon.php');
require('../'.$table_lm.'/config.php');
checklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>批量上传</title>
<link href="../css/admin_style.css" type="text/css" rel="stylesheet"/>
<script src="../scripts/function.js"></script>
<script type="text/javascript" src="js/plupload.full.min.js"></script>
<style>
.filelist{ width:600px;}
.filelist li{ width:80px;float:left; margin:3px 8px 0 0; padding:0px; list-style:none; position:relative;}
.filelist b{ display:block;height:5px; overflow:hidden;}
.filelist .del_btn{ width:8px; height:8px; overflow:hidden;background:url(js/del.png);position:absolute; top:8px; right:1px; cursor:pointer; }
.filelist p{ margin:2px 0 0 0; padding:1px; border:1px solid #ccc; background-color:#fff; display:block;}
.filelist p img{ width:76px; height:76px;}
.inputclass { width:76px; height:15px; margin-top:1px; padding:1px;}
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="topbg">
    <td>批量上传</td>
  </tr>
</table>
<br />
<FORM name="formp" id="formp" method="post" action="addd.php">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="border">
  <tr class="title">
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="tdbg">
    <td width="120" align="right">所属分类：</td>
    <td>
    <select name="lm" id="lm">
      <option value="0" selected="selected">请选择分类</option>
    	<?php
		//把所有分类放到$rss数组里
        $rss=$db->getrss('select * from `'.$tablepre.$table_lm.'` order by `px` desc,`id_lm` desc');
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
    </select>    </td>
  </tr>
        <tr class="tdbg">
        	<td></td>
            <td>
            	<!--显示报错-->
            	<span id="errlist" style="color:#FF0000;"></span>
                <!--浏览按钮-->
                <div id="container"><input id="pickfiles" type="button" name="Submit1" value="选 择 图 片" class="btn" style="_padding:0px;"> <input id="clearfiles" type="button" name="Submit2" value="删 除 选 择" class="btn" style="_padding:0px;"></div>
                <!--总的进度条-->
                <div id="up_zong" style="width:200px; border:1px solid #ccc; height:10px; display:none;"><div id="up_pro" style="background-color:#0000FF;height:10px;"></div></div>
                <!--文件阅览列表-->
                <span id="filelist" class="filelist"></span>
            </td>
        </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="122">&nbsp;</td>
    <td><input id="uploadfiles" type="button" name="Submit2" value="提交上传" class="btn"></td>
  </tr>
</table>
</FORM>
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
				<?php
				if ($conf['sy']['need_lm']==true){
				?>
				if (document.getElementById('lm').value=="0"){
					alert("请选择分类");
					document.getElementById('lm').focus();
					return false;
				}
				<?php
				}
				?>
				if (document.getElementById('lm').value=="no"){
					alert("所选分类不允许添加产品");
					document.getElementById('lm').focus();
					return false;
				}
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
			for(var i = 0, len = files.length; i<len; i++){
				var file_name = files[i].name;
				//b标签放进度条 div放删除按钮 p放阅览图片 一个隐藏的文本框放文件路径 一个文本框放文件标题(默认读取文件名称作为文件标题，如要取消请删除赋值/即可)
				document.getElementById('filelist').innerHTML+= '<li id="' + files[i].id +'"><b></b><div class="del_btn" onclick=del("'+files[i].id+'")></div><p></p><input name="title[]" id="title_'+files[i].id+'" type="text" class="inputclass" <?php if ($displaytitle==false){echo ' style="display:none;"';}?> value='+files[i].name.substr(0,files[i].name.lastIndexOf("."))+'><input name="img_sl[]" type="text"  class="inputclass" style="display:none;" id="img_sl_'+files[i].id +'"><input name="px[]" id="px_'+files[i].id+'" type="text" class="inputclass" <?php if ($displaypx==false){echo ' style="display:none;"';}?> value="100" ></li>';
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
