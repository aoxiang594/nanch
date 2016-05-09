<?php
/**
 * Nanch-request
 * @Author:Luffy <[<email address>]>
 * @Comment:获取输入的内容，get,post,input,
 * @Time:2016年05月06日14:58:02
 */
class request{
    public $_uri;
    public $_module = 'index';
    public $_action = 'index';
    public $_controller = 'index';
    function __construct()
    {
        $this->_uri = $_SERVER['REQUEST_URI'];
        $this->set_path_info();
    }
    public function get_uri()
    {
        return $this->_uri;
    }

    public function set_module($module = false)
    {

        $this->_module = $module?$module:$this->_module;
    }
    public function get_module()
    {
        return $this->_module;
    }

    public function set_action($action = false)
    {
        $this->_action = $action?$action:$this->_action;
    }
    public function get_action()
    {
        return $this->_action;   
    }

    public function set_contoller($controller = false)
    {
        $this->_contoller = $controller?$controller:$this->_contoller;
    }
    public function get_contoller()
    {
        return $this->_controller;
    }


    /**
     * [set_path_info 从path中获取到module、action、controller以及其他信息]
     * @param [type] $path_info [description]
     */
    public function set_path_info($path_info = null)
    {
        // if ($pathInfo === null) {
        //     $baseUrl = $this->getBaseUrl();
        //     $requestUri = $this->getRequestUri();
        //     if ($pos = strpos($requestUri, '?')) {
        //         $requestUri = substr($requestUri, 0, $pos);
        //     }
        //     $pathInfo = $requestUri;//substr($requestUri, strlen($baseUrl));
        // }
        // $this->_pathInfo = (string) $pathInfo;
        // return $this;
        

        $this->_controller = empty(get("c"))?$this->_controller:get("c");
        $this->_action = empty(get("a"))?$this->_action:get("a");
        $this->_module = empty(get("m"))?$this->_module:get("m");
        
    }
}
?>