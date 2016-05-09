<?php
//Nanch入口文件
date_default_timezone_set('Asia/Shanghai');
if(!defined('APP_ROOT_DIR')){
	exit("Not defined APP_ROOT_DIR.");
}
define('ATTACHMENT',  'attachment');
define('CORE_DIR',    dirname(__FILE__));//library公共的核心库文件
//define('ROOT_PATH',   dirname(dirname(__FILE__)));//站点根目录
//define('CACHE_DIR',   ROOT_PATH.'/data/cache');//公共的缓存目录
//define('CONF_DIR',    ROOT_PATH.'/data/conf');//公共的配置目录
//define('UPLOAD_DIR',  ROOT_PATH.'/'.ATTACHMENT);//公共的上传目录
//define('APP_CTRL_DIR',APP_ROOT_DIR.'/controller');//应用的控制器目录
//define('APP_LIB_DIR', APP_ROOT_DIR.'/lib');//应用的核心目录
//define('APP_TMP_DIR', APP_ROOT_DIR.'/tmp');//应用的缓存目录
//define('APP_TPL_DIR', APP_ROOT_DIR.'/templates');//应用的模板目录

#if(!defined('MODEL_DIR')){
#	define('MODEL_DIR',   ROOT_PATH.'/model');//公共的模型目录
#}
require CORE_DIR.'/function.php';
require CORE_DIR.'/request.php';
require CORE_DIR.'/db.php';
require CORE_DIR.'/controller.php';
require CORE_DIR.'/model.php';
require CORE_DIR.'/library/build.php';

require CORE_DIR.'/nanch.php';
?>