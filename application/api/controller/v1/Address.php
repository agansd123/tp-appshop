<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Operation ：地址填写
 * Date：2019/7/18
 * Time：17:40
 * 努力前行！
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenGetException;
use app\lib\exception\UserException;
use think\Controller;

class Address extends Controller
{

    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createorupdateaddress'] //方法名称不可使用大写,字母对应即可
    ];

    /**
     * 权限验证，前置操作
     * @return bool
     * @throws ForbiddenException
     * @throws TokenGetException
     * @throws \think\Exception
     */
    protected function checkPrimaryScope(){
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

    /**
     * 新增或者更新会员地址信息
     * @return \think\response\Json
     * @throws UserException
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenGetException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate->goCheck();

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if (!$user){
            throw new UserException();
        }

        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if (!$userAddress){
            $user->address()->save($dataArray);//添加
        }else{
            $user->address->save($dataArray);//更新
        }

        return json(new SuccessMessage(),201);
    }
}