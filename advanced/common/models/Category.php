<?php
namespace common\models;

use yii\db\Expression;

/**
 * 文章分类
 * @author wangtao by 2017-11-27
 *
 */
class Category extends BaseModel
{
    public  $position_arr = [
        'normal' => '通用区',
        'top' => '顶部区',
        'hot' => '焦点区',
    ];
    
    public $type_arr = [
        CategoryType::ARTICLE => '文章',
        CategoryType::IMAGE   => '图片',
        CategoryType::VIDEO   => '视频',
        CategoryType::FILE    => '文件'
    ];
    
    public static function tableName()
    {
        return '{{%Category}}';
    }
    
    public function rules()
    {
        return [
            ['text','required','message'=>'分类名称不能为空','on'=>['create','edit']],
            ['parentId','required','message'=>'分类所属模块不能为空','on'=>['create','edit']],
            [['type','descr','positions','search'],'safe'],
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
        $ext = 'CASE WHEN type = \''.CategoryType::ARTICLE.'\' then \'文章\' 
                     WHEN type = \''.CategoryType::IMAGE.'\' then \'图片\' 
                     WHEN type = \''.CategoryType::VIDEO.'\' then \'视频\'
                     WHEN type = \''.CategoryType::FILE.'\' then \'文件\'
                     ELSE \'未知\' END AS type_text';
        $query = self::find()
            ->select(['id','text',
                //'positions',
                //new Expression('case when type = \''.CategoryType::ARTICLE.'\' then \'文章\' when type = \'hot\' then \'焦点区\' when type = \'normal\'then \'通用区\' else \'未知\' end as positions_text'),
                'type',
                new Expression($ext),
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
            if(!empty($this->search['type']) && $this->search['type'] != 'unknow'){
                $query = $query->andWhere(['type'=>$this->search['type']]);
            }
        }
        
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function getParentCate()
    {
        return  Common::getCommonListByType('navigation');
        //return self::find()->select(['id','text'])->where('parentId = :parentId and isDelete = 0',[':parentId'=>$parentId])->asArray()->all();
    }
    
    public function del(int $id)
    {
        return self::updateAll(['isDelete'=>1],'id = :id',[':id'=>$id]);
    }
    
}