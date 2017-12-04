<?php
namespace common\models;


use yii\db\Expression;

class Question extends BaseModel
{
    //默认2个空的选项
    public $opts = [
        ['opt'=>'','optImg'=>''],
        ['opt'=>'','optImg'=>''],
    ];
    

    public static function tableName()
    {
        return '{{%Question}}';
    }
    
    public function rules()
    {
        return [
            ['title','required','message'=>'标题不能为空','on'=>['add','edit']],
            ['cate','required','message'=>'试题类型不能为空','on'=>['add','edit']],
            ['score','required','message'=>'试题分数不能为空','on'=>['add','edit']],
            ['answerOpt','required','message'=>'正确答案不能为空','on'=>['add','edit']],
            ['answerOpt','validAnswerOpt','on'=>['add','edit']],
            [['titleImg','opts','answer','search'],'safe']
        ];
    }
    
    public function validAnswerOpt()
    {
        if(!$this->hasErrors()){
            if(empty($this->answerOpt)){
                $this->addError('answerOpt','正确答案不能为空');
                return false;
            }
            $options = ['A','B','C','D','E','F','G','H','I'.'J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            foreach ($this->answerOpt as $opt){
                $v = array_search($opt, $options);
                $this->answer += pow(2, $v);
            }
            $this->answerOpt = json_encode($this->answerOpt);
        }   
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate()){
            return $this->save(false) && QuestOptions::batchAdd($this->opts, $this->id);
        }
        return false;
    }
    
    
    public function questions(array $data,array $search)
    {
        $query = self::find()
                ->select([
                    'id',
                    'title',
                    'score',
                    'cate',
                    'answer',
                    'answerOpt',
                    'isPublish',
                    new Expression('case when isPublish = 1 then \'已发布\' else \'未发布\' end as isPublishText '),
                    'createTime',
                    'modifyTime'
                ])
                ->where(['isDelete'=>0]);
        $this->curPage = isset($data['curPage']) ? $data['curPage'] : $this->curPage;
        if(!empty($search) && $this->load($search)){
            if(!empty($this->search['cate']) && $this->search['cate'] != 'unknow'){
                $query = $query->andWhere('cate = :cate',[':cate'=>$this->search['cate']]);
            }
            if(!empty($this->search['title'])){
                $query = $query->andWhere(['like','title',$this->search['title']]);
            }
        }
        
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    
    public static function ajaxDel(int $id)
    {
        $question = self::getOptionById($id);
        if(empty($question)){
            return false;
        }
        $question->isDelete = 1;
        return (bool)$question->save(false);
    }
    
    public static function ajaxPublish(int $id)
    {
        $question = self::getOptionById($id);
        if(empty($question)){
            return false;
        }
        $question->isPublish = 1;
        return (bool)$question->save(false);
    }
    
    public static function getOptionById(int $id)
    {
        return self::find()->where('id = :id',[':id'=>$id])->one();
    }
    
}