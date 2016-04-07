<?php
//系统设置
$conf['sy']=array(
	'name'=>'报名',                     //系统名称
	'table_co'=>$tablepre.'baoming',   //系统表名
	'folder_co'=>$tablepre.'baoming',  //系统文件夹
	'seo'=>false,                      //系统seo设置---即后台的左侧"seo设置"一行是否显示
	'r_email'=>false                   //设置收件箱---即后台的左侧"收件箱设置"一行是否显示
);

$conf['co']=array(
	'title'=>true,                       //标题
	'num'=>false,                        //数量
	'rename'=>true,                      //姓名
	'sex'=>true,                         //性别
	'phone'=>true,                       //电话
	'fax'=>false,                        //传真
	'email'=>true,                       //邮箱
	'qq'=>true,                          //QQ
	'wx'=>true,                          //微信
	'compname'=>true,                    //公司名称
	'address'=>true,                     //地址
	'post'=>true,                        //邮编
	'z_body'=>true                       //内容
);

?>
