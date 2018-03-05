<?php
namespace common\models;




use yii\db\ActiveQuery;

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
	
	
	public function getList(array $data)
	{
	    $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
	    $query = $this->getQuery();
	    if($this->load($data) && !empty($this->search)){
	       $query = $this->filterSearch($this->search,$query);
	    }
	    
	    return $this->query($query,$this->curPage,$this->pageSize);
	}
	
	private function getQuery()
	{
	    return self::find()->select([
	        'id',
	        'userId',
	        'account',
	        'paperId',
	        'anwserMark',
	        'scores',
	        'rightCount',
	        'rightScores',
	        'wrongCount',
	        'wrongScores',
	        'createTime',
	        'modifyTime'
	    ])->orderBy('modifyTime DESC');
	}
	
	private function filterSearch(array $search,ActiveQuery $query)
	{
	    if(isset($search['userId']) && is_numeric($search['userId'])){
	        $query = $query->andWhere(['userId'=>$search['userId']]);
	    }
	    
	    if(isset($search['account']) && !empty($search['account'])){
	        $query = $query->andWhere(['like','account',$search['account']]);
	    }
	    
	    if(isset($search['paperId']) && is_numeric($search['paperId'])){
	        $query = $query->andWhere(['paperId'=>$search['paperId']]);
	    }
	    
	    return $query;
	}
}