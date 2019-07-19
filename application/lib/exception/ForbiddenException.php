<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：禁止访问
 * Date：2019/7/19
 * Time：1:10
 * 努力前行！
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不足';
    public $errorCode  = 10001;
}