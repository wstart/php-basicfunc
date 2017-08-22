<?php

/**
 * Created by PhpStorm.
 * User: wstart
 * Date: 2017/8/22
 * Time: 上午10:54
 */
class home_view_GET extends supercontrol
{

    public function authority()
    {
        return true;
    }

    public function run()
    {

        $this->outputArray['data'][]='Version：' . php_basic;

    }

}