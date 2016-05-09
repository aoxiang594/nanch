<?php
/**
 * Nanch
 * @Author:Luffy <[<email address>]>
 * @Comment:还不知道要干什么
 * @Time:2016年05月06日14:58:02
 */
class nanch{
	public $request;
	function __construct()
	{
		$this->request = new request();
		
	}

	public function run()
	{
		//取得模块、控制器、方法、
		$module = $this->request->get_module();
		$controller = $this->request->get_contoller();
		$action = $this->request->get_action();
		$controller = load_controller($controller);
		$controller->$action();
		
	}
}
?>