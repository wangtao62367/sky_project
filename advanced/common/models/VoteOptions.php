<?php
namespace common\models;


use Yii;

class VoteOptions extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%VoteOptions}}';
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
        return Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['text','voteId','sorts','createTime','modifyTime'], $data)->execute();
    }
    
    public static function getOptionsByVoteId(int $voteId)
    {
        return self::find()->select(['text','voteId','counts','sorts','createTime','modifyTime'])->where('voteId = :voteId',[':voteId'=>$voteId])->asArray()->all();
    }
}