<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：
 * Date：2019/7/17
 * Time：22:05
 * 努力前行！
 */

namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenGetException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * 生成Token
     * @return string
     */
    protected static function generateToken(){
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    /**
     * 返回对应key值
     * @param $key  uid|scope|openid|session_key
     * @return mixed
     * @throws Exception
     * @throws TokenGetException
     */
    public static function getCurrentTokenVar($key){
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars){
            throw new TokenGetException();
        } else{
            if (!is_array($vars)){ //兼容redis
                $vars = json_decode($vars,true);
            }
            if (array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception('尝试获取的token变量不存在');
            }
        }
    }

    /**
     * 获取uid
     * @return mixed
     * @throws Exception
     * @throws TokenGetException
     */
    public static function getCurrentUid(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /**
     * 检测是否当前用户操作
     */
    public static function isValidOperate($checkedUID){
        if (!$checkedUID){
            throw new Exception('检测UID时必须传入一个被检测UID');
        }

        $currentOperateUID = self::getCurrentUid();
        if ($currentOperateUID == $checkedUID){
            return true;
        }

        return false;
    }

}