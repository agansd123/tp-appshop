<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：
 * Date：2019/7/17
 * Time：19:23
 * 努力前行！
 */

namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenGetException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.appid');
        $this->wxAppSecret = config('wx.secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppID,$this->wxAppSecret ,$this->code);
    }

    /**
     * 获取token
     * @return mixed
     * @throws Exception
     * @throws WeChatException
     */
    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if (empty($wxResult)){
            throw new Exception('获取session_key及openID时发生异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if ($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }


    /**
     * 颁发令牌
     * @param $wxResult
     * @return string
     * @throws TokenGetException
     */
    private function grantToken($wxResult){
        $openid = $wxResult['openid'];
        $user = UserModel::getByopenID($openid);
        if ($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }


    /**
     * 保存至缓存，token为key，缓存值为value
     * @param $cachedValue
     * @return string
     * @throws TokenGetException
     */
    private function saveToCache($cachedValue){
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $result = cache($key,$value,$expire_in);
        if(!$result){
            throw new TokenGetException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    /**
     * 拼装缓存值
     * @param $wxResult
     * @param $uid
     * @return mixed
     */
    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User; //权限域
        return $cachedValue;
    }


    /**
     * 生成会员
     * @param $openid
     * @return mixed
     */
    private function newUser($openid){
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

    /**
     * 异常处理
     * @param $wxResult
     * @throws WeChatException
     */
    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }
}