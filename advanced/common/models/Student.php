<?php
namespace common\models;





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
        if($this->load($data)){
            if(!empty($this->search)){
                if(isset($this->search['trueName']) && !empty($this->search['trueName'])){
                    $query = $query->andWhere(['like','trueName',$this->search['trueName']]);
                }
                if(isset($this->search['sex']) && !empty($this->search['sex'])){
                    $query = $query->andWhere('sex = :sex',[':sex'=>$this->search['sex']]);
                }
                if(isset($this->search['verify']) && is_numeric($this->search['verify'])){
                    $query = $query->andWhere('verify = :verify',[':verify'=>$this->search['verify']]);
                }
            }
        }
        $result = $this->query($query, $this->curPage, $this->pageSize);
        return $result;
    }
    
    
}