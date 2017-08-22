<?php

/**
 * Created by PhpStorm.
 * User: wstart
 * Date: 2017/8/22
 * Time: 上午13:24
 */
class validator
{

    public static function word($varname)
    {

        $result = true;
        /* 如果该项没有设置，默认为校验通过 */

        $word = trim($varname);
        if (!preg_match("/^[a-zA-Z\s]+$/", $word)) {
            $result = false;
        }
        return $result;

    }

    public static function email($varName)
    {
        $result = true;
        /* 如果该项没有设置，默认为校验通过 */

        $email = trim($varName);
        if (!preg_match('/^[-\w]+?@[-\w.]+?$/', $email)) {
            $result = false;
        }

        return $result;
    }

    /**
     * 校验手机
     * @param string $varName 校验项
     * @return bool
     */
    public static function mobile($varName)
    {
        $result = true;
        /* 如果该项没有设置，默认为校验通过 */

        $mobile = trim($varName);
        if (!preg_match('/^1[3458]\d{10}$/', $mobile)) {
            $result = false;
        }

        return $result;
    }

    /**
     * 校验参数为数字
     * @param string $varName 校验项
     * @return bool
     */
    public static function digit($varName)
    {
        $result = false;
        if (is_numeric($varName)) {
            $result = true;
        }
        return $result;
    }


    /**
     * 校验参数为URL
     * @param string $varName 校验项
     * @return bool
     */
    public static function url($url)
    {
        $result = true;
        /* 如果该项没有设置，默认为校验通过 */

        $url = trim($url);
        if (!preg_match('/^(http[s]?::)?\w+?(\.\w+?)$/', $url)) {
            $result = false;
        }

        return $result;
    }
}

?>