<?php
namespace common\models;




use Yii;
use yii\db\ActiveQuery;

class Student extends BaseModel
{
    
    const STUDENT_VERIFY_NO  = 0;
    
    const STUDENT_VERIFY_STEP1 = 1;
    
    const STUDENT_VERIFY_STEP2= 2;
    
    const STUDENT_VERIFY_FINISH = 3;
    
    public $gradeClass;
    
    public $gradeClassId;
    
    
    public static $verify_texts = [
        self::STUDENT_VERIFY_NO     => '审核失败',
        self::STUDENT_VERIFY_STEP1  => '初审中',
        self::STUDENT_VERIFY_STEP2  => '终审中',
        self::STUDENT_VERIFY_FINISH => '审核完成',
    ];
    
    public static function tableName()
    {
        return '{{%Student}}';
    }
    
    public function rules()
    {
        return [
            ['userId','required','message'=>'用户ID不能为空','on'=>'add'],
            ['trueName','required','message'=>'姓名不能为空','on'=>'add'],
            ['sex','required','message'=>'性别不能为空','on'=>'add'],
            ['IDnumber','required','message'=>'身份证号码不能为空','on'=>'add'],
            ['birthday','required','message'=>'出生年月不能为空','on'=>'add'],
            ['nation','required','message'=>'名族不能为空','on'=>'add'],
            ['nationCode','required','message'=>'名族标识不能为空','on'=>'add'],
            ['city','required','message'=>'所在城市不能为空','on'=>'add'],
            ['phone','required','message'=>'手机号不能为空','on'=>'add'],
            ['company','required','message'=>'现工作单位不能为空','on'=>'add'],
            ['workYear','required','message'=>'工作年限不能为空','on'=>'add'],
            ['graduationSchool','required','message'=>'毕业学校不能为空','on'=>'add'],
            ['graduationMajor','required','message'=>'毕业专业不能为空','on'=>'add'],
            ['eduation','required','message'=>'学历不能为空','on'=>'add'],
            ['politicalStatus','required','message'=>'政治面貌不能为空','on'=>'add'],

            [['search','address','selfIntruduce','positionalTitles','avater'],'safe']
        ];
    }
    
    public static function add(array $data,Student $model)
    {
        $model->scenario = 'add';
        if($model->load($data) && $model->validate()){
            $model->userId = Yii::$app->user->id;
            if($model->save(false)){
                $bmRecord = new BmRecord();
                $bmRecord->userId = Yii::$app->user->id;
                $bmRecord->gradeClass = $model->gradeClass;
                $bmRecord->gradeClassId = $model->gradeClassId;
                $bmRecord->verify = 1;
                return $bmRecord->save(false);
            }
        }
        return false;
    }
    
    
    public static function del(Student $student)
    {
        $student->isDelete = 1;
        return $student->save(false);
    }
    
    public function pageList(array $data,$field = '*')
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()->select($field)->where(['isDelete'=>0])->orderBy('createTime desc,modifyTime desc');
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
        
        if(isset($search['isBest']) && !empty($search['isBest'])){
            $query = $query->andWhere('isBest = :isBest',[':isBest'=>$search['isBest']]);
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
        
        if(isset($search['userId']) && is_numeric($search['userId'])){
            $query = $query->andWhere('userId = :userId',[':userId'=>$search['userId']]);
        }
        return $query;
    }
    
    
}