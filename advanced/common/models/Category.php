<?php
namespace common\models;

/**
 * 文章分类
 * @author WT by 2017-11-27
 *
 */
class Category extends BaseModel
{
    public  $position_arr = [
        'top' => '顶部区',
        'hot' => '焦点区',
        'normal' => '通用区'
    ];
    
    public static function tableName()
    {
        return '{{%Category}}';
    }
    
    public function rules()
    {
        return [
            ['text','required','message'=>'分类名称不能为空','on'=>'create'],
            [['parentId','descr','positions'],'safe'],
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
    
    public function getParentCate(int $parentId)
    {
        return self::find()->select(['id','text'])->where('parentId = :parentId',[':parentId'=>$parentId])->asArray()->all();
    }
}