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
    
    public static function tableName()
    {
        return '{{%TeachPlace}}';
    }
    
    public function rules()
    {
        return [
            ['text','required','message'=>'教学地点不能为空','on'=>['create','edit']],
            ['text', 'string', 'length' => [2, 20], 'tooLong'=>'教学地点长度为4-40个字符', 'tooShort'=>'教学地点长度为2-20个字','on'=>['create','edite']],
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
    
    public static function edit(array $data , TeachPlace $teachPlaceInfo)
    {
        $teachPlaceInfo->scenario = 'edit';
        if($teachPlaceInfo->load($data) && $teachPlaceInfo->validate() && $teachPlaceInfo->save(false)){
            return true;
        }
        return false;
    }
    
    public static function del(int $id,TeachPlace $teachPlaceInfo)
    {
        $teachPlaceInfo->isDelete = self::TEACHPLACE_DELETE;
        return $teachPlaceInfo->save(false);
    }
    
    
    public function pageList(array $data)
    {
        $teachPlaceQuery = self::find()->select(['id','text','address','createTime','modifyTime'])->where(['isDelete'=>self::TEACHPLACE_UNDELETE])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data) && !empty($this->search) ){
            if(!empty($this->search['keywords'])){
                $teachPlaceQuery = $teachPlaceQuery->andWhere([
                    'or',
                    ['like','text',$this->search['keywords']],
                    ['like','address',$this->search['keywords']],
                ]);
            }
        }
        $list = $this->query($teachPlaceQuery, $this->curPage, $this->pageSize);
        return $list;
    }
}