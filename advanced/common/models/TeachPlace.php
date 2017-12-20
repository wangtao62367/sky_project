<?php
namespace common\models;


/**
 * 教学点
 * @author wangtao
 *
 */

class TeachPlace extends BaseModel
{
    const TEACHPLACE_DELETE = 1;
    const TEACHPLACE_UNDELETE = 0;
    
    
    public $keywords;
    
    public static function tableName()
    {
        return '{{%TeachPlace}}';
    }
    
    public function rules()
    {
        return [
            ['text','required','message'=>'教学地点不能为空','on'=>['create','edit']],
            ['text', 'length', 'max'=>20, 'min'=>2, 'tooLong'=>'教学地点长度为4-40个字符', 'tooShort'=>'教学地点长度为2-20个字','on'=>['create','edite']],
            [['address','createAdminId','curPage','pageSize','search'],'safe'],
        ];
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate() && $this->save(false)){
            return true;
        }
        return false;
    }
    
    public function edit(array $data , int $id)
    {
        $teachPlaceInfo = self::findOne($id);
        if(empty($teachPlaceInfo)){
            $this->addError('id','数据不存在');
            return false;
        }
        $teachPlaceInfo->scenario = 'edit';
        if($teachPlaceInfo->load($data) && $teachPlaceInfo->validate() && $teachPlaceInfo->save(false)){
            return true;
        }
        return false;
    }
    
    public function del(int $id)
    {
        $teachPlaceInfo= self::findOne($id);
        if(empty($teachPlaceInfo)){
            $this->addError('id','数据不存在');
            return false;
        }
        $teachPlaceInfo->isDelete = self::TEACHPLACE_DELETE;
        return $teachPlaceInfo->save(false);
    }
    
    
    public function pageList(array $data)
    {
        if($this->load($data)){
            $teachPlaceQuery = self::find()->select([])->orderBy('createTime desc,modifyTime desc');
            if(!empty($this->search)){
                if(!empty($this->search['keywords'])){
                    $teachPlaceQuery = $teachPlaceQuery->andWhere([
                        'or',
                        ['like','text',$this->search['keywords']],
                        ['like','address',$this->search['keywords']],
                    ]);
                }
            }
            $list = $this->query($teachPlaceQuery, $this->curPage, $this->curPage);
        }
        return false;
    }
}