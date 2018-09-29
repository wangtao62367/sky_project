<?php
namespace common\models;






use yii\db\ActiveQuery;
use common\publics\MyHelper;

class Student extends BaseModel
{
    
    
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
    /**
     * 分页列表
     * @param array $data
     * @param string $field
     * @return number[]|array[]|\common\models\int[]|number
     */
    public function pageList(array $data,$field = '*')
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = $this->getQuery();
        if($this->load($data) && !empty($this->search)){
            $query = $this->filterSearch($this->search, $query);
        }
        $result = $this->query($query, $this->curPage, $this->pageSize);
        //var_dump($result);
        return $result;
    }
    /**
     * 查询
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return self::find()->select([
            self::tableName().'.id',
            self::tableName().'.userId',
            self::tableName().'.gradeClassId',
            self::tableName().'.studyNum',
            self::tableName().'.isBest',
            self::tableName().'.createTime',
            self::tableName().'.modifyTime',
            
            'bmId' => BmRecord::tableName().'.id',
            BmRecord::tableName().'.gradeClass',
            BmRecord::tableName().'.trueName',
            BmRecord::tableName().'.sex',
            BmRecord::tableName().'.birthday',
            BmRecord::tableName().'.avater',
            BmRecord::tableName().'.political',
            BmRecord::tableName().'.nation',
            BmRecord::tableName().'.health',
            BmRecord::tableName().'.eduDegree',
            BmRecord::tableName().'.speciality',
            
            BmRecord::tableName().'.dateToWork',
            BmRecord::tableName().'.dateToPolitical',
            BmRecord::tableName().'.politicalGrade',
            BmRecord::tableName().'.workplace',
            BmRecord::tableName().'.workDuties',
            BmRecord::tableName().'.orgCode',
            BmRecord::tableName().'.IDnumber',
            BmRecord::tableName().'.address',
            BmRecord::tableName().'.phone',
            BmRecord::tableName().'.postcode',
            BmRecord::tableName().'.socialDuties',
            BmRecord::tableName().'.politicalDuties',
            BmRecord::tableName().'.recommend',
            BmRecord::tableName().'.citystate',
            BmRecord::tableName().'.introduction',
            BmRecord::tableName().'.trueName',
            'bmCreateTime' => BmRecord::tableName().'.createTime',
            'bmModifyTime' => BmRecord::tableName().'.modifyTime',
            
            'gid' => GradeClass::tableName().'.id',
            GradeClass::tableName().'.closeClassTime',
            GradeClass::tableName().'.periods',

        ])->joinWith(['bminfo','gradeclass'])->where([self::tableName().'.isDelete'=>0])->orderBy(self::tableName().'.createTime desc,'.self::tableName().'.modifyTime desc');
    }
    /**
     * 搜索
     * @param array $search
     * @param ActiveQuery $query
     * @return \yii\db\ActiveQuery
     */
    public function filterSearch(array $search,ActiveQuery $query)
    {
        if(isset($search['trueName']) && !empty($search['trueName'])){
            $query = $query->andWhere(['like',BmRecord::tableName().'.trueName',$search['trueName']]);
        }
        if(isset($search['gradeClass']) && !empty($search['gradeClass'])){
            $query = $query->andWhere(['like',BmRecord::tableName().'.gradeClass',$search['gradeClass']]);
        }
        
        if(isset($search['sex']) && !empty($search['sex'])){
            $query = $query->andWhere(BmRecord::tableName().'.sex = :sex',[':sex'=>$search['sex']]);
        }
        
        if(isset($search['isBest']) && !empty($search['isBest'])){
            $query = $query->andWhere(self::tableName().'.isBest = :isBest',[':isBest'=>$search['isBest']]);
        }
        
        if(isset($search['nationCode']) && !empty($search['nationCode'])){
            $query = $query->andWhere(BmRecord::tableName().'.nationCode = :nationCode',[':nationCode'=>$search['nationCode']]);
        }
        
        if(isset($search['startTime']) && !empty($search['startTime'])){
            $query = $query->andWhere(BmRecord::tableName().'.createTime >= :startTime',[':startTime'=>strtotime($search['startTime'])]);
        }
        
        if(isset($search['startTime']) && !empty($search['startTime'])){
            $query = $query->andWhere(BmRecord::tableName().'.createTime <= :endTime',[':endTime'=>strtotime($search['endTime'])]);
        }
        //是否结业
        if(isset($search['isEnd']) && is_numeric($search['isEnd'])){
            if(intval($search['isEnd']) == 1){
                $query = $query->andWhere(GradeClass::tableName().'.closeClassTime < :date',[':date'=>date('Y-m-d')]);
            }else{
                $query = $query->andWhere(GradeClass::tableName().'.closeClassTime >= :date',[':date'=>date('Y-m-d')]);
            }
        }
        
        if(isset($search['userId']) && is_numeric($search['userId'])){
            $query = $query->andWhere(self::tableName().'.userId = :userId',[':userId'=>$search['userId']]);
        }
        return $query;
    }
    /**
     * 导出
     * @param array $data
     */
    public function exportStudent(array $data)
    {
        $query = $this->getQuery();
        if($this->load($data) && !empty($this->search)){
            $query = $this->filterSearch($this->search, $query);
        }
        $result = $query->asArray()->all();
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        //水平垂直方向居中
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
        $objSheet->setTitle('学员列表');
        
        $objSheet->setCellValue('A1','姓名')->setCellValue('B1','性别')->setCellValue('C1','名族')->setCellValue('D1','年龄')->setCellValue('E1','文化程度')
        ->setCellValue('F1','政治面貌')->setCellValue('G1','工作单位及职务')->setCellValue('H1','电话号码')->setCellValue('I1','所在班级')
        ->setCellValue('J1','学号')->setCellValue('K1','是否结业')->setCellValue('L1','优秀学员')->setCellValue('M1','报名时间')
        ->setCellValue('N1','身份证号')->setCellValue('O1','市州');
        
        //设置填充的样式和背景色
        $colTitle = $objSheet->getStyle('A1:O1');
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
        $objSheet->getColumnDimension('A')->setWidth(25);
        $objSheet->getColumnDimension('B')->setWidth(15);
        $objSheet->getColumnDimension('C')->setWidth(20);
        $objSheet->getColumnDimension('D')->setWidth(15);
        $objSheet->getColumnDimension('E')->setWidth(15);
        $objSheet->getColumnDimension('F')->setWidth(15);
        $objSheet->getColumnDimension('G')->setWidth(50);
        $objSheet->getColumnDimension('H')->setWidth(20);
        $objSheet->getColumnDimension('I')->setWidth(30);
        $objSheet->getColumnDimension('J')->setWidth(25);
        $objSheet->getColumnDimension('K')->setWidth(8);
        $objSheet->getColumnDimension('L')->setWidth(8);
        $objSheet->getColumnDimension('M')->setWidth(25);
        $objSheet->getColumnDimension('N')->setWidth(40);
        $objSheet->getColumnDimension('O')->setWidth(20);

        $num = 2;
        foreach ($result as $val){
            $isEnd = strtotime($val['gradeclass']['closeClassTime'].' 23:59:59') < time() == 1 ? '是':'否';
            $isBest = $val['isBest'] == 1 ? '是':'否';
            $sex = $val['sex'] == 1 ? '男' : '女';
            $age = MyHelper::getAge(strtotime($val['birthday']));
            $heath = BmRecord::$health_texts[$val['health']];
            $objSheet->setCellValue('A'.$num,$val['trueName'])
            ->setCellValue('B'.$num,$sex)
            ->setCellValue('C'.$num,$val['nation'])
            ->setCellValue('D'.$num,$age)
            ->setCellValue('E'.$num,$val['eduDegree'])
            ->setCellValue('F'.$num,$val['political'])
            ->setCellValue('G'.$num,$val['workplace'].' - '.$val['workDuties'])
            ->setCellValue('H'.$num,$val['phone'])
            ->setCellValue('I'.$num,$val['gradeClass'])
            ->setCellValue('J'.$num,$val['studyNum'])
            ->setCellValue('K'.$num,$isEnd)
            ->setCellValue('L'.$num,$isBest)
            ->setCellValue('M'.$num,date('Y-m-d H:i:s',$val['createTime']))
            ->setCellValue('N'.$num,"".$val['IDnumber'])
            ->setCellValue('O'.$num,$val['citystate']);
            
            $objSheet->getStyle('J' . $num)->getNumberFormat()->setFormatCode("@");
            $objSheet->getStyle('N' . $num)->getNumberFormat()->setFormatCode("@");
            $num ++;
        }
        
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser('学员列表.xlsx');
        $objWriter->save('php://output');
    }
    
    
    public function getBminfo()
    {
        return $this->hasOne(BmRecord::className(), ['userId'=>'userId','gradeClassId'=>'gradeClassId']);
    }
    
    public function getGradeclass()
    {
        return $this->hasOne(GradeClass::className(), ['id'=>'gradeClassId']);
    }
}