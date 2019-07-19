<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Data：ID参数必须为正整数
 * Time：1:04
 * 努力前行！
 */

namespace app\api\validate;


class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'id参数必须为正整数'
    ];

}