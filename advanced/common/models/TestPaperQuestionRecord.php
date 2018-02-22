<?php
namespace common\models;


use Yii;

class TestPaperQuestionRecord extends BaseModel
{
	
	
	public static  function tableName()
	{
		return '{{%TestPaperQuestionRecord}}';
	}
	
	
	public function bateAdd(array $data)
	{
		return Yii::$app->db->createCommand()->batchInsert(self::tableName(), [
				'userId',
				'paperId',
				'questId',
				'userAnswer',
				'userAnswerOpt',
				'anwserMark',
				'isRight'
		], $data)->execute();
	}
}