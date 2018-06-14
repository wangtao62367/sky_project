<?php
namespace common\models;


use Yii;
use yii\db\ActiveQuery;
use common\publics\MyHelper;

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
            //['classSize','required','message'=>'班级人数不能为空','on'=>['create','edit']],
            //['classSize','number','max'=>60,'min'=>5,'tooBig'=>'班级人数最多60人','tooSmall'=>'班级人数最少5人','on'=>['create','edit']],
            ['joinStartDate','required','message'=>'报名开始时间不能为空','on'=>['create','edit']],
            ['joinEndDate','required','message'=>'报名结束时间不能为空','on'=>['create','edit']],
            ['joinEndDate', 'compare', 'compareAttribute'=>'joinStartDate', 'operator' => '>=','message'=>'报名结束时间必须大于或等于开始时间','on'=>['create','edit']],

            ['openClassTime','required','message'=>'开班时间不能为空','on'=>['create','edit']],
            ['closeClassTime','required','message'=>'结业时间不能为空','on'=>['create','edit']],
            ['closeClassTime', 'compare', 'compareAttribute'=>'openClassTime', 'operator' => '>=','message'=>'结业时间必须大于或等于开班时间','on'=>['create','edit']],
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
            
            ['periods','required','message'=>'班级期数不能为空','on'=>['create','edit']],
            ['periods','number','min'=>1,'message'=>'班级期数数据无效','on'=>['create','edit']],
            
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
    
    public function export(array $data)
    {
        $query= self::find()->select([])->where(['isDelete'=>self::GRADECLASS_UNDELETE])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data)){
            $query= $this->filterSearch($this->search, $query);
        }
        $result = $query->limit(1000)->asArray()->all();
        /* if(empty($result)){
            return false;
        } */
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objSheet->setTitle('班级列表');
        $objSheet->setCellValue('A1','序号')->setCellValue('B1','班级名称')->setCellValue('C1','班级人数')->setCellValue('D1','报名时间')
        ->setCellValue('E1','开班时间')->setCellValue('F1','结业时间')->setCellValue('G1','教务员')->setCellValue('H1','教务员电话')->setCellValue('I1','媒体管理员')
        ->setCellValue('J1','媒体管理员电话')->setCellValue('K1','开班出席领导')->setCellValue('L1','结业出席领导')->setCellValue('M1','本院教师任课节数')
        ->setCellValue('N1','邀约教师任课节数')->setCellValue('O1','创建时间')->setCellValue('P1','修改时间');
        
        //设置填充的样式和背景色
        $colTitle = $objSheet->getStyle('A1:P1');
        $colTitle->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $colTitle->getFill()->getStartColor()->setARGB('b6cad2');
        $colTitle->getFont()->setBold(true);
        $colTitle->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        $colTitle->getFont()->setSize(12);
        
        //设置行高
        $objSheet->getDefaultRowDimension()->setRowHeight(24);
        //固定第一行
        $objSheet->freezePane('A2');
        
        //内容宽度
        $objSheet->getColumnDimension('A')->setWidth(20);
        $objSheet->getColumnDimension('B')->setWidth(40);
        $objSheet->getColumnDimension('C')->setWidth(10);
        $objSheet->getColumnDimension('D')->setWidth(20);
        $objSheet->getColumnDimension('E')->setWidth(20);
        $objSheet->getColumnDimension('F')->setWidth(20);
        $objSheet->getColumnDimension('G')->setWidth(20);
        $objSheet->getColumnDimension('H')->setWidth(20);
        $objSheet->getColumnDimension('I')->setWidth(20);
        $objSheet->getColumnDimension('J')->setWidth(25);
        $objSheet->getColumnDimension('K')->setWidth(25);
        $objSheet->getColumnDimension('L')->setWidth(25);
        $objSheet->getColumnDimension('M')->setWidth(25);
        $objSheet->getColumnDimension('N')->setWidth(20);
        $objSheet->getColumnDimension('O')->setWidth(20);
        $objSheet->getColumnDimension('P')->setWidth(20);
        
        $num = 2;
        foreach ($result as $val){
            $objSheet->setCellValue('A'.$num,$val['id'])->setCellValue('B'.$num,$val['className'])->setCellValue('C'.$num,$val['classSize'])->setCellValue('D'.$num,$val['joinStartDate'].'~'.$val['joinEndDate'])
            ->setCellValue('E'.$num,$val['openClassTime'])->setCellValue('F'.$num,$val['closeClassTime'])->setCellValue('G'.$num,$val['eduAdmin'])->setCellValue('H'.$num,$val['eduAdminPhone'])
            ->setCellValue('I'.$num,$val['mediaAdmin'])->setCellValue('J'.$num,$val['mediaAdminPhone'])->setCellValue('K'.$num,$val['openClassLeader'])
            ->setCellValue('L'.$num,$val['closeClassLeader'])->setCellValue('M'.$num,$val['currentTeachs'])->setCellValue('N'.$num,$val['invitTeachs'])
            ->setCellValue('O'.$num,MyHelper::timestampToDate($val['createTime']))->setCellValue('P'.$num,MyHelper::timestampToDate($val['modifyTime']));
            $num ++;
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser('班级列表.xlsx');
        $objWriter->save('php://output');
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
    	
    	if(!empty($search['validdate'])){
    	    $query = $query->andWhere('joinEndDate >= :date',[':date'=>$search['validdate']]);
    	}
		return $query;
    }
    
}