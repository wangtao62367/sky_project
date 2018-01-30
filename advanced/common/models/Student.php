<?php
namespace common\models;





use yii\db\ActiveQuery;

class Student extends BaseModel
{
    
    const STUDENT_VERIFY_ING = 0;
    
    const STUDENT_VERIFY_STEP1 = 1;
    
    const STUDENT_VERIFY_STEP2= 2;
    
    const STUDENT_VERIFY_NO = 3;
    
    public static $verify_texts = [
        self::STUDENT_VERIFY_ING   => '未审核',
        self::STUDENT_VERIFY_STEP1 => '审核中',
        self::STUDENT_VERIFY_STEP2 => '审核完成',
        self::STUDENT_VERIFY_NO    => '审核失败',
    ];
    
    public static function tableName()
    {
        return '{{%Student}}';
    }
    
    public function rules()
    {
        return [
            [['search'],'safe']
        ];
    }
    
    
    
    public static function del(Student $student)
    {
        $student->isDelete = 1;
        return $student->save(false);
    }
    
    public function pageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()->select([])->where(['isDelete'=>0])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data) && !empty($this->search)){
            $query = $this->filterSearch($this->search, $query);
        }
        $result = $this->query($query, $this->curPage, $this->pageSize);
        return $result;
    }
    
    public function filterSearch(array $search,ActiveQuery $query)
    {
        if(isset($search['trueName']) && !empty($search['trueName'])){
            $query = $query->andWhere(['like','trueName',$search['trueName']]);
        }
        if(isset($search['gradeClass']) && !empty($search['gradeClass'])){
            $query = $query->andWhere(['like','gradeClass',$search['gradeClass']]);
        }
        if(isset($search['sex']) && !empty($search['sex'])){
            $query = $query->andWhere('sex = :sex',[':sex'=>$search['sex']]);
        }
        
        if(isset($search['nationCode']) && !empty($search['nationCode'])){
            $query = $query->andWhere('nationCode = :nationCode',[':nationCode'=>$search['nationCode']]);
        }
        
        if(isset($search['startTime']) && !empty($search['startTime'])){
            $query = $query->andWhere('createTime >= :startTime',[':startTime'=>strtotime($search['startTime'])]);
        }
        
        if(isset($search['startTime']) && !empty($search['startTime'])){
            $query = $query->andWhere('createTime <= :endTime',[':endTime'=>strtotime($search['endTime'])]);
        }
        
        if(isset($search['verify']) && is_numeric($search['verify'])){
            $query = $query->andWhere('verify = :verify',[':verify'=>$search['verify']]);
        }
        return $query;
    }
    
    
}