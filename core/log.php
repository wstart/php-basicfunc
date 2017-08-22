<?php
/**
 * Created by PhpStorm.
 * User: wstart
 * Date: 2017/8/22
 * Time: 上午11:13
 */


/**
 * 写日志消息
 * @param $msg
 * @param string $level DEBUG INFO ERROR
 * 如果init里面的DEBUG 不为真 则只会输出ERROR的消息
 */
function log_write($msg, $level = "DEBUG")
{
    if (defined('DEBUG') || $level == 'ERROR') {
        $today = date("Ymd", time());
        $msg = date("Y-m-d H:i:s", time()) . "\t" . $msg . "\n";
        file_put_contents("log_" . $today . ".txt", $msg, FILE_APPEND);
    }

}