<?php
namespace common\models;




use Yii;
use yii\db\ActiveQuery;
use common\publics\ImageUpload;

class Profile extends BaseModel
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
    
    //政治面貌
    public static $politicalStatusArr = [
    	'01' => '党员',
    	'02' => '团员',
    	'03' => '群众',
    ];
    //学历
    public static $eduationArr = [
    	'01' => '小学',
    	'02' => '初中',
    	'03' => '高中',
    	'04' => '大专',
    	'05' => '本科',
    	'06' => '硕士',
    	'07' => '博士',
    ];
    
    public static function tableName()
    {
        return '{{%Profile}}';
    }
    
    public function rules()
    {
        return [
            ['trueName','required','message'=>'姓名不能为空','on'=>['bm','add','edit']],
            ['sex','required','message'=>'性别不能为空','on'=>['bm','add','edit']],
            ['IDnumber','required','message'=>'身份证号码不能为空','on'=>['bm','add','edit']],
            ['IDnumber','match','pattern'=>'/^\d{6}(19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/','message'=>'身份证号码无效','on'=>['bm','add','edit']],
            ['birthday','required','message'=>'出生年月不能为空','on'=>['bm','add','edit']],
            //['nation','required','message'=>'民族不能为空','on'=>'add'],
            ['nationCode','required','message'=>'民族不能为空','on'=>['bm','add','edit']],
            ['city','required','message'=>'所在城市不能为空','on'=>['bm','add','edit']],
            ['phone','required','message'=>'手机号不能为空','on'=>['bm','add']],
            ['phone','match','pattern'=>'/^[1][34578][0-9]{9}$/','message'=>'手机号无效','on'=>['bm','add']],
            ['company','required','message'=>'现工作单位不能为空','on'=>['bm','add','edit']],
            ['workYear','required','message'=>'工作年限不能为空','on'=>['bm','add','edit']],
        	['workYear', 'compare', 'compareValue' => 0, 'operator' => '>=','message'=>'工作年限必须正整数'],
            ['graduationSchool','required','message'=>'毕业学校不能为空','on'=>['bm','add','edit']],
            ['graduationMajor','required','message'=>'毕业专业不能为空','on'=>['bm','add','edit']],
            ['eduationCode','required','message'=>'学历不能为空','on'=>['bm','add','edit']],
            ['politicalStatusCode','required','message'=>'政治面貌不能为空','on'=>['bm','add','edit']],

            [['search','address','selfIntruduce','positionalTitles','avater'],'safe']
        ];
    }
    
    public static function add(array $data,Profile $model,$oprate = 'add')
    {
        $model->scenario = $oprate;
        if($model->load($data) && $model->validate()){
            $model->userId = Yii::$app->user->id;
            $model->nation = Yii::$app->params['nations'][$model->nationCode];
            $model->politicalStatus = self::$politicalStatusArr[$model->politicalStatusCode];
            $model->eduation= self::$eduationArr[$model->eduationCode];
            //先上传图片 再写数据
            if(isset($_FILES['avater']) && !empty($_FILES['avater']) && !empty($_FILES['avater']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*50,
                    'imagePath'    => 'avater',
                    'isWatermark'  => false,
                ]);
                $result = $upload->Upload('avater');
                $imageName = Yii::$app->params['oss']['host'].$result;
                //并且删除老的头像
                if(!empty($model->avater)){
                    $block = str_replace(Yii::$app->params['oss']['host'], '', $model->avater);
                    $upload->deleteImage($block);
                }
                $model->avater = $imageName;
            }
            return $model->save(false);
            
        }
        return false;
    }
    
    
    public static function del(Profile $student)
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
        /* if(isset($search['gradeClass']) && !empty($search['gradeClass'])){
            $query = $query->andWhere(['like','gradeClass',$search['gradeClass']]);
        } */
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
        
        /* if(isset($search['verify']) && is_numeric($search['verify'])){
            $query = $query->andWhere('verify = :verify',[':verify'=>$search['verify']]);
        } */
        
        if(isset($search['userId']) && is_numeric($search['userId'])){
            $query = $query->andWhere('userId = :userId',[':userId'=>$search['userId']]);
        }
        return $query;
    }
    
    
}