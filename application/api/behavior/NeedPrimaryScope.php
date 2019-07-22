<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：需要用户和管理员都可以访问的权限
 * Date：2019/7/22
 * Time：11:51
 * 努力前行！
 */

namespace app\api\behavior;


use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenGetException;

class NeedPrimaryScope
{
    public function run(){
        $scope = TokenService::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope>= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenGetException();
        }
    }
}