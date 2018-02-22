<?php
namespace common\models;




class TestPaperUserStatistics extends BaseModel
{
	
	public static function tableName()
	{
		return '{{%TestPaperUserStatistics}}';
	}
	
	public function rules()
	{
		return [
			[['userId','account','paperId','anwserMark','scores','rightCount','rightScores','wrongCount','wrongScores'],'required','on'=>'add'],
		];
	}
	
	public function add(array $data)
	{
		$this->scenario = 'add';
		if($this->load($data) && $this->validate()){
			return $this->save(false);
		}
		return false;
	}
}