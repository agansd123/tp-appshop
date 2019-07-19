<?php
/**
 * Create by PhpStorm
 * User ：Administrator
 * Data：2019/7/9
 * Time：17:48
 * 异常抛出
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{

    private $code;
    private $msg;
    private $errorCode;

    public function render(\Exception $exception)
    {
        if ($exception instanceof BaseException){
            //自定义异常响应
            $this->code = $exception->code;
            $this->msg = $exception->msg;
            $this->errorCode = $exception->errorCode;
        }else{
            //系统异常
            if (config('app_debug')){
                return parent::render($exception);
            }else{
                $this->code = 500;
                $this->msg = '内部服务器错误';
                $this->errorCode = 999;
                $this->recordErrorLog($exception);
            }

        }

        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()  //返回当前请求url
        ];

        return json($result,$this->code);
    }

    /**
     * 系统的默认日志已经关闭，只记录当前错误日志
     * @param \Exception $exception
     */
    private function recordErrorLog(\Exception $exception){

        Log::init([
            // 日志记录方式，内置 file socket 支持扩展
            'type'  => 'File',
            // 日志保存目录
            'path'  => LOG_PATH,
            // 日志记录级别
            'level' => ['error'],
        ]);

        Log::record($exception->getMessage(),'error');
    }
}