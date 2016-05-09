<?php
//APP 入口文件
error_reporting(E_ALL);
date_default_timezone_set("Asia/Shanghai");
define('DEBUG_MODE',"On");
define('APP_NAME','home');

define('APP_ROOT_DIR', dirname(__FILE__));
define('CONTROLLER_DIR',APP_ROOT_DIR.'/'.'controller');
define('MODEL_DIR',APP_ROOT_DIR.'/'.'model');
ini_set("display_errors", DEBUG_MODE ? "On" : "Off");
require '../system/Init.php';
require APP_ROOT_DIR.'/plugin/Init.php';
//Enjoy Nanch

//$html = "<a  href='http://www.baidu.com' style='color:#DDDDDD;'>zqdn</a>";

// $request = new request();
// $request->setRequestUri();
// dd($request->_requestUri)

//build::buildController("Home",array("Article","Comment"));
$nanch = new nanch();
$nanch->run();
?>