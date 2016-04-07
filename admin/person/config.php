<?php
//系统设置
$conf['sy']=array(
	'name'=>'会员',                     //系统名称
	'table_co'=>$tablepre.'person',   //系统表名
	'folder_co'=>$tablepre.'person',  //系统文件夹
);

$conf['co']=array(
	'rename'=>true,                      //姓名
	'sex'=>true,                         //性别
	'phone'=>true,                       //电话
	'fax'=>true,                         //传真
	'email'=>true,                       //邮箱
	'qq'=>true,                          //QQ
	'wx'=>true,                          //微信
	'compname'=>true,                    //公司名称
	'address'=>true,                     //地址
	'post'=>true,                        //邮编
	'z_body'=>true                       //内容
);

?>
