<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：分类异常
 * Date：2019/7/15
 * Time：10:31
 * 努力前行！
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定的类目不存在，请检查参数';
    public $errorCode  = 50000;
}