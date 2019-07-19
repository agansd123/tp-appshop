<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Date：2019/7/9
 * Time：17:54
 * 轮播图异常
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的banner不存在';
    public $errorCode  = 40000;
}