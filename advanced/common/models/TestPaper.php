<?php
namespace common\models;




use common\models\BaseModel;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;
use function foo\func;

class TestPaper extends BaseModel
{
    const TESTPAPER_VERIFY_NEW = '0';
    
    const TESTPAPER_VERIFY_YES = '1';
    
    const TESTPAPER_VERIFY_NO  = '3';
    
    public $questions = [];
    
    public $publishTimeArr = [
    		'now' => '立即发布',
    		'min30' =>'30分钟后发布',
    		'oneHours' => '1小时候发布',
    		'oneDay' => '1天以后发布',
    		'nopublish' => '暂时不发布',
    ];
    
    public static $verifyText = [
        self::TESTPAPER_VERIFY_NEW => '未审核',
        self::TESTPAPER_VERIFY_YES => '已审核',
        self::TESTPAPER_VERIFY_NO  => '审核失败',
    ];
    
    public static function tableName()
    {
        return '{{%TestPaper}}';
    }
    
    public function rules()
    {
        return [
            ['title','required','message'=>'试卷题干不能为空','on'=>['add','edit']],
        	['timeToAnswer','required','message'=>'试卷作答时间不能为空','on'=>['add','edit']],
        	['gradeClassId','required','message'=>'试卷所属班级不能为空','on'=>['add','edit']],
            ['from','required','message'=>'试卷来源不能为空','on'=>['add','edit']],
            [['search','questions','marks','publishTime','publishCode','from'],'safe'],
        ];
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate(false)){
        	//分别获取不同类型的试题数量
        	if(empty($this->questions)){
        	    $this->addError('question','试题不能为空，请选择试题');
        	    return false;
        	}
        	self::handleQuetionCount($this->questions,$this);
            $this->getPublishTime($this->publishCode);
            if($this->save(false)){
               self::addQuestion($this->questions,$this->id);
               return true;
            }
        }
        return false;
    }
    
    public static function edit(array $data,TestPaper $testPaper)
    {
        $testPaper->scenario = 'edit';
        if($testPaper->load($data) && $testPaper->validate()){
        	//分别获取不同类型的试题数量
            if(empty($testPaper->questions)){
                $this->addError('question','试题不能为空，请选择试题');
                return false;
            }
            self::handleQuetionCount($testPaper->questions,$testPaper);
            $testPaper->getPublishTime($testPaper->publishCode);
            //return self::addQuestion($testPaper->questions,$testPaper->id);
            if($testPaper->save(false)){
                self::addQuestion($testPaper->questions,$testPaper->id);
                return true;
            }
        }
        return false;
    }
    
    private static function handleQuetionCount($questions,$obj)
    {
        $optionCateCounts = array_count_values(array_column($questions, 'cate'));
        $obj->radioCount = isset($optionCateCounts['radio']) && !empty($optionCateCounts['radio']) ? $optionCateCounts['radio'] : 0;
        $obj->multiCount = isset($optionCateCounts['multi']) && !empty($optionCateCounts['multi']) ? $optionCateCounts['multi'] : 0;
        $obj->t_fCount   = isset($optionCateCounts['trueOrfalse']) && !empty($optionCateCounts['trueOrfalse']) ? $optionCateCounts['trueOrfalse'] : 0;
        $obj->questionCount = count($questions);
        $obj->otherCount = $obj->questionCount - array_sum(array_values($optionCateCounts));
    }
    
    public static function getPaperById(int $id)
    {
        $testPaper = self::findOne($id);
        if(empty($testPaper)){
            return false;
        }
        $testPaperQuestionList = TestPaperQuestion::find()
        ->joinWith('questions')
        ->where(['paperId'=>$testPaper->id])
        ->all();
        if(empty($testPaperQuestionList)){
            return false;
        }
        foreach ($testPaperQuestionList as $testPaperQuestion){
            $option = QuestOptions::find()->where('questId = :questId',[':questId'=>$testPaperQuestion->questions->id])->asArray()->all();
            $testPaper->questions[] = [
                'id'    => $testPaperQuestion->questions->id,
                'title' => $testPaperQuestion->questions->title,
                'cate'  => $testPaperQuestion->questions->cate,
                'cateText'=> QuestCategory::getQuestCateText($testPaperQuestion->questions->cate),
                'score'   => $testPaperQuestion->score,
                'answer'  => $testPaperQuestion->questions->answer,
                'answerOpt' => json_decode($testPaperQuestion->questions->answerOpt,true),
                'options'   => $option
            ];
        }
        return $testPaper;
    }
    
    private function getPublishTime(string $publish)
    {
    	switch ($publish){
    		case 'now':
    			$this->isPublish  = 1;
    			$this->publishTime= TIMESTAMP;
    			break;
    		case 'min30':
    			$this->isPublish  = 0;
    			$this->publishTime= TIMESTAMP + 30 * 60;
    			break;
    		case 'oneHours':
    			$this->isPublish  = 0;
    			$this->publishTime= TIMESTAMP + 60 * 60;
    			break;
    		case 'oneDay':
    			$this->isPublish  = 0;
    			$this->publishTime= TIMESTAMP + 60 * 60 * 24;
    			break;
    		default: 
    			$this->isPublish  = 0;
    			$this->publishTime= TIMESTAMP + 60 * 60 * 24 * 3000;
    			break;
    	}
    }
    
    private static function addQuestion(array $questions,int $id)
    {
        $paperQuestParam = [];
        
        foreach ($questions as $k => $question){
            if(isset($question['id']) && !empty($question['id'])){
                $paperQuestParam [] = [
                    'paperId' => $id,
                    'questId' => $question['id'],
                    'score'   => $question['score'],
                    'sorts'   => $k+1
                ];
            }else{
                $quest = new Question();
                if( $quest->add(['Question'=>[
                                            'title' => $question['title'],
                                            'cate'  => $question['cate'],
                                            'answer'=> $question['answer'],
                                            'answerOpt' => $question['answerOpt'],
                                            'opts' => $question['options'],
                                        ]]) ){
                    $paperQuestParam [] = [
                        'paperId' => $id,
                        'questId' => $quest->id,
                        'score'   => $question['score'],
                        'sorts'   => $k+1
                    ];
                }
            }
        }
        if(!empty($paperQuestParam)){
            $i = TestPaperQuestion::deleteAll(['paperId'=>$id]);
            $b = TestPaperQuestion::batchAdd($paperQuestParam);
        }
        return [$i,$b];
        return true;
    }
    
    public static function del(TestPaper $testpaper)
    {
        $testpaper->isDelete = 1;
        return $testpaper->save(false);
    }
    
    public function getPageList($get,$search)
    {
        $this->curPage = isset($get['curPage']) && !empty($get['curPage']) ? $get['curPage'] : $this->curPage;
        $query = $this->getQuery();
        if (!empty($search) && $this->load($search)){
            $query = $this->filterSearch($this->search, $query);
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function getQuery()
    {
        return self::find()
        ->select([
            self::tableName().'.id',
            'title',
            'radioCount',
            'multiCount',
            't_fCount',
            'otherCount',
            'questionCount',
            'isPublish',
            'publishTime',
            'verify',
            'timeToAnswer',
            'gradeClassId',
            'from',
            self::tableName().'.createTime',
            self::tableName().'.modifyTime'
        ])
        ->joinWith('gradeClass')
        ->where([self::tableName().'.isDelete'=>0])
        ->orderBy(self::tableName().'.modifyTime desc');
    }
    
    public function getGradeClass()
    {
        return $this->hasOne(GradeClass::className(), ['id'=>'gradeClassId']);
    }
    
    public function filterSearch($search,ActiveQuery $query)
    {
        if(isset($search['keywords']) && !empty($search['keywords'])){
            $query = $query->andWhere(['like','title',$search['keywords']]);
        }
        if(isset($search['isPublish']) && is_numeric($search['isPublish']) ){
            $query = $query->andWhere('isPublish = :isPublish',[':isPublish'=>$search['isPublish']]);
        }
        if(isset($search['verify']) && !empty($search['verify']) && $search['verify'] != 'unkown'){
        	$query = $query->andWhere('verify = :verify',[':verify'=>$search['verify']]);
        }
        if(isset($search['from']) && !empty($search['from'])){
            $query = $query->andWhere(['like','from',$search['from']]);
        }
        if(isset($search['gradeClass']) && !empty($search['gradeClass'])){
            $gradeClassArr = GradeClass::find()->select(['id'])->where(['like','className',$search['gradeClass']])->asArray()->all();
            if(!empty($gradeClassArr)){
                $ids = ArrayHelper::getColumn($gradeClassArr, 'id');
                $query = $query->andWhere(['in','gradeClassId',$ids]);
            }
        }
        
        if(isset($search['gradeClassId']) && !empty($search['gradeClassId'])){
            $query = $query->andWhere(['gradeClassId'=>$search['gradeClassId']]);
        }
        
        return $query;
    }
    
    public function export(array $data){
        $query = $this->getQuery();
        if (!empty($data) && $this->load($data)){
            $query = $this->filterSearch($this->search, $query);
        }
        $result = $query->asArray()->all();
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objSheet->setTitle('试卷列表');
        $objSheet->setCellValue('A1','序号')->setCellValue('B1','试卷主题')->setCellValue('C1','作答时间（分钟）')->setCellValue('D1','作答班级')
        ->setCellValue('E1','试题总数')->setCellValue('F1','单选题数')->setCellValue('G1','多选题数')->setCellValue('H1','判断题数')->setCellValue('I1','其他题数')
        ->setCellValue('J1','发布状态')->setCellValue('K1','发布时间')->setCellValue('L1','审核状态')->setCellValue('M1','试卷来源')
        ->setCellValue('N1','创建时间')->setCellValue('O1','修改时间');
        $num  = 2;
        foreach ($result as $val){
            $objSheet->setCellValue('A'.$num,$val['id'])->setCellValue('B'.$num,$val['title'])->setCellValue('C'.$num,$val['timeToAnswer'])->setCellValue('D'.$num,$val['gradeClass']['className'])
            ->setCellValue('E'.$num,$val['questionCount'])->setCellValue('F'.$num,$val['radioCount'])->setCellValue('G'.$num,$val['multiCount'])->setCellValue('H'.$num,$val['t_fCount'])
            ->setCellValue('I'.$num,$val['otherCount'])->setCellValue('J'.$num,$val['isPublish'] == 1?'已发布':'未发布')->setCellValue('K'.$num,MyHelper::timestampToDate($val['publishTime']))->setCellValue('L'.$num,self::$verifyText[$val['verify']])
            ->setCellValue('M'.$num,$val['from'])->setCellValue('N'.$num,MyHelper::timestampToDate($val['createTime']))->setCellValue('O'.$num,MyHelper::timestampToDate($val['modifyTime']));
            $num ++;
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser('试卷列表.xlsx');
        $objWriter->save('php://output');
    }
    
    /**
     * 导出用户试卷答题信息 
     * @param unknown $testPaper
     * @param unknown $trueNanme
     * @param unknown $paperstatics
     * @param unknown $answers
     */
    public static function exportAnswer($testPaper,$trueNanme,$paperstatics,$answers)
    {
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objSheet->setTitle($trueNanme.'的试卷答题情况');
        
        $objRichText = new \PHPExcel_RichText();
        //$objRichText->createText('导出用户试卷答题信息');
        
        $objPayable = $objRichText->createTextRun($testPaper->title);
        $objPayable->getFont()->setBold(true)->setSize(25)->setColor( new \PHPExcel_Style_Color( \PHPExcel_Style_Color::COLOR_BLACK ) );//加粗
        
        $objRichText->createText(PHP_EOL.'卷面总分：'.array_sum(array_column($testPaper['testpaperquestions'], 'score')).'分（答题时间：'.$testPaper['timeToAnswer'].' 分钟）'.PHP_EOL);
        
        $objRichText->createText(PHP_EOL.'姓名：    '.$trueNanme.'   日期：     '.date('Y-m-d',$paperstatics['createTime']).'   用时：   '.ceil($paperstatics['answerTime']/60));
        $objRichText->createText(' 分钟      得分：  ');
        $objPayable = $objRichText->createTextRun('     '.$paperstatics['scores'].'    ');
        $objPayable->getFont()->setBold(true)->setSize(22)->setUnderline(\PHPExcel_Style_Font::UNDERLINE_SINGLE)->setColor( new \PHPExcel_Style_Color( \PHPExcel_Style_Color::COLOR_RED ) );//加粗

        //试卷标题
        $objSheet->mergeCells('A1:D1')->setCellValue('A1',$objRichText);
        $objSheet->getStyle('A1')->getAlignment()->setWrapText(true);
        $objSheet->getRowDimension('1')->setRowHeight(140);//行高
        //设置列宽
        $objSheet->getColumnDimension('A')->setWidth(30);
        $objSheet->getColumnDimension('B')->setWidth(100);
        $objSheet->getColumnDimension('C')->setWidth(15);
        $objSheet->getColumnDimension('D')->setWidth(30);
        
        $objSheet->setCellValue('A2','题序')->setCellValue('B2','作答情况(标蓝下划线为用户答案)')->setCellValue('C2','结果')->setCellValue('D2','正确答案');
        $objSheet->getRowDimension('2')->setRowHeight(30);//行高
        //设置填充的样式和背景色
        $colTitle = $objSheet->getStyle('A2:D2');
        $colTitle->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $colTitle->getFill()->getStartColor()->setARGB('b6cad2');
        $colTitle->getFont()->setBold(true);
        $colTitle->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        
        //固定第一、二行
        $objSheet->freezePane('A3');
        
        $num  = 3;
        foreach ($answers as $v){
            
            $objSheet->setCellValue('A'.$num,PHP_EOL.'第'.$v->paperquestion->sorts.'题'.PHP_EOL.QuestCategory::getQuestCateText($v->question->cate).PHP_EOL.'('.$v->paperquestion->score.')'.PHP_EOL);
            $objSheet->getStyle('A'.$num)->getAlignment()->setWrapText(true);
            //用户答题选项
            $userAnswerOpt = unserialize($v->userAnswerOpt);
            $bCellValue = PHP_EOL.$v->question->title.PHP_EOL.PHP_EOL;
            $objRichText = new \PHPExcel_RichText();
            $objRichText->createText($bCellValue);
            $strOpts = '';
            foreach ($v->question->options as $k=>$opt){
                
                $str = MyHelper::getOpt($k,$v->question->cate).'、   '.$opt->opt.PHP_EOL.PHP_EOL;
                if($userAnswerOpt && in_array(MyHelper::getOpt($k,$v->question->cate), $userAnswerOpt)){

                    $objPayable = $objRichText->createTextRun($str);
                    $objPayable->getFont()->setUnderline(\PHPExcel_Style_Font::UNDERLINE_SINGLE);
                    $objPayable->getFont()->setColor( new \PHPExcel_Style_Color( \PHPExcel_Style_Color::COLOR_BLUE ) );
                    
                }else{
                    $objRichText->createText($str);;
                }
            }
            $objSheet->setCellValue('B'.$num,$objRichText);
            $objSheet->getStyle('B'.$num)->getAlignment()->setWrapText(true);
            $objSheet->getStyle('B'.$num)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            
            if($v->isRight == 1){
                $objSheet->setCellValue('C'.$num,'√');
                $objSheet->getStyle('C'.$num)->getFont()->setColor(new \PHPExcel_Style_Color( \PHPExcel_Style_Color::COLOR_GREEN ))->setSize(20);
            }else{
                $objSheet->setCellValue('C'.$num,'✘');
                $objSheet->getStyle('C'.$num)->getFont()->setColor(new \PHPExcel_Style_Color( \PHPExcel_Style_Color::COLOR_RED ))->setSize(20);
            }
            
            
            $objSheet->setCellValue('D'.$num,implode('、', json_decode($v->question->answerOpt,true)));
            
            $num++;
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser($trueNanme.'的试卷答题情况.xlsx');
        $objWriter->save('php://output');
    }
    
    
    public static function checkExistByGradeClassId(int $cid)
    {
        return (bool)self::find()->where(['gradeClassId'=>$cid,'isPublish'=>1,'verify'=>1])->count('id');
    }
    
    
    public function getInfoByGradeClassId(int $cid)
    {
        return self::find()->select([
            'id',
            'title',
            'radioCount',
            'multiCount',
            't_fCount',
            'otherCount',
            'questionCount',
            'timeToAnswer',
            'gradeClassId',
            'from',
            'createTime',
            'modifyTime'
        ])->where(['gradeClassId'=>$cid])->one();
    }
    
    public function getInfoById(int $id)
    {
    	return self::find()
    	->with(['testpaperquestions'=>function(ActiveQuery $query){
    		$query->orderBy('sorts ASC')->with(['questions'=>function(ActiveQuery $query){
    			$query->with('options');
    		}]);
    	}])
    	->where(['id'=>$id,'isPublish'=>1,'verify'=>1])
    	->asArray()->one();
    }
    
    
    public function getTestpaperquestions()
    {
    	return $this->hasMany(TestPaperQuestion::className(), ['paperId'=>'id']);
    }
}