<?php
class IndexController extends Controller
{

    public function index()
    {
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>Nanch</b>！</p></div>','utf-8');
    	$db = new model("user");
        $user = $db->getAll("","","name ASC");
        echo $db->sql;
        dd($user);
        $user = $db->getRow("","","name DESC");
        echo $db->sql;
        dd($user);
        $user = $db->getOne("","","name ASC");
        echo $db->sql;
        dd($user);
        //$db->check_field("name,user_id");
       
    }

    public function test()
    {
    	//$UserModel = load_model("User");
    	
    }

}