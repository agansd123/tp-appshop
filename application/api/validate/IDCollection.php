<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：id组验证
 * Date：2019/7/14
 * Time：17:24
 * 努力前行！
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的多个正整数'
    ];


}