<?php
namespace common\models;



use yii\db\Query;

class BmRecord extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%BmRecord}}';
    }
    
    public function rules()
    {
        return [
			[['search'],'safe'],
        ];
    }
    
    public function getBmInfo(array $where,$field = '*')
    {
    	return self::find()->select($field)->joinWith('student')->where($where)->one();
    }
    
    
    
    public function pageList(array $data,$orderBy = 'verify asc,createTime desc,modifyTime desc')
    {
    	$this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
    	$query = self::find()->joinWith('student')->orderBy($orderBy);
    	if($this->load($data) && !empty($this->search)){
    		$query = $this->filterSearch($this->search,$query);
    	}
    	return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function filterSearch(array $search,Query $query)
    {
    	if(isset($search['gradeClass']) && !empty($search['gradeClass'])){
    		$query = $query->andWhere(['like',self::tableName().'.gradeClass',$search['gradeClass']]);
    	}
    	
    	if(isset($search['trueName']) && !empty($search['trueName'])){
    		$query = $query->andWhere(['like',Student::tableName().'.trueName',$search['trueName']]);
    	}

    	if(isset($search['sex']) && !empty($search['sex'])){
    		$query = $query->andWhere(Student::tableName().'.sex = :sex',[':sex'=>$search['sex']]);
    	}
    	
    	if(isset($search['isBest']) && !empty($search['isBest'])){
    		$query = $query->andWhere(Student::tableName().'.isBest = :isBest',[':isBest'=>$search['isBest']]);
    	}
    	
    	if(isset($search['nationCode']) && !empty($search['nationCode'])){
    		$query = $query->andWhere(Student::tableName().'.nationCode = :nationCode',[':nationCode'=>$search['nationCode']]);
    	}
    	
    	if(isset($search['startTime']) && !empty($search['startTime'])){
    		$query = $query->andWhere(self::tableName().'.createTime >= :startTime',[':startTime'=>strtotime($search['startTime'])]);
    	}
    	
    	if(isset($search['startTime']) && !empty($search['startTime'])){
    		$query = $query->andWhere(self::tableName().'.createTime <= :endTime',[':endTime'=>strtotime($search['endTime'])]);
    	}
    	
        if(isset($search['verify']) && is_numeric($search['verify'])){
        	$query = $query->andWhere(Student::tableName().'.verify = :verify',[':verify'=>$search['verify']]);
    	}
    	
    	if(isset($search['userId']) && is_numeric($search['userId'])){
    		$query = $query->andWhere(self::tableName().'.userId = :userId',[':userId'=>$search['userId']]);
    	}
    	
    	return $query;
    }
    
    
    public function getStudent()
    {
    	return $this->hasOne(Student::className(), ['userId'=>'userId']);
    }
}