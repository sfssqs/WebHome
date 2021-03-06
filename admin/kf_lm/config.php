<?php
//系统设置
$conf['sy']=array(
	'name'=>'客服',                     //系统名称
	'table_lx'=>$tablepre.'kf_lx',     //类型表名
	'table_lm'=>$tablepre.'kf_lm',     //分类表名
	'table_co'=>$tablepre.'kf_co',     //信息表名
	'folder_lx'=>'kf_lx',              //类型文件夹名
	'folder_lm'=>'kf_lm',              //分类文件夹名
	'folder_co'=>'kf_co',              //信息文件夹名
	'need_lm'=>false,                  //系统是否需要分类---此设置是指该系统要不要分类
	'need_lx'=>true,                   //系统是否需要类型---此设置是指该系统要不要类型
	'manage_lm'=>true,                 //系统是否可以管理分类---此设置只针对后台的左侧"分类管理"一行是否显示
	'manage_lx'=>true,                 //系统是否可以管理分类---此设置只针对后台的左侧"分类管理"一行是否显示
	'level_lm'=>0                      //系统最多可以添加几级分类---0为无限级，1为1级
);

//分类要使用的功能和字段
$conf['lm']=array(
	//以下是要使用的功能
	'add_lm'=>true,                    //是否可以添加分类---如果不可以添加分类就只能管理分类(不能删除)
	//以下是要显示的字段
	'con_att'=>true,                   //分类是否显示分类属性---就是这些属性"是否可以添加信息"，"是否可以添加下一级"，"完全控制、只能修改、只能读取，不能进行任何操作"
	'tuijian'=>false,                   //分类推荐按钮
	'hot'=>false,                       //分类热门按钮
	'pass'=>false                       //分类屏蔽按钮
);

//信息要使用的功能和字段
$conf['co']=array(
	//以下是要使用的功能
	'add_xx'=>true,                    //是否可以添加信息---如果不可以添加信息，信息就不能删除
	//以下是要显示的字段
	'rename'=>true,                    //链接地址
	'uename'=>true,                    //详细介绍
	'ding'=>true,                      //置顶
	'tuijian'=>false,                   //推荐
	'hot'=>false,                       //热门
	'pass'=>true                       //屏蔽
);
?>