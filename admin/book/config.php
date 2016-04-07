<?php
//系统设置
$conf['sy']=array(
	'name'=>'留言',                    //系统名称
	'table_co'=>$tablepre.'book',     //系统表名
	'folder_co'=>$tablepre.'book',    //系统文件夹
	'seo'=>false,                     //系统seo设置---即后台的左侧"seo设置"一行是否显示
	'r_email'=>false,                 //设置收件箱---即后台的左侧"收件箱设置"一行是否显示
	'huifu'=>false                    //是否有回复
);

$conf['co']=array(
	'title'=>true,                    //标题
	'num'=>false,                     //数量
	'rename'=>true,                   //姓名
	'sex'=>false,                     //性别
	'phone'=>true,                    //电话
	'fax'=>false,                     //传真
	'email'=>true,                    //邮箱
	'qq'=>false,                      //QQ
	'wx'=>false,                      //微信
	'compname'=>true,                 //公司名称
	'address'=>true,                  //地址
	'post'=>true,                     //邮编
	'z_body'=>true                    //内容
);

?>
