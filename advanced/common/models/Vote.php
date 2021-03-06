<?php
namespace common\models;


use yii\db\Expression;
use yii\base\Exception;

/**
 * 投票
 * @author WT by 2017-11-17
 *
 */
class Vote extends BaseModel
{
    const VOTE_CLOSE = 1;
    const VOTE_UNCLOSE = 0;

    const VOTE_DELETE = 1;
    const VOTE_UNDELETE = 0;
    
    //投票选项  默认2个选项，值为空
    public $voteoptions = ['',''];
    
    public static function tableName()
    {
        return '{{%Vote}}';
    }
    
    public function rules()
    {
        return [
            ['subject','required','message'=>'投票主题不能为空','on'=>['add','edit']],
//             ['startDate','required','message'=>'开始时间不能为空','on'=>['add','edit']],
//             ['endDate','required','message'=>'结束时间不能为空','on'=>['add','edit']],
            ['selectType','required','message'=>'投票类型不能为空','on'=>['add','edit']],
            ['selectCount','default','value'=>1],
            ['voteoptions','required','message'=>'投票选项不能为空','on'=>['add','edit']],
            ['voteoptions','validVoteoptions','on'=>['add','edit']],
            [['isClose','isDelete','createUserId','curPage','pageSize','search'],'safe'],
        ];
    }
    
    public function validVoteoptions()
    {
        if(!$this->hasErrors()){
            if(!is_array($this->voteoptions) || count($this->voteoptions) < 2){
                $this->addError('error','投票选项不能少于2项');
            }
            foreach ($this->voteoptions as $k=>$op){
                if(empty($op)){
                    $this->addError('voteoptions','投票选项'.($k+1).',不能为空');
                    break;
                }
            }
        }
    }
    
    /**
     * 分页获取投票列表
     * @param array $data
     * @param array search
     * @return array
     */
    public function votes(array $data,array $search)
    {
        //$this->scenario = 'votes';
        $query = self::find()
                    ->select(['id','subject','startDate','endDate','selectType',new Expression("case when selectType = 'single' then '单选' when selectType ='multi' then '多选' when selectType = 'trueOrfalse' then '判断' else '未知' end as selectTypeText"),'isClose',new Expression('case when isClose = 0 then \'正常\' when isClose = 1 then \'关闭\' else \'未知\' end as isCloseText'),'createTime','modifyTime'])
                    ->where('isDelete = 0')
                    ->orderBy('isClose ASC,startDate ASC,modifyTime DESC,createTime DESC');
        $this->curPage = isset($data['curPage']) ? $data['curPage'] : $this->curPage;
        if(!empty($search) && $this->load($search)){
            $query = $this->filterSearch($this->search, $query);
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function filterSearch(array $search,$query)
    {
        if(!empty($search['subject'])){
            $query = $query->andWhere(['like','subject',$search['subject']]);
        }
        if(!empty($search['isClose']) && $search['isClose'] != 'unknow'){
            $query = $query->andWhere(['isClose'=>$search['isClose']]);
        }
        if(!empty($search['selectType']) && $search['selectType'] != 'unknow'){
            $query = $query->andWhere(['selectType'=>$search['selectType']]);
        }
        return $query;
    }
    /**
     * 添加投票
     * @param array $data
     * @return boolean
     */
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate() && $this->save(false)){
            
            return self::batchAddVoteOptions($this->voteoptions,$this->id);
        }
        return false;
    }
    
    /**
     * 批量添加投票选项
     * @param array $voteoptions
     * @return boolean
     */
    public static function batchAddVoteOptions(array $voteoptions,int $voteId)
    {
        VoteOptions::deleteAll(['voteId'=>$voteId]);
        $options = [];
        foreach ($voteoptions as $k=>$op){
            $options[] = [
                'text'   => $op['text'],
                'voteId' => $voteId,
                'sorts'  => $k,
                'createTime' => TIMESTAMP,
                'modifyTime' => TIMESTAMP
            ];
        }
        $voteOptions = new VoteOptions();
        return (bool)$voteOptions->batchAdd($options);
    }
    
    public static function getView(int $id)
    {
        $vote = self::find()->select(['id','subject'])->where('id =:id',[':id'=>$id])->asArray()->one();
        if(empty($vote)){
            throw new Exception('数据不存在');
        }
        $vote['options'] = VoteOptions::getOptionsByVoteId($id);
        return $vote;
    }
}