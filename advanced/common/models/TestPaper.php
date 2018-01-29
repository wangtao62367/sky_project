<?php
namespace common\models;




use common\models\BaseModel;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use common\publics\MyHelper;

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
    
    public function filterSearch($search,ActiveQuery $query)
    {
        if(isset($search['keywords']) && !empty($search['keywords'])){
            $query = $query->andWhere(['like','title',$search['keywords']]);
        }
        if(isset($search['isPublish']) && !empty($search['isPublish']) && $search['isPublish'] != 'unkown'){
            $query = $query->andWhere('isPublish = :isPublish',[':isPublish'=>$search['isPublish']]);
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
    
    
    public function getGradeClass()
    {
        return $this->hasOne(GradeClass::className(), ['id'=>'gradeClassId']);
    }
}