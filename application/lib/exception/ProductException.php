<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：商品异常
 * Date：2019/7/15
 * Time：0:18
 * 努力前行！
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '请求的商品不存在,请检查参数';
    public $errorCode  = 20000;
}