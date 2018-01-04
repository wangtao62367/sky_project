<?php
namespace common\models;





class Naire extends BaseModel
{
    public $publishArr = [
        '0' => '未发布',
        '1' => '已发布'
    ];
    
    public $votes = [];
    
    public static function tableName()
    {
        return '{{%naire}}';
    }
    
    
    public function rules()
    {
        return [
            ['title','required','message'=>'问卷主题不能为空','on'=>['add','edit']],
            [['search','votes','marks'],'safe'],
        ];
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate()){
            $this->voteCount = count($this->votes);
            if($this->save(false)){
                self::addVotes($this->votes,$this->id);
                return true;
            }
        }
        return false;
    }
    
    public static function edit(array $data, Naire $naire)
    {
        $naire->scenario = 'edit';
        if($naire->load($data) && $naire->validate()){
            $naire->voteCount = count($this->votes);
            if($naire->save(false)){
                self::addVotes($this->votes,$this->id);
                return true;
            }
        }
        return false;
    }
    
    public static function getNaireById(int $id)
    {
        $naire = self::findOne($id);
        if(empty($naire)){
            return false;
        }
        
        $naireVotes = NaireVote::find()->joinWith('votes')->where(['naireId'=>$naire->id])->all();
        if(empty($naireVotes)){
            return false;
        }
        foreach ($naireVotes as $naireVote){
            $options = VoteOptions::find()->where('voteId = :voteId',[':voteId'=>$naireVote->votes->id])->asArray()->all();
            $naire->votes[] = [
                'id' => $naireVote->votes->id,
                'subject' => $naireVote->votes->subject,
                'selectType' => $naireVote->votes->selectType,
                'selectTypeText' => QuestCategory::getQuestCateText($naireVote->votes->selectType),
                'voteoptions' => $options
            ];
            
        }
        return $naire;
    }
    
    
    private static function addVotes(array $votes,int $id)
    {
        if(empty($votes)){
            $this->addError('votes','问卷试题不能为空');
            return false;
        }
        $naireVotesParams = [];
        foreach ($votes as $k=>$vote){
            if( isset($vote['id']) && !empty($votes['id'])){
                $naireVotesParams [] = [
                    'naireId' => $id,
                    'voteId'  => $vote['id'],
                    'sorts'   => $k+1,
                ];
            }else{
                $voteModle = new Vote();
                if( $voteModle->add(['Vote'=>[
                        'subject'    => $vote['subject'],
                        'selectType' => $vote['selectType'],
                        'voteoptions'=> $vote['voteoptions']
                    ]]) ){
                    $naireVotesParams [] = [
                        'naireId' => $id,
                        'voteId'  => $voteModle->id,
                        'sorts'   => $k+1,
                    ];
                }
                
            }
        }
        if(!empty($naireVotesParams)){
            NaireVote::deleteAll(['naireId'=>$id]);
            NaireVote::batchAdd($naireVotesParams);
        }
        return true;
    }
    
    
    public function getPageList($get,$search)
    {
        $this->curPage = isset($get['curPage']) && !empty($get['curPage']) ? $get['curPage'] : $this->curPage;
        $query = self::find()
        ->select([
            'id',
            'title',
            'voteCount',
            'isPublish',
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
    
    public static function del(Naire $naire)
    {
        $naire->isDelete = 1;
        return $naire->save(false);
    }
}