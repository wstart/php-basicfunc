<?php
/**
 * Created by PhpStorm.
 * User: wstart
 * Date: 2017/8/17
 * Time: 上午10:57
 */

require_once('init.php');

$config = config_read();

if (!empty($config['db'])) {


} else {
    $config['db'] = array("host" => '127.0.0.1', "username" => 'root', "password" => "", "db" => "test", "port" => 3306);
    config_write($config);
}

$dbinfo = $config['db'];
$conn = new MysqliDb($dbinfo['host'], $dbinfo['username'], $dbinfo['password'], $dbinfo['db'], $dbinfo['port']);


$c = getVaule($_GET['c'], 'home');
$a = getVaule($_GET['a'], 'view');
$m = getVaule($_SERVER['REQUEST_METHOD'], 'GET');


$outputArray = array("data" => array(), "counts" => 0, "code" => 200, "message" => "");

if (validator::word($c) && validator::word($a)) {
    $cfile = CPATH . "/" . $c . ".php";
    $cclass = $c . "_" . $a . "_" . $m;
    if (file_exists($cfile)) {
        require_once($cfile);
        if (class_exists($cclass)) {
            $c = (new $cclass());
            if ($c->authority()) {
                $c->run();
                $outputArray = $c->outputArray;
            } else {
                $outputArray["code"] = 402;
            }
        } else {
            $outputArray["code"] = 401;
            if (DEBUG) $outputArray["message"] = $cclass;
        }
    } else {
        $outputArray["code"] = 401;
        if (DEBUG) $outputArray["message"] = $cfile;
    }


} else {

    $outputArray["code"] = 401;
    if (DEBUG) $outputArray["message"] = $c . "," . $a;
}

echo(outputdata($outputArray["data"], $outputArray['counts'], $outputArray['code'], $outputArray['message']));

die();

