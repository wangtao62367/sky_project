<?php
namespace common\models;


use yii\db\ActiveRecord;
use phpDocumentor\Reflection\Types\This;
use common\publics\MyHelper;
/**
 * 投票
 * @author WT by 2017-11-17
 *
 */
class Vote extends ActiveRecord
{
    const VOTE_CLOSE = 1;
    const VOTE_UNCLOSE = 0;

    const VOTE_DELETE = 1;
    const VOTE_UNDELETE = 0;
    
    //投票选项  默认2个选项，值为空
    public $voteoptions = ['',''];
    
    public static function tableName()
    {
        return '{{%vote}}';
    }
    
    public function rules()
    {
        return [
            ['subject','required','message'=>'投票主题不能为空','on'=>'add'],
            ['startDate','required','message'=>'开始时间不能为空','on'=>'add'],
            ['endDate','required','message'=>'结束时间不能为空','on'=>'add'],
            ['selectType','required','message'=>'投票类型不能为空','on'=>'add'],
            ['selectCount','default','value'=>1],
            ['voteoptions','required','message'=>'投票选项不能为空','on'=>'add'],
            ['voteoptions','validVoteoptions'],
            [['isClose','isDelete','createUserId'],'safe'],
            ['createTime','default','value'=>TIMESTAMP,'on'=>'add'],
            ['modifyTime','default','value'=>TIMESTAMP,'on'=>'add'],
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
     * @param int pageIndex
     * @param int pageSize
     * @param array search
     * @return array
     */
    public function votes()
    {
       
        return self::find()->all();
    }
    /**
     * 添加投票
     * @param array $data
     * @return boolean
     */
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate()){
            if($this->save(false)){
                $options = [];
                foreach ($this->voteoptions as $op){
                    $options[] = [
                        'text'   => $op,
                        'voteId' => $this->id,
                        'createTime' => TIMESTAMP,
                        'modifyTime' => TIMESTAMP
                    ];
                }
                $voteOptions = new VoteOptions();
                return (bool)$voteOptions->batchAdd($options);
            }
        }
        return false;
    }
}