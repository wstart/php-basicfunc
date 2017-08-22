<?php
/**
 * Created by PhpStorm.
 * User: wstart
 * Date: 2017/8/17
 * Time: 下午2:07
 */

//版本
define('php_basic','0.1');

//是否开启调试
define('DEBUG',true);

//错误提示
error_reporting(7);

//执行事件
ini_set("max_execution_time", "18000");

//定义基础目录
define('ROOT_DIR',dirname(__FILE__));


$crurl = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$crurl = $_SERVER['HTTP_HOST'].$crurl;
if ('/' == substr($crurl, -1))
{
    $crurl .= 'index.php';
}
$php_self = explode("/",$crurl);
$php_self = $php_self[count($php_self)-1];

//脚本名称
define('PHPSELF',$php_self);

//完整url
define('CRURL',$crurl);

//配置文件路径
define('CONFIG_PATH',ROOT_DIR.'/config.ini');

//控制器路径
define("CPATH", ROOT_DIR.'/control') ;

//模型路径
define("MPATH",ROOT_DIR.'/model') ;

include (ROOT_DIR.'/core/function.php');
include (ROOT_DIR.'/core/validator.php');
include (ROOT_DIR.'/control/supercontrol.php');
include (ROOT_DIR.'/core/db/MysqliDb.php');
include (ROOT_DIR.'/core/output.php');



