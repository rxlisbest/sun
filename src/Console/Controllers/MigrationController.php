<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午12:21
 */

namespace Rxlisbest\Sun\Console\Controllers;

use rxlisbest\easylog\EasyLog;
use Rxlisbest\Sun\Sun;
use Rxlisbest\Sun\Console\Models\Migration;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

class MigrationController extends \Rxlisbest\Sun\Web\Component\Migration
{
    protected $table = "migration";
    protected $namespace = 'database\migration';

    public function run()
    {
        echo "migration";
    }

    public function create($param)
    {
        if (!isset($param[0]) || !$param[0]) {
            EasyLog::text('Class Name can not empty!', 'error');
            return;
        }

        $class_name = $param[0];
        $class_name = $this->createClassName($class_name);
        $path = Sun::$config['base_path'] . DS . str_replace('\\', DS, $this->namespace) . DS;
        $file = $path . $class_name . '.php';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $fp = fopen($file, "w");
        $content = $this->content($class_name);
        fwrite($fp, $content);
        fclose($fp);
    }

    protected function content($class)
    {
        $content = <<<data
<?php
namespace {$this->namespace};

use Rxlisbest\Sun\Web\Component\Migration;

class ${class} extends Migration
{

    public function up()
    {
        // do nothing
    }
    
    public function down()
    {
        // do nothing
    }
}
data;
        return $content;
    }

    public function up()
    {
        $this->initTable();
        $list = Migration::ins()->select();
        $class_name_list = array_column($list, 'class_name');
        $path = Sun::$config['base_path'] . DS . str_replace('\\', DS, $this->namespace) . DS;
        $handler = opendir($path);
        while (($file_name = readdir($handler)) !== false) {
            if (is_file($path . $file_name)) {
                $class_name = substr($file_name, 0, strpos($file_name, "."));
                $class = Sun::createObject('\\' . $this->namespace . '\\' . $class_name);
                if (!in_array($class_name, $class_name_list)) {
                    $data = [];
                    $data['class_name'] = $class_name;
                    $data['create_time'] = time();
                    Migration::ins()->insert($data);
                    call_user_func_array([$class, 'up'], []);
                }
            }
        }
        closedir($handler);
    }

    public function down()
    {
        $info = Migration::ins()->find();
        if ($info) {
            $path = Sun::$config['base_path'] . DS . str_replace('\\', DS, $this->namespace) . DS;
            $handler = opendir($path);
            if (is_file($path . $info['class_name'] . '.php')) {
                $class = Sun::createObject('\\' . $this->namespace . '\\' . $info['class_name']);
                $list = Migration::ins()->where(['class_name', '=', $info['class_name']])->delete();
                call_user_func_array([$class, 'down'], []);
            }
        }
    }

    protected function createClassName($class_name)
    {
        $class_name = 's' . date('YmdHis') . '_' . strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $class_name));
        return $class_name;
    }

    protected function initTable()
    {
        $this->db->createTable(
            Sun::$config['database']['prefix'] . 'migration',
            [
                'class_name varchar(255) NOT NULL DEFAULT \'\' COMMENT \'class name\'',
                'create_time bigint(20) NOT NULL DEFAULT 0 COMMENT \'create time\'',
            ]
        );
    }
}