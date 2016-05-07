<?php
error_reporting(E_ALL);
date_default_timezone_set("Asia/Shanghai");
define('DEBUG_MODE',1 );
define('APP_MODUL_NAME','home');
define('APP_ROOT_DIR', dirname(__FILE__));

require '../system/Init.php';
require APP_ROOT_DIR.'/plugin/Init.php';
//Enjoy Nanch


$get = get("abc");
dd($_GET['abc']);
dd($get);
