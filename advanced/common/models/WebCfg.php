<?php
namespace common\models;


use Yii;
use yii\base\Exception;
use common\publics\ImageUpload;

class WebCfg extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%WebCfg}}';
    }
    
    public function rules()
    {
        return [];
    }
    
    
    public static function getWebCfg()
    {
        $webCfg = self::find()->select(['name','value'])->all();
        $result = [];
        foreach ($webCfg as $val){
            $result[$val->name] = $val->value;
        }
        return $result;
    }
    
    public static function saveWatermarkCfg($data, $webCfg)
    {
        //文字水印
        if($data['watermarkCate'] == 'text'){
            
            if(empty($data['watermarkContent']) || empty($data['watermarkTextFont']) 
                || empty($data['watermarkTextColor'] || empty($data['watermarkPosition']))){
                throw new Exception('参数错误');
            }
            if($data['watermarkContent'] != $webCfg['watermarkContent']){
                self::updateAll(['value'=>$data['watermarkContent']],['name'=>'watermarkContent']);
            }
            if($data['watermarkTextFont'] != $webCfg['watermarkTextFont']){
                self::updateAll(['value'=>$data['watermarkTextFont']],['name'=>'watermarkTextFont']);
            }
            if($data['watermarkTextColor'] != $webCfg['watermarkTextColor']){
                self::updateAll(['value'=>$data['watermarkTextColor']],['name'=>'watermarkTextColor']);
            }
            
            
        }else{ //图片水印
            if(!empty($_FILES)){
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*30,
                    'imagePath'    => 'watermark',
                    'isWatermark'  => false
                ]);
                $result = $upload->Upload('file');
                $imageName = Yii::$app->params['oss']['host'].$result;
                self::updateAll(['value'=>$imageName],['name'=>'watermarkContent']);
                if(!empty($data['oldwaterImage']) && strripos($data['oldwaterImage'], Yii::$app->params['oss']['host']) !== false ){
                    $ossBlock = str_replace(Yii::$app->params['oss']['host'], '', $data['oldwaterImage']);
                    $upload->deleteImage($ossBlock);
                }
        
            }
        }
        
        if($data['watermarkPosition'] != $webCfg['watermarkPosition']){
            self::updateAll(['value'=>$data['watermarkPosition']],['name'=>'watermarkPosition']);
        }
        self::updateAll(['value'=>$data['watermarkCate']],['name'=>'watermarkCate']);
        return true;
    }
    
    
    public static function saveWebCfg(array $data,array $webCfgs)
    {
        if($data['status'] == 0 && empty($data['closeReasons'])){
            Yii::$app->session->setFlash('error','关闭网站，必须填写关闭理由');
            return false;
        }
        if(is_numeric($data['status']) && $data['status'] != $webCfgs['status']){
            self::updateAll(['value'=>$data['status']],['name'=>'status']);
            self::updateAll(['value'=>$data['closeReasons']],['name'=>'closeReasons']);
        }
        
        if(!empty($data['siteName']) && $data['siteName'] != $webCfgs['siteName']){
            self::updateAll(['value'=>$data['siteName']],['name'=>'siteName']);
        }
        if(!empty($data['siteTitle']) && $data['siteTitle'] != $webCfgs['siteTitle']){
            self::updateAll(['value'=>$data['siteTitle']],['name'=>'siteTitle']);
        }
        if(!empty($data['siteName2']) && $data['siteName2'] != $webCfgs['siteName2']){
            self::updateAll(['value'=>$data['siteName2']],['name'=>'siteName2']);
        }
        if(!empty($data['keywords']) && $data['keywords'] != $webCfgs['keywords']){
            self::updateAll(['value'=>$data['keywords']],['name'=>'keywords']);
        }
        if(!empty($data['description']) && $data['description'] != $webCfgs['description']){
            self::updateAll(['value'=>$data['description']],['name'=>'description']);
        }
        if(!empty($data['copyRight']) && $data['copyRight'] != $webCfgs['copyRight']){
        	self::updateAll(['value'=>$data['copyRight']],['name'=>'copyRight']);
        }
        if(!empty($data['technicalSupport']) && $data['technicalSupport'] != $webCfgs['technicalSupport']){
        	self::updateAll(['value'=>$data['technicalSupport']],['name'=>'technicalSupport']);
        }
        
        if(!empty($data['recordNumber']) && $data['recordNumber'] != $webCfgs['recordNumber']){
            self::updateAll(['value'=>$data['recordNumber']],['name'=>'recordNumber']);
        }
        
        if(!empty($data['address']) && $data['address'] != $webCfgs['address']){
        	self::updateAll(['value'=>$data['address']],['name'=>'address']);
        }
        if(!empty($data['postCodes']) && $data['postCodes'] != $webCfgs['postCodes']){
        	self::updateAll(['value'=>$data['postCodes']],['name'=>'postCodes']);
        }
        if(is_numeric($data['status']) && $data['status'] != $webCfgs['status']){
            self::updateAll(['value'=>$data['status']],['name'=>'status']);
            if($data['status'] == 0 ){
                self::updateAll(['value'=>$data['closeReasons']],['name'=>'closeReasons']);
            }
        }
        if( !empty($_FILES) && isset($_FILES['files']) && !empty($_FILES['files']) ){
            $logoFile = $_FILES['files'];
            $oldFile = $webCfgs['logo'];
            $result = Photo::upload($logoFile,$oldFile);
            if($result['success']){
                self::updateAll(['value'=>$result['fileFullName']],['name'=>'logo']);
            }
            
        }
        return true;
    }
    
}