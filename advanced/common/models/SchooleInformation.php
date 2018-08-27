<?php
namespace common\models;



/**
* 学院基本信息管理
* @date: 2018年2月8日 上午9:22:10
* @author: wangtao
*/
class SchooleInformation extends BaseModel
{
    
    public static $typeDesc = [
        CategoryType::FZLC => '发展历程',
        CategoryType::SYFC => '亲切关怀',
        CategoryType::SZQK => '师资情况',
        CategoryType::XYJJ => '学院简介',
        CategoryType::XYDZ => '学院地址',
        CategoryType::ZZJG => '组织机构',
        
        CategoryType::ZKZX => '智库简介',
        
        CategoryType::WHXYJJ => '文化学院简介',
    ];
    
    public static  function tableName()
    {
        return '{{%SchooleInformation}}';
    }
    
    public function rules()
    {
        return [
            ['text','required','message'=>'内容不能为空','on'=>'edit'],
            //['adminId','default','value'=>Yii::$app->user->id]
        ];
    }
    
    
    public static function edit(array $data , SchooleInformation $model)
    {
        $model->scenario = 'edit';
        if($model->load($data) && $model->validate() ){
            return $model->save(false);
        }
        return false;
    }
    
}