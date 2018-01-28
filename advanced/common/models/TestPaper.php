<?php
namespace common\models;




use common\models\BaseModel;

class TestPaper extends BaseModel
{
    
    public $questions = [];
    
    public $publishTimeArr = [
    		'now' => '立即发布',
    		'min30' =>'30分钟后发布',
    		'oneHours' => '1小时候发布',
    		'oneDay' => '1天以后发布',
    		'nopublish' => '暂时不发布',
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
            [['search','questions','marks','publishTime','publishCode'],'safe'],
        ];
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate(false)){
        	//分别获取不同类型的试题数量
        	$optionCateCounts = array_count_values(array_column($this->questions, 'cate'));
        	$this->radioCount = $optionCateCounts['radio'];
        	$this->multiCount = $optionCateCounts['multi'];
        	$this->t_fCount   = $optionCateCounts['trueOrfalse'];
            $this->questionCount = count($this->questions);
            $this->otherCount = $this->questionCount - array_sum(array_values($optionCateCounts));
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
        	$optionCateCounts = array_count_values(array_column($this->questions, 'cate'));
        	$this->radioCount = $optionCateCounts['radio'];
        	$this->multiCount = $optionCateCounts['multi'];
        	$this->t_fCount   = $optionCateCounts['trueOrfalse'];
        	$this->questionCount = count($this->questions);
        	$this->otherCount = $this->questionCount - array_sum(array_values($optionCateCounts));
            $testPaper->getPublishTime($testPaper->publishCode);
            //return self::addQuestion($testPaper->questions,$testPaper->id);
            if($testPaper->save(false)){
                self::addQuestion($testPaper->questions,$testPaper->id);
                return true;
            }
        }
        return false;
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
        $query = self::find()
            ->select([
                'id',
                'title',
                'questionCount',
                'isPublish',
            	'publishTime',
                'verify',
                'createTime',
                'modifyTime'
            ])
            ->where(['isDelete'=>0])
            ->orderBy('modifyTime desc');
        if (!empty($search) && $this->load($search)){
            if(!empty($this->search['keywords'])){
                $query = $query->andWhere(['like','title',$this->search['keywords']]);
            }
            if(!empty($this->search['isPublish']) && $this->search['isPublish'] != 'unkown'){
                $query = $query->andWhere('isPublish = :isPublish',[':isPublish'=>$this->search['isPublish']]);
            }
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
}