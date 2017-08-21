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
define('DEBUG',false);

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

//定义配置文件地址
define('CONFIG_PATH',ROOT_DIR.'/config.ini');


include (ROOT_DIR.'/function.php');
include (ROOT_DIR.'/db/MysqliDb.php');



