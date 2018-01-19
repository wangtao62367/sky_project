<?php
namespace common\models;


use Yii;

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
        $webCfg = self::find()->all();
        $result = [];
        foreach ($webCfg as $val){
            $result[$val->name] = $val->value;
        }
        return $result;
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
        if(!empty($data['siteName']) && $data['siteName'] != $webCfgs['siteName']){
            self::updateAll(['value'=>$data['siteName']],['name'=>'siteName']);
        }
        if(!empty($data['keywords']) && $data['keywords'] != $webCfgs['keywords']){
            self::updateAll(['value'=>$data['keywords']],['name'=>'keywords']);
        }
        if(!empty($data['description']) && $data['description'] != $webCfgs['description']){
            self::updateAll(['value'=>$data['description']],['name'=>'description']);
        }
        if(is_numeric($data['status']) && $data['status'] != $webCfgs['status']){
            self::updateAll(['value'=>$data['status']],['name'=>'status']);
            if($data['status'] == 0 ){
                self::updateAll(['value'=>$data['closeReasons']],['name'=>'closeReasons']);
            }
        }
        if(!empty($_FILES)){
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