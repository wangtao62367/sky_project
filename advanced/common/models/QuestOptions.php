<?php
namespace common\models;


use Yii;

class QuestOptions extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%QuestOptions}}';
    }
    
    public function rules()
    {
        return [
            
        ];
    }
    
    public static function batchAdd(array $data,int $questId)
    {
        if(empty($data)) return  false;
        self::deleteAll('questId = :questId',[':questId'=>$questId]);
        $params = [];
        foreach ($data as $k=>$v){
            $params [] = [
                'questId' => $questId,
                'opt'     => $v['opt'],
                'optImg'  => $v['optImg'],
                'sorts'   => $k
            ];
        }
        return (bool)Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['questId','opt','optImg','sorts'], $params)->execute();
    }
}