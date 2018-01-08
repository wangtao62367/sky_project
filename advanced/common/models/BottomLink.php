<?php
namespace common\models;



use yii\helpers\ArrayHelper;

/**
 * 底部链接
 * @author wangtao
 *
 */
class BottomLink extends BaseModel
{
    
    
    public static function tableName()
    {
        return '{{%BottomLink}}';
    }
    
    public function rules()
    {
        return [
            ['linkName','required','message'=>'链接名称不能为空','on'=>['create','edit']],
            ['linkName', 'length', 'max'=>10, 'min'=>2, 'tooLong'=>'课程名称长度为4-20个字符', 'tooShort'=>'课程名称长度为2-10个字','on'=>['create','edite']],
            ['linkUrl','required','message'=>'链接地址不能为空','on'=>['create','edit']],
            ['linkUrl','url','message'=>'链接地址无效','on'=>['create','edit']],
            ['linkCateId','required','message'=>'链接类型不能为空','on'=>['create','edit']],
            ['linkCateId','validLinkCate','on'=>['create','edit']],
            [['linkImg','curPage','pageSize','search'],'safe']
        ];
    }
    
    public function validLinkCate()
    {
        if(!$this->hasErrors()){
            $commonList = Common::getCommonListByType('bottomLink');
            $codeArray = ArrayHelper::getColumn($commonList, 'id');
            if(!ArrayHelper::isIn($this->linkCateId, $codeArray)){
                $this->addError('linkCate','请重新选择链接类型');
            }
        }
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate() && $this->save(false)){
            return true;
        }
        return false;
    }
    
    
    public function edit(array $data,int $id)
    {
        $friendshipInfo = self::findOne($id);
        if(empty($friendshipInfo)){
            $this->addError('id','数据不存在');
            return false;
        }
        $friendshipInfo->scenario = 'edit';
        if($friendshipInfo->load($data) && $friendshipInfo->validate() && $friendshipInfo->save(false)){
            return true;
        }
        return false;
    }
    
    public function del(int $id)
    {
        return (bool)self::deleteAll('id = :id',[':id'=>$id]);
    }
    
    public function getPageList(array $data)
    {
    	$this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
    	$linkQuery = self::find()->select([])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data)){
            if(!empty($this->search)){
                if(!empty($this->search['linkName'])){
                    $linkQuery = $linkQuery->andWhere(['like','linkName',$this->search['linkName']]);
                }
                if(!empty($this->search['linkCateId'])){
                    $linkQuery = $linkQuery->andWhere('linkCateId = :linkCateId',[':linkCateId'=>$this->search['linkCateId']]);
                }
            }
            
        }
        return $this->query($linkQuery, $this->curPage, $this->pageSize);
    }
    
}