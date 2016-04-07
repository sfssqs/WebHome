<?php
//系统设置
$conf['sy']=array(
	'name'=>'案例',                     //系统名称
	'table_lm'=>$tablepre.'case_lm',   //分类表名
	'table_co'=>$tablepre.'case_co',   //信息表名
	'folder_lm'=>'case_lm',            //分类文件夹名
	'folder_co'=>'case_co',            //信息文件夹名
	'seo'=>false,                      //使用系统seo配置---即后台的左侧"系统SEO配置"一行是否
	'need_lm'=>true,                   //系统是否需要分类---此设置是指该系统要不要分类
	'manage_lm'=>true,                 //系统是否可以管理分类---此设置只针对后台的左侧"分类管理"一行是否显示
	'level_lm'=>0                      //系统最多可以添加几级分类---0为无限级，1为1级
);

//分类要使用的功能和字段
$conf['lm']=array(
	//以下是要使用的功能
	'seo'=>true,                       //分类启用seo
	'add_lm'=>true,                    //是否可以添加分类---如果不可以添加分类就只能管理分类(不能删除)
	//以下是要显示的字段
	'url_lm'=>false,                    //分类链接地址
	'f_body_lm'=>false,                 //分类简要介绍
	'z_body_lm'=>false,                 //分类详细介绍
	'img_sl_lm'=>false,                 //分类图片上传
	'con_att'=>true,                    //分类是否显示分类属性---就是这些属性"是否可以添加信息"，"是否可以添加下一级"，"完全控制、只能修改、只能读取，不能进行任何操作"
	'tuijian'=>false,                   //分类推荐按钮
	'hot'=>false,                       //分类热门按钮
	'pass'=>false                       //分类屏蔽按钮
);

//信息要使用的功能和字段
$conf['co']=array(
	//以下是要使用的功能
	'seo'=>true,                       //信息启用seo
	'add_xx'=>true,                    //是否可以添加信息---如果不可以添加信息，信息就不能删除
	//以下是要显示的字段
	'keyword'=>false,                  //信息关键字(用于相关信息)
	'link_url'=>false,                 //链接地址
	'f_body'=>false,                   //简要介绍
	'img_sl'=>false,                    //图片上传
	'pic_sl'=>false,                   //图片2上传
	'fil_sl'=>false,                   //文件上传
	'vid_sl'=>false,                   //视频上传
	'duotu'=>false,                    //多图
	'ding'=>true,                      //置顶
	'tuijian'=>false,                  //推荐
	'hot'=>false,                      //热门
	'pass'=>true                       //屏蔽
);

//include/config.inc.php的$sy_seo==true同时本系统分类也启用seo，这样分类才算启用seo
if($sy_seo==true&&$conf['lm']['seo']==true){
	$conf['lm']['seo']=true;
}else{
	$conf['lm']['seo']=false;
}

//include/config.inc.php的$sy_seo==true同时本系统信息也启用seo，这样信息才算启用seo
if($sy_seo==true&&$conf['co']['seo']==true){
	$conf['co']['seo']=true;
}else{
	$conf['co']['seo']=false;
}
?>