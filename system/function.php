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
 * [get description]
 * @param  string $name    [description]
 * @param  string $filter  [description]
 * @param  string $default [description]
 * @return [type]          [description]
 */
function get($name = "",$filter = "htmlspecialchars",$default = "")
{
    dd($_GET);exit;
    if(isset($_GET[$name]))
    {
        echo __LINE__;
        
        //$data = call_user_func($_GET[$name],$filter);
    }else
    {
        $data = $default;
    }

    return $data;
}