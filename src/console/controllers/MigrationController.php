<?php
/**
 * Created by PhpStorm.
 * User: ruixinglong
 * Date: 2018/1/17
 * Time: 下午12:21
 */
namespace Rxlisbest\Sun\Console\Controllers;

use Rxlisbest\Sun\Web\Component\Controller;
use app\models\Test;
use Rxlisbest\Sun\Sun;

class MigrationController extends Controller
{
    public function index()
    {
        $this->fetch('', ['name' => 'sun-framework']);
    }
}