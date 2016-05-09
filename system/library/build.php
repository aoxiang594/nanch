<?php
class build
{
	protected static $controller = '<?php
class [CONTROLLER]Controller extends Controller
{
    public function index()
    {
        [CONTENT]
    }
}?>';

    protected static $model = '<?php
class [MODEL]Model extends Model
{
}?>';

	// 创建控制器类
    public static function buildController($module, $controllers)
    {
        $list  = is_array($controllers) ? $controllers : explode(',', $controllers);
        $hello = '$this->show(\'<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>Nanch</b>！</p></div>\',\'utf-8\');';
        foreach ($list as $controller) {
           
            $file  = CONTROLLER_DIR . "/".$module . '/' . $controller . '.controller.php';
            if (!is_file($file)) {
                $content = str_replace(array('[MODULE]', '[CONTROLLER]', '[CONTENT]'), array($module, $controller, $hello), self::$controller);
                
                $dir = dirname($file);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                file_put_contents($file, $content);
            }
        }
    }
    // 创建模型类
    public static function buildModel($module, $models)
    {
        $list = is_array($models) ? $models : explode(',', $models);
        foreach ($list as $model) {
            $file = MODEL_DIR . $module . '/Model/' . $model . 'model.php';
            if (!is_file($file)) {
                $content = str_replace(array('[MODULE]', '[MODEL]'), array($module, $model), self::$model);
                
                $dir = dirname($file);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                file_put_contents($file, $content);
            }
        }
    }
}