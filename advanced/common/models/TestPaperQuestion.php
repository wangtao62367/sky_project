<?php
namespace common\models;


use Yii;

class TestPaperQuestion extends BaseModel
{
	
	public static function tableName()
	{
		return '{{%TestPaperQuestion}}';
	}
	
	public function getQuestions()
	{
	    return $this->hasOne(Question::className(), ['id'=>'questId']);
	}
	
	public static function batchAdd(array $data)
	{
		Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['paperId','questId','score','sorts'], $data)->execute();
	}
}