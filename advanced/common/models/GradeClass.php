<?php
namespace common\models;


use Yii;
use yii\db\ActiveQuery;

/**
 * 班级
 * @author wangtao
 *
 */

class GradeClass extends BaseModel
{
    const GRADECLASS_DELETE = 1;
    const GRADECLASS_UNDELETE = 0;
    
    public static function tableName()
    {
        return '{{%GradeClass}}';    
    }
    
    public function rules()
    {
        return [
            ['className','required','message'=>'班级名称不能为空','on'=>['create','edit']],
            ['className', 'string','length'=>[2,20], 'tooLong'=>'班级名称长度为4-40个字符', 'tooShort'=>'班级名称长度为2-20个字','on'=>['create','edit']],
            ['classSize','required','message'=>'班级人数不能为空','on'=>['create','edit']],
            ['classSize','number','max'=>60,'min'=>5,'tooBig'=>'班级人数最多60人','tooSmall'=>'班级人数最少5人','on'=>['create','edit']],
            ['joinStartDate','required','message'=>'报名开始时间不能为空','on'=>['create','edit']],
            ['joinEndDate','required','message'=>'报名结束时间不能为空','on'=>['create','edit']],
            ['joinEndDate', 'compare', 'compareAttribute'=>'joinStartDate', 'operator' => '>=','message'=>'报名结束时间必须大于或等于开始时间','on'=>['create','edit']],
//             ['contact','required','message'=>'班级联络人不能为空','on'=>['create','edit']],
//             ['phone','required','message'=>'班级联络人手机号不能为空','on'=>['create','edit']],
//             ['phone','match','pattern'=>'/^[1][34578][0-9]{9}$/','message'=>'手机号无效','on'=>['create','edit']],
            
            ['openClassTime','required','message'=>'开班时间不能为空','on'=>['create','edit']],
            ['eduAdmin','required','message'=>'教务员不能为空','on'=>['create','edit']],
            ['eduAdminPhone','required','message'=>'教务员手机号不能为空','on'=>['create','edit']],
            ['eduAdminPhone','match','pattern'=>'/^[1][34578][0-9]{9}$/','message'=>'教务员手机号无效','on'=>['create','edit']],
            ['mediaAdmin','required','message'=>'多媒体管理员不能为空','on'=>['create','edit']],
            ['mediaAdminPhone','required','message'=>'多媒体管理员手机号不能为空','on'=>['create','edit']],
            ['mediaAdminPhone','match','pattern'=>'/^[1][34578][0-9]{9}$/','message'=>'多媒体管理员手机号无效','on'=>['create','edit']],
            ['openClassLeader','required','message'=>'出席开班时的院领导不能为空','on'=>['create','edit']],
            ['closeClassLeader','required','message'=>'出席结业时的院领导不能为空','on'=>['create','edit']],
            ['currentTeachs','required','message'=>'本院教师任课节数不能为空','on'=>['create','edit']],
            ['invitTeachs','required','message'=>'邀约教师任课节数不能为空','on'=>['create','edit']],
            ['currentTeachs','number','min'=>0,'message'=>'本院教师任课节数数据无效','on'=>['create','edit']],
            ['invitTeachs','number','min'=>0,'message'=>'邀约教师任课节数数据无效','on'=>['create','edit']],
            
            ['createAdminId','default','value'=>Yii::$app->user->id],
            [['curPage','pageSize','search','remarks'],'safe']
        ];    
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate() && $this->save(false)){
            return true;
        }
        return false;
    }
    
    public static function edit(array $data,GradeClass $gradeClassInfo)
    {
        $gradeClassInfo->scenario = 'edit';
        if($gradeClassInfo->load($data) && $gradeClassInfo->validate() && $gradeClassInfo->save(false)){
            return true;
        }
        return false;
    }
    
    public static function del(int $id,GradeClass $gradeClassInfo)
    {
        $gradeClassInfo->isDelete = self::GRADECLASS_DELETE;
        return $gradeClassInfo->save(false);
    }
    
    public function pageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $gradeClassQuery = self::find()->select([])->where(['isDelete'=>self::GRADECLASS_UNDELETE])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data)){
        	$gradeClassQuery = $this->filterSearch($this->search, $gradeClassQuery);
        }
        $list = $this->query($gradeClassQuery, $this->curPage, $this->pageSize);
        return $list;
    }
    
    public function filterSearch($search,ActiveQuery $query)
    {
    	if(!isset($search) || empty($search)){
    		return $query;
    	}
    	if(isset($search['className']) && !empty($search['className'])){
    		$query= $query->andWhere(['like','className',$search['className']]);
    	}
    	if(isset($search['classSize']) && !empty($search['classSize'])){
    		$query = $query->andWhere(['classSize'=>$search['classSize']]);
    	}
    	if(isset($search['admin']) && !empty($search['admin'])){
    		$query= $query->andWhere(['or',
    				['like','eduAdmin',$search['admin']],
    				['like','mediaAdmin',$search['admin']]
    		]);
    	}
    	if(isset($search['leader']) && !empty($search['leader'])){
    		$query= $query->andWhere(['or',
    				['like','openClassLeader',$search['leader']],
    				['like','closeClassLeader',$search['leader']]
    		]);
    	}
    	if(!empty($search['startTime'])){
    		$query = $query->andWhere('openClassTime >= :startTime',[':startTime'=>$search['startTime']]);
    	}
    	if(!empty($search['endTime'])){
    		$query = $query->andWhere('openClassTime <= :endTime',[':endTime'=>$search['endTime']]);
    	}
		return $query;
    }
    
}