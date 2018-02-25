<?php
namespace frontend\logic;


use Yii;
use common\models\TestPaperQuestionRecord;
use common\models\Question;
use common\models\TestPaperQuestion;
use common\models\TestPaperUserStatistics;
use common\models\VoteOptions;
use yii\db\Expression;
use common\models\VoteUser;

class StudentLogic
{
	
	public function submitNaire(array $data)
	{
		$user = Yii::$app->user->identity;
		$naireId = $data['naireId'];
		
		$voteUserParams = [];
		
		foreach ($data['userAnswers'] as $answer){
			
			$voteOptStr = trim($answer['userAnswer'],'-');
			$voteOptArr = explode('-', $voteOptStr);
			foreach ($voteOptArr as $optId){
				VoteOptions::updateAll([
					'counts' => new Expression('counts + 1'),
					'modifyTime' => TIMESTAMP,
				],['id'=>$optId,'voteId'=>$answer['questId']]);
				
				$voteUserParams[] = [
					'userId' => $user->id,
					'naireId'=> $naireId,
					'voteId' => $answer['questId'],
					'optionsId' => $optId,
					'createTime' => TIMESTAMP
				];
			}
		}
		if(!empty($voteUserParams)){
			Yii::$app->db->createCommand()->batchInsert(VoteUser::tableName(), ['userId','naireId','voteId','optionsId','createTime'], $voteUserParams)->execute();
		}
		return true;
	}
    
	public function submitAnswer(array $data)
	{
		$user = Yii::$app->user->identity;
		$paperId = $data['paperId'];
		
		$recordParams = [];
		$statisticsParams = [];
		$scores = 0;
		$rightCount = 0;
		$rightScores = 0;
		$wrongCount = 0;
		$wrongScores = 0;
		$anwserMark = uniqid();
		foreach ($data['userAnsers'] as $answer){
			$isRight = 0;
			$rightAnswer = Question::find()->select(['answer'])->where(['id'=>$answer['questId']])->one()->answer;
			$testPaperQuestion = TestPaperQuestion::find()->where(['paperId'=>$paperId,'questId'=>$answer['questId']])->one();
			$scores += $testPaperQuestion->score;
			if($answer['userAnswer'] == $rightAnswer){
				$isRight = 1;
				$rightCount ++;
				$rightScores += $testPaperQuestion->score;
			}else{
				$wrongCount ++;
				$wrongScores += $testPaperQuestion->score;
			}
			
			$recordParams[] = [
					'userId' => $user->id,
					'paperId' => $paperId,
					'questId' => $answer['questId'],
					'userAnswer' => $answer['userAnswer'],
					'userAnswerOpt' => isset($answer['userAnswerOpt']) ? serialize($answer['userAnswerOpt']): '',
					'anwserMark' => $anwserMark,
					'isRight'   => $isRight
			];
		}
		$statisticsParams = [
				'userId' => $user->id,
				'account' => $user->account,
				'paperId' => $paperId,
				'anwserMark' => $anwserMark,
				'scores' => $scores,
				'rightCount' => $rightCount,
				'rightScores' => $rightScores,
				'wrongCount' => $wrongCount,
				'wrongScores' => $wrongScores,
		];
		
		$testPaperQuestionRecord = new TestPaperQuestionRecord();
		$TestPaperUserStatistics = new TestPaperUserStatistics();
		//记录答题记录表
		if($testPaperQuestionRecord->bateAdd($recordParams) && 
				$TestPaperUserStatistics->add(['TestPaperUserStatistics'=>$statisticsParams])){
			return true;
		}
		return false;
	}
}