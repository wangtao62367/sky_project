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
        return '{{%testpaper}}';
    }
    
    public function rules()
    {
        return [
            ['title','required','message'=>'试卷题干不能为空','on'=>['add','edit']],
            [['search','questions','marks','publishTime','publishCode'],'safe'],
        ];
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate(false)){
            $this->questionCount = count($this->questions);
            $this->getPublishTime($this->publishCode);
            if($this->save(false)){
               self::addQuestion($this->questions,$this->id);
               return true;
            }
        }
        return false;
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
        return (bool)TestPaperQuestion::batchAdd($paperQuestParam);
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
                $query = $query->andWhere(['or',['like','author',$this->search['keywords']],['like','title',$this->search['keywords']]]);
            }
            if(!empty($this->search['isPublish']) && $this->search['isPublish'] != 'unkown'){
                $query = $query->andWhere('isPublish = :isPublish',[':isPublish'=>$this->search['isPublish']]);
            }
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
}