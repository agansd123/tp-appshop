<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：数量
 * Date：2019/7/15
 * Time：0:06
 * 努力前行！
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15'
    ];
}