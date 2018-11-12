<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午12:21
 */

namespace Rxlisbest\Sun\Console\Controllers;

use Rxlisbest\Sun\Sun;
use Rxlisbest\Sun\Console\Models\Migration;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

class MigrationController
{
    protected $db_class = 'Rxlisbest\Sun\Web\Component\Db';
    protected $table = "migration";

    public function run()
    {
        echo "migration";
    }

    public function create($param)
    {
        $class_name = $param[0];
        $file_name = date('YmdHis') . '_' . strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $class_name)) . '.php';
        $path = Sun::$config['base_path'] . DS . 'database' . DS . 'migration' . DS;
        $file = $path . $file_name;
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
namespace database\migration;

class ${class} {
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
//        Migration::ins()->select();
        $db = Sun::createObject($this->db_class, [Sun::$config['database']]);
        $this->db = $db;
        $result = $this->db->createTable('migrate2', ['id int not null auto_increment', 'name varchar(255)']);
        var_dump($result);
    }
}