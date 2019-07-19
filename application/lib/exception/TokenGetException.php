<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：
 * Date：2019/7/17
 * Time：20:42
 * 努力前行！
 */

namespace app\lib\exception;


class TokenGetException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或者无效Token';
    public $errorCode  = 10001;
}