<?php
namespace backend\controllers;


use Yii;
use DateTime;
use common\controllers\CommonController;
/**
 * @name 阿里云管理
 * @author wangt
 *
 */
class AliossController extends CommonController
{
    
    /**
     * @desc 获取配置
     * @return boolean[]|string[]|number[]|number[][]|string[][]|unknown[][]|mixed[][]
     */
    public function actionManage()
    {
        $this->setResponseJson();
        $upload_param = Yii::$app->params['oss'];
        $id = $upload_param['akey'];
        $key= $upload_param['skey'];
        $host = $upload_param['host'];
        
        $now = time();
        $expire = 300; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = self::gmt_iso8601($end);
        
        $dir = 'upload/';
        
        //最大文件大小.用户可以自己设置
        $condition = [0=>'content-length-range', 1=>0, 2=>1024*1024*1024*1.5];
        $conditions[] = $condition;
        
        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = [0=>'starts-with', 1=>'$key', 2=>$dir];
        $conditions[] = $start;
        
        $arr = ['expiration'=>$expiration,'conditions'=>$conditions];
        
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        //$string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $base64_policy, $key, true));
        
        $response = [];
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        return [
            'success' => true,
            'message' =>'请求成功',
            'data' => $response,
            'code' => 10
        ];
    }
    
    private static function gmt_iso8601($time)
    {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
}