<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：只有用户可以访问的权限
 * Date：2019/7/22
 * Time：12:03
 * 努力前行！
 */

namespace app\api\behavior;

use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenGetException;

class NeedExclusiveScope
{
    public function run(){
        $scope = TokenService::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenGetException();
        }
    }
}