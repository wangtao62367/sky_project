<?php
namespace common\models;


use yii\db\ActiveRecord;
use phpDocumentor\Reflection\Types\This;
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
    
    //投票选项
    public $voteoptions;
    
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
        }
    }
    
    /**
     * 分页获取投票列表
     * @param int pageIndex
     * @param int pageSize
     * @param array search
     * 
     */
    public function votes()
    {
       
        return self::find()->all();
    }
    /**
     * 添加投票
     * @param array $data
     */
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate()){
            
            
            return $this->save(false);
        }
        return false;
    }
}