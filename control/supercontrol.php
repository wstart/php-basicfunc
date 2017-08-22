<?php

/**
 * Created by PhpStorm.
 * User: wstart
 * Date: 2017/8/22
 * Time: 上午11:31
 */
abstract class supercontrol
{
    /**
     * 输出函数
     * @var array
     */
    public $outputArray;

    public function __construct()
    {
        global $outputArray;
        $this->outputArray = $outputArray;
    }

    /**
     * 认证函数
     * @return mixed
     */
    abstract protected function authority();


    /**
     * @return 执行函数
     */
    abstract protected function run();


}