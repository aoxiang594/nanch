<?php
/**
 * Nanch
 * @Author:Luffy <[<email address>]>
 * @Comment:公用方法
 * @Time:2016年05月05日14:58:08
 */

/**
 * [dd 打印一个变量]
 * @param  [type] $param [description]
 * @return [type]        [description]
 */
function dd($param)
{
    echo "<pre>";
    var_dump($param);
    echo "</pre>";
}
function rr($param)
{
    echo "<pre>";
    print_r($param);
    echo "</pre>";
}

function warning($content = "",$where = "")
{
    if(empty($content) && empty($content))
    {
        return false;
    }
    $dir = APP_ROOT_DIR."/log";
    
    if(!is_dir($dir))
    {
        //不存在该目录,创建目录
        if(!mkdir($dir,0777,true))
        {
            //创建失败
            error_log("创建log目录失败:".$dir);
            trigger_error("创建log目录失败:".$dir);
            return false;
        }
    }

    //写入日志
    $time = time();
    $file = $dir."/".date("Ymd",$time).".txt";

    ob_start();
    if(is_array($content))
    {
        echo date("Y-m-d H:i:s",$time).":[".$where."]\r\n";
        dd($content);
        echo "\r\n";
        
    }else {
        echo date("Y-m-d H:i:s",$time).":[".$where."]".$content."\r\n";
    }
    $ob = ob_get_contents();
    ob_end_clean();
    file_put_contents($file,$ob,FILE_APPEND);
}


/**
 * [get 获取GET过来的值]
 * @param  string $name    [变量名]
 * @param  string $filter  [过滤函数]
 * @param  string $default [默认值]
 * @return [array||string]          [description]
 */
function get($name = "",$filter = "htmlspecialchars",$default = "")
{   
    
    if(isset($_GET[$name]) && (!empty($_GET[$name]) || $_GET[$name] === "0"))
    {
        $data = $_GET[$name];
        
        $data = call_user_func("htmlspecialchars",$data);
    }else
    {
        $data = $default;
    }

    return $data;
}

/**
 * [post 获取POST过来的值]
 * @param  string $name    [变量名]
 * @param  string $filter  [过滤函数]
 * @param  string $default [默认值]
 * @return [array||string]          [description]
 */
function post($name = "",$filter = "htmlspecialchars",$default = "")
{   
    
    if((isset($_POST[$name]) && !empty($_POST[$name])) || $_POST[$name] === "0")
    {
        $data = $_POST[$name];
        
        $data = call_user_func("intval",$data);
    }else
    {
        $data = $default;
    }

    return $data;
}
/**
 * [load_controller description]
 * @param  string $class_name  [description]
 * @param  string $module_name [description]
 * @return [type]              [description]
 */
function load_controller($class_name = "",$module_name = "Home")
{
    if(!empty($class_name))
    {
        $controller_file = CONTROLLER_DIR.'/'.$module_name."/".$class_name.".controller.php";
        
        if(file_exists($controller_file))
        {
            require  $controller_file;
            $class_name .= "Controller";
            $controller = new $class_name;
            return $controller;
        }else
        {
            error_msg("Can not found Controller[".$class_name."]",false,"error");
        }
        
    }else
    {
        error_msg("Controller name is empty",false,"error");
    }
    
}

/**
 * [load_model description]
 * @param  string $model_name [description]
 * @return [type]              [description]
 */
function load_model($model_name = "")
{
    $model_file = CONTROLLER_DIR.'/'.$model_name.".model.php";
    if(file_exists($model_file))
    {
        require  $model_file;
    }else
    {

    }
}

/**
 * [load_file description]
 * @param  string  $file_name [description]
 * @param  boolean $dir       [description]
 * @return [type]             [description]
 */
function load_file($file_name = "",$dir = false)
{
    
    if(!$dir)
    {
        $dir = APP_ROOT_DIR."/config/";
    }
    $file = $dir."/".$file_name.".php";
    if(file_exists($file))
    {
        return include_once($file);
    }
}

/**
 * [error_msg description]
 * @param  string  $msg   [description]
 * @param  boolean $url   [description]
 * @param  string  $level [description]
 * @return [type]         [description]
 */
function error_msg($msg = '',$url = false,$level = 'notice')
{
    switch($level)
    {
        case 'notice':
            echo $msg;
            break;
        case 'error':
            echo $msg;
            die();
            break;
    }
    
}


?>