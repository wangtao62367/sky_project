<?php
namespace common\models;



use yii\db\Query;

class BmRecord extends BaseModel
{
    
    const STUDENT_VERIFY_NO  = 0;
    
    const STUDENT_VERIFY_STEP1 = 1;
    
    const STUDENT_VERIFY_STEP2= 2;
    
    const STUDENT_VERIFY_FINISH = 3;
    
    public static $verify_texts = [
        self::STUDENT_VERIFY_NO     => '审核失败',
        self::STUDENT_VERIFY_STEP1  => '初审中',
        self::STUDENT_VERIFY_STEP2  => '终审中',
        self::STUDENT_VERIFY_FINISH => '审核完成',
    ];
    
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
    /**
     * 导出在线报名信息
     * @param array $data
     */
    public function exportVerify(array $data,$verify)
    {
        $query = self::find()->joinWith(['student','gradeclass'])->orderBy('verify asc,modifyTime desc,createTime desc');
        if($this->load($data) && !empty($this->search)){
            $query = $this->filterSearch($this->search,$query);
        }
        $result = $query->all();
        if(empty($result)){
            return false;
        }
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        //水平垂直方向居中
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
        $objSheet->setTitle('学员列表');
        
        //内容宽度
        $objSheet->getColumnDimension('A')->setWidth(20);
        $objSheet->getColumnDimension('B')->setWidth(40);
        $objSheet->getColumnDimension('C')->setWidth(20);
        $objSheet->getColumnDimension('D')->setWidth(10);
        $objSheet->getColumnDimension('E')->setWidth(20);
        $objSheet->getColumnDimension('F')->setWidth(20);
        
        $objTitle = $objSheet->setCellValue('A1','姓名')->setCellValue('B1','报名班级')->setCellValue('C1','联系电话')->setCellValue('D1','性别')->setCellValue('E1','报名时间')
        ->setCellValue('F1','审核状态');
        if($verify == self::STUDENT_VERIFY_STEP2){
            $objTitle->setCellValue('G1','初审结果');
            $objSheet->getColumnDimension('G')->setWidth(60);
        }elseif ($verify == self::STUDENT_VERIFY_FINISH){
            $objTitle->setCellValue('G1','初审结果')->setCellValue('H1','终审结果');
            $objSheet->getColumnDimension('G')->setWidth(60);
            $objSheet->getColumnDimension('H')->setWidth(60);
        }elseif ($verify == self::STUDENT_VERIFY_NO){
            $objTitle->setCellValue('G1','初审结果')->setCellValue('H1','终审结果');
            $objSheet->getColumnDimension('G')->setWidth(60);
            $objSheet->getColumnDimension('H')->setWidth(60);
        }
        
        //设置填充的样式和背景色
        $colTitle = $objSheet->getStyle('A1:H1');
        $colTitle->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $colTitle->getFill()->getStartColor()->setARGB('b6cad2');
        $colTitle->getFont()->setBold(true);
        $colTitle->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        $colTitle->getFont()->setSize(12);
        
        //设置行高
        $objSheet->getDefaultRowDimension()->setRowHeight(24);
        //固定第一行
        $objSheet->freezePane('A2');
        
        $num = 2;
        foreach ($result as $val){
            $sex = $val->student->sex == 1 ? '男' : '女';
           $obj = $objSheet->setCellValue('A'.$num,$val->student->trueName)->setCellValue('B'.$num,$val->gradeClass)->setCellValue('C'.$num,$val->student->phone)->setCellValue('D'.$num,$sex)->setCellValue('E'.$num,date('Y-m-d H:i:s',$val->createTime))
            ->setCellValue('F'.$num,self::$verify_texts[$verify]);
            if($verify == self::STUDENT_VERIFY_STEP2){
                $obj->setCellValue('G'.$num,$val->verifyReason1);
            }elseif ($verify == self::STUDENT_VERIFY_FINISH){
                $obj->setCellValue('G'.$num,$val->verifyReason1)->setCellValue('H'.$num,$val->verifyReason2);
            }elseif ($verify == self::STUDENT_VERIFY_NO){
                $obj->setCellValue('G'.$num,$val->verifyReason1)->setCellValue('H'.$num,$val->verifyReason2);
            }
            
            $objSheet->getStyle('C' . $num)->getNumberFormat()->setFormatCode("@");
            $num ++;
        }
        
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser('在线报名-'.self::$verify_texts[$verify].'的学生列表信息.xlsx');
        $objWriter->save('php://output');
    }
    
