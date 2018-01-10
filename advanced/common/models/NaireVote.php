<?php
namespace common\models;


use Yii;

class NaireVote extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%NaireVote}}';
    }
    
    public function getVotes()
    {
        return $this->hasOne(Vote::className(), ['id'=>'voteId']);
    }
    
    
    public static function batchAdd(array $data)
    {
        return Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['naireId','voteId','sorts'], $data)->execute();
    }
}