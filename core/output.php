<?php
/**
 * Created by PhpStorm.
 * User: wstart
 * Date: 2017/8/22
 * Time: 上午9:54
 */

if (!defined('php_basic')) {
    die('no promistion to visited');
}


/**
 * 输出函数
 * @param array $data 输出数据
 * @param int $counts 一共数量
 * @param int $code 执行代码
 * @param string $message 输出信息
 * @return string 返回json
 */
function outputdata($data = array(), $counts = 0, $code = 200, $message = "")
{

    if ($message != "") {
        $message = $message . "," . output_code($code);
    }else{
        $message = output_code($code);
    }

    return json_encode(
        array("data" => $data,
            "counts" => $counts,
            "code" => $code,
            "message" => $message,
        )

    );

}


/**
 * 根据代码输出信息
 * @param $code
 * @return string
 */
function output_code($code)
{
    $message = "undefined code";
    switch ($code) {
        //SUCCESS
        case 200:
            $message = "OK";
            break;

        //Client Request Errors
        case 400:
            $message = "请求错误";
            break;
        case 401:
            $message = "请求的对象不存在";
            break;
        case 402:
            $message = "权限不够无法访问";
            break;
        case 403:
            $message = "您被禁止访问";
            break;

        //Server Errors
        case 500:
            $message = "服务器超时";
            break;
        default:
            $message = "未知错误";
            break;

    }

    return $message;
}