    /**
     * 导出学员信息列表
     * @param array $data
     * @return boolean
     */
    public function exportStudent(array $data)
    {
        $query = self::find()->joinWith(['student','gradeclass'])->orderBy('verify asc,modifyTime desc,createTime desc');
        if($this->load($data) && !empty($this->search)){
            $query = $this->filterSearch($this->search,$query);
        }
        $result = $query->all();
        /* if(empty($result)){
            return false;
        } */
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        //水平垂直方向居中
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
        $objSheet->setTitle('学员列表');
        
        $objSheet->setCellValue('A1','学号')->setCellValue('B1','姓名')->setCellValue('C1','所在班级')->setCellValue('D1','报名时间')->setCellValue('E1','联系电话')
        ->setCellValue('F1','是否结业')->setCellValue('G1','优秀学员')->setCellValue('H1','性别')->setCellValue('I1','出生年月')
        ->setCellValue('J1','名族')->setCellValue('K1','工作单位')->setCellValue('L1','职称')->setCellValue('M1','政治面貌')
        ->setCellValue('N1','身份证号')->setCellValue('O1','现居城市')->setCellValue('P1','详细地址')->setCellValue('Q1','备注');
        
        //设置填充的样式和背景色
        $colTitle = $objSheet->getStyle('A1:Q1');
        $colTitle->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $colTitle->getFill()->getStartColor()->setARGB('b6cad2');
        $colTitle->getFont()->setBold(true);
        $colTitle->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        $colTitle->getFont()->setSize(12);
        
        //设置行高
        $objSheet->getDefaultRowDimension()->setRowHeight(24);
        //固定第一行
        $objSheet->freezePane('A2');
        
        //内容自适应
        $colums = range('A', 'Q');
        foreach ($colums as $c){
            $objSheet->getColumnDimension($c)->setWidth(16);
        }
        $objSheet->getColumnDimension('F')->setWidth(10);
        $objSheet->getColumnDimension('G')->setWidth(10);
        $objSheet->getColumnDimension('H')->setWidth(10);
        $objSheet->getColumnDimension('J')->setWidth(10);
        $objSheet->getColumnDimension('M')->setWidth(10);
        $objSheet->getColumnDimension('O')->setWidth(10);
        $objSheet->getColumnDimension('C')->setWidth(30);
        $objSheet->getColumnDimension('K')->setWidth(30);
        $objSheet->getColumnDimension('N')->setWidth(30);
        $objSheet->getColumnDimension('P')->setWidth(30);
        
        $num = 2;
        foreach ($result as $val){
            $isEnd = strtotime($val->gradeclass->closeClassTime.' 23:59:59') < time() == 1 ? '是':'否';
            $isBest = $val->student->isBest == 1 ? '是':'否';
            $sex = $val->student->sex == 1 ? '男' : '女';
            $objSheet->setCellValue('A'.$num,$val->studyNum)->setCellValue('B'.$num,$val->student->trueName)->setCellValue('C'.$num,$val->gradeClass)->setCellValue('D'.$num,date('Y-m-d H:i:s',$val->modifyTime))->setCellValue('E'.$num,$val->student->phone)
            ->setCellValue('F'.$num,$isEnd)->setCellValue('G'.$num,$isBest)->setCellValue('H'.$num,$sex)->setCellValue('I'.$num,$val->student->birthday)
            ->setCellValue('J'.$num,$val->student->nation)->setCellValue('K'.$num,$val->student->company)->setCellValue('L'.$num,$val->student->positionalTitles)->setCellValue('M'.$num,$val->student->politicalStatus)
            ->setCellValue('N'.$num,"".$val->student->IDnumber)->setCellValue('O'.$num,$val->student->city)->setCellValue('P'.$num,$val->student->address)->setCellValue('Q'.$num,'');
            
            $objSheet->getStyle('A' . $num)->getNumberFormat()->setFormatCode("@");
            $objSheet->getStyle('N' . $num)->getNumberFormat()->setFormatCode("@");
            $num ++;
        }
        
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser('学员列表.xlsx');
        $objWriter->save('php://output');
        
    }
    
    
    public function pageList(array $data,$orderBy = 'verify asc,modifyTime desc,createTime desc',$jowin = ['student'])
    {
    	$this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
    	$query = self::find()->joinWith($jowin)->orderBy($orderBy);
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
            $query = $query->andWhere(self::tableName().'.verify = :verify',[':verify'=>$search['verify']]);
    	}
    	
    	if(isset($search['userId']) && is_numeric($search['userId'])){
    		$query = $query->andWhere(self::tableName().'.userId = :userId',[':userId'=>$search['userId']]);
    	}
    	//是否结业
    	if(isset($search['isEnd']) && !empty($search['isEnd'])){
    	    if($search['isEnd'] == 1){
    	        $query = $query->andWhere(GradeClass::tableName().'.closeClassTime < :today',[':today'=>date('Y-m-d')]);
    	    }elseif ($search['isEnd'] == 0){
    	        $query = $query->andWhere(GradeClass::tableName().'.closeClassTime > :today',[':today'=>date('Y-m-d')]);
    	    }
    	    
    	}
    	
    	return $query;
    }
    
    
    public function getStudent()
    {
    	return $this->hasOne(Student::className(), ['userId'=>'userId']);
    }
    
    public function getGradeclass()
    {
        return $this->hasOne(GradeClass::className(), ['id'=>'gradeClassId']);
    }
}