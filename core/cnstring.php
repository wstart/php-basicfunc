<?php
/**
 * Created by PhpStorm.
 * User: wstart
 * Date: 2017/8/17
 * Time: 上午11:47
 */


/**
 * 中文字符串切割
 *
 * @param $str  string 要切割的字符串
 * @param $start  int 其实位置
 * @param $length int  长度
 * @param $charset string 字符集  utf-8 gb2312 gbk big5
 * @param $suffix bool 是否要加省略号
 * @return csrf_token
 */
function m_substr($str, $start, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr")) {
        $slice = mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    return ($suffix && strlen($str) != strlen($slice)) ? $slice . '...' : $slice;
}




/**
 * 转换乱码到utf8
 * @param $content
 * @param string $code "ASCII", "GB2312", "GBK", "UTF-8"
 * @return string
 */
function convert_content($content,$code='UTF-8')
{
    $content_type = mb_detect_encoding($content, array("ASCII", "GB2312", "GBK", "UTF-8"));
    if ($code != $content_type) {
        return mb_convert_encoding($content, $code, $content_type);

    }
    return $content;
}