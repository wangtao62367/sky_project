<?php
namespace common\models;


use Yii;
use OSS\OssClient;

class Adv extends BaseModel
{
    
    public $oldImgs;
    
    public static $position_text = [
        'right' => '右侧',
        'left'  => '左侧',
        'top'   => '顶部',
        'bottom'=> '底部' 
    ];
    
    public static function tableName()
    {
        return '{{%Adv}}';
    }
    
    public function rules()
    {
        return [
            ['advs','required','message'=>'广告词不能为空','on'=>['add','edit']],
            ['advs','string','length'=>[2,10],'tooLong'=>'广告词长度为4-20个字符', 'tooShort'=>'广告词长度为2-10个字','message'=>'广告词限制长度为2-10字','on'=>['add','edit']],
            ['position','required','message'=>'广告位置不能为空','on'=>['add','edit']],
            ['position','unique','message'=>'每个位置只能有一个广告','on'=>['add','edit']],
            [['link','imgs','status'],'safe']
        ];
    }
    
    public function pageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()->orderBy('createTime desc,modifyTime desc');
        
        $result = $this->query($query, $this->curPage, $this->pageSize);
        return $result;
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate()){
            return $this->save(false);
        }
        return true;
    }
    
    public static function edit(array $data,Adv $adv)
    {
        $adv->scenario = 'edit';
        if($adv->load($data) && $adv->validate()){
            return $adv->save(false);
        }
        return true;
    }
    
    public static function del(Adv $adv)
    {
        $imgs = $adv->imgs;
        $imgsBlock = str_replace(Yii::$app->params['oss']['host'], '', $imgs);
        if((bool)$adv->delete()){
            if(!empty($imgsBlock)){
                $ossClient = new OssClient(Yii::$app->params['oss']['akey'], Yii::$app->params['oss']['skey'], Yii::$app->params['oss']['endpoint'], false);
                $ossClient->deleteObject($imgsBlock, ltrim($imgsBlock,'/'));
            }
        }
    }
    
}