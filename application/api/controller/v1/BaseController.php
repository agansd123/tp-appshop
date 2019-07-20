<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：
 * Date：2019/7/20
 * Time：21:22
 * 努力前行！
 */

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    /**
     * 权限验证，前置操作
     * @throws \app\lib\exception\ForbiddenException
     * @throws \app\lib\exception\TokenGetException
     * @throws \think\Exception
     */
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }
}