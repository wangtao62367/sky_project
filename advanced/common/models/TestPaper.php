<?php
namespace common\models;




use common\models\BaseModel;

class TestPaper extends BaseModel
{
    
    public $questions = [];
    
    public $publish;
    
    public static function tableName()
    {
        return '{{%testpaper}}';
    }
    
    public function rules()
    {
        return [
            ['title','required','message'=>'试卷题干不能为空','on'=>['add','edit']],
            [['search','questions','marks'],'safe'],
        ];
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate(false)){
            $this->questionCount = count($this->questions);
            $this->isPublish  = $this->publish == 'now' ? 1 : 0;
            return $this->save(false);
        }
        return false;
    }
    
    public function del(TestPaper $testpaper)
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