<?php


if (!defined('php_basic')){
    die('no promistion to visited');
}
/**
 * 头部 跳转函数
 *
 * @param string $url url
 * @return void
 */
function header_location($url = 'index.php')
{
    header("location:$url");
    die();
}


/**
 * 头部 判断是否是移动手机
 *
 * @param void
 * @return @ismobile  bool true is mobile false is not
 */
function header_ismobile()
{
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    //echo $user_agent;
    $mobile_agents = Array("ipad", "wap", "android", "iphone", "sec", "sam", "ericsson", "240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte", "ben", "hai", "phili");
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            if ('ipad' == $device) {
                return $is_mobile;
            }
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}


/**
 * 深度过滤函数
 *
 * @param $value array
 * @return $value
 */
function addslashes_deep($value)
{
    if (empty($value)) {
        return $value;
    } else {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}


/**
 * 返回csrftoken
 *
 * @param $uckey 自定义函数
 * @return csrf_token
 */
function csrf_token($uckey = '')
{
    return substr(md5(substr(time(), 0, -7) . session_id() . $uckey), 8, 8);
}

/**
 * 判断密码复杂度是否足够
 * @param $password
 * @param int $strongpw 0  没任何要求 1 包含数字 2 包含小写 3 包含大写 4 包含特殊符号
 * @param int $length
 * @return  string '' 通过  不为空则 显示具体信息
 */
function check_strongpw($password, $strongpw = 1, $length = 6)
{
    if (strlen($password) < $length) {
        return "密码长度不够";
    }

    $msg = '密码必须包含：';
    if ($strongpw >= 1) {
        $result = preg_match('/[0-9]+/', $password) && $result;
        $msg .= "数字、";
    }
    if ($strongpw >= 2) {
        $result = preg_match('/[a-z]+/', $password) && $result;
        $msg .= "小写字母、";
    }
    if ($strongpw >= 3) {
        $result = preg_match('/[A-Z]+/', $password) && $result;
        $msg .= "大写字母、";
    }
    if ($strongpw >= 4) {
        $result = preg_match('/[[:punct:]]+/', $password) && $result;
        $msg .= "特殊符号、";
    }
    if (!$result) {
        return trim($msg, "、");
    }


    return "";
}

/**
 * UC加解密
 * @param $string 需要加密的字符串
 * @param string $operation DECODE 解密 默认是加密啊
 * @param string $key 加密的密匙
 * @param int $expiry 超时事件
 * @return string  加密|解密 以后的字符串
 */
function uc_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{

    $ckey_length = 4;

    $key = md5($key ? $key : UC_KEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ?
        ($operation == 'DECODE' ?
            substr($string, 0, $ckey_length)
            : substr(md5(microtime()), -$ckey_length))
        : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ?
        base64_decode(substr($string, $ckey_length))
        : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0)
            && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)
        ) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}


/**
 * UBB编码
 * [url]url[url] -> <a href=url>url
 * [url=url]title[url] -> <a href=url>title
 * @param $Text
 * @return mixed|string
 */
function UBB($Text)
{
    $Text = trim($Text);
    $Text = ereg_replace("<br>", "\r\n", $Text);
    $Text = htmlspecialchars($Text);
    $Text = ereg_replace("\r\n", "<br>", $Text);
    $Text = ereg_replace("\n", "<br>", $Text);
    $Text = preg_replace("/\\t/is", " ", $Text);
    $Text = preg_replace("/\[url\](.+?)\[\/url\]/is", '<a href="\\1" target="_blank">\\1</a>', $Text);
    $Text = preg_replace("/\[url=(.+?)\](.+?)\[\/url\]/is", '<a href="\\1" target="_blank">\\2</a>', $Text);
    return $Text;
}

/**
 * 判断是否是正则表达式
 * @param $expstr
 * @return int 0 正则表达式 1 缺少括号
 */
function isValidCond($expstr)
{
    $expstr = preg_replace('/\\\\\'/i', '', $expstr);
    $expstr = preg_replace("/'[^']*'/i", '', $expstr);
    if (stristr($expstr, '(') == false && stristr($expstr, ')') == false)
        return 0;
    $temp = array();
    for ($i = 0; $i < strlen($expstr); $i++) {
        $ch = $expstr[$i];
        switch ($ch) {
            case '(':
                array_push($temp, '(');
                break;
            case ')':
                if (empty($temp) || array_pop($temp) != '(') {
                    return -1;//"缺少左括号（";  
                }
        }
    }
    return empty($temp) == true ? 0 : 1; // "表达式匹配" : "缺少右括号）";
}

/**
 * 获取随机字符串
 * @param $length int 长度
 * @param  $hasnum bool  是否需要包含数字
 * @return string
 */
function getrandstring($length, $hasnum = false)
{
    $str = '';
    $length = intval($length);
    if ($length <= 0) {
        $length = 1;
    }
    for ($i = 0; $i <= $length; $i++) {
        if ($hasnum) {
            $rchr = mt_rand(0, 1) == 1 ? mt_rand(ord('a'), ord('z')) : mt_rand(ord('0'), ord('9'));
        } else {
            $rchr = mt_rand(ord('a'), ord('z'));
        }
        $str .= chr($rchr);
    }
    return $str;
}


/**
 * 发包函数
 * @param $url 地址
 * @param $data 参数
 * @param $type string 发送数据类型
 * @return string
 */
function request_func($url,$data,$type="json")
{

    if($type=="json"){
        $data = json_encode($data);
    }else {
        $data = http_build_query($data);
    }

    $opts = array(
        'http' => array(
            'method' => "POST",
            'header' => "Content-length:" . strlen($data) . "\r\n" .
                "\r\n",
            'content' => $data,
        )
    );
    $cxContext = stream_context_create($opts);
    $sFile = file_get_contents($url, false, $cxContext);

    return   $sFile;

}
?>