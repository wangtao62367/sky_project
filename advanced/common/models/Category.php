<?php
namespace common\models;

use yii\db\Expression;

/**
 * 文章分类
 * @author WT by 2017-11-27
 *
 */
class Category extends BaseModel
{
    public  $position_arr = [
        'normal' => '通用区',
        'top' => '顶部区',
        'hot' => '焦点区',
    ];
    
    public static function tableName()
    {
        return '{{%Category}}';
    }
    
    public function rules()
    {
        return [
            ['text','required','message'=>'分类名称不能为空','on'=>['create','edit']],
            ['parentId','default','value'=>0,'on'=>['create','edit']],
            [['parentId','descr','positions','search'],'safe'],
            ['createTime','default','value'=>TIMESTAMP,'on'=>'create'],
        ];
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate()){
            return $this->save(false);
        }
        return false;
    }
    
    public function categoris(array $data,array $search)
    {
        $this->curPage = isset($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()
            ->select(['id','text',
                'positions',
                new Expression('case when positions = \'top\' then \'顶部区\' when positions = \'hot\' then \'焦点区\' when positions = \'normal\'then \'通用区\' else \'未知\' end as positions_text'),
                'descr',
                'parentId',
                'createTime',
                'modifyTime'
            ])
            ->where(['isDelete'=>0])
            ->orderBy('createTime desc');
        if(!empty($search) && $this->load($search)){
            if(!empty($this->search['text'])){
                $query = $query->andWhere(['like','text',$this->search['text']]);
            }
            if(!empty($this->search['positions']) && $this->search['positions'] != 'unknow'){
                $query = $query->andWhere(['positions'=>$this->search['positions']]);
            }
        }else{
            $query = $query->andWhere(['parentId'=>0]);
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function getParentCate(int $parentId)
    {
        return self::find()->select(['id','text'])->where('parentId = :parentId',[':parentId'=>$parentId])->asArray()->all();
    }
    
    public function del(int $id)
    {
        return self::updateAll(['isDelete'=>1],'id = :id',[':id'=>$id]);
    }
    
}