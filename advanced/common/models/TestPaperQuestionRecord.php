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
	
	
	public function getAnwserInfo($paperid,$userid,$mark)
	{
	    return self::find()->select([])
	    ->joinWith('paperquestion')
	    ->with([
	        'question' => function($query) {
	           $query->joinWith('options');;
	        },
	    ])->where([self::tableName().'.paperId'=>$paperid,'userId'=>$userid,'anwserMark'=>$mark])->all();
	}
	
	
	public function getQuestion()
	{
	    return $this->hasOne(Question::className(), ['id'=>'questId']);
	}
	
	public function getPaperquestion()
	{
	    return $this->hasOne(TestPaperQuestion::className(), ['questId'=>'questId','paperId'=>'paperId']);
	}
}