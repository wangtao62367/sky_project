<?php
namespace common\models;


use Yii;

class VoteOptions extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%voteoptions}}';
    }
    
    public function rules()
    {
        return [
            
        ];
    }
    /**
     * 批量添加
     * @param array $data
     * @return number
     */
    public function batchAdd(array $data)
    {
        return Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['text','voteId','createTime','modifyTime'], $data)->execute();
    }
}