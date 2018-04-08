<?php
namespace common\models;



use yii\db\ActiveQuery;

class Personage extends BaseModel
{
    
    
    public static function tableName()
    {
        return '{{%Personage}}';
    }
    
    public function rules()
    {
        return [
            [['search','intruduce','photo'],'safe'],
            ['fullName','required','message'=>'人物姓名不能为空','on'=>['add','edit']],
            ['role','required','message'=>'人物角色不能为空','on'=>['add','edit']],
            ['duties','required','message'=>'人物职务不能为空','on'=>['add','edit']],
            ['photo','required','message'=>'人物头像不能为空','on'=>['add']],
        ];
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate()){
            return $this->save(false);
        }
        return false;
    }
    
    public static function edit(array $data,Personage $personage)
    {
        $personage->scenario = 'edit';
        if($personage->load($data) && $personage->validate()){
            return $personage->save(false);
        }
        return false;
    }
    
    public static function del(Personage $personage)
    {
        return (bool)$personage->delete();
    }
    
    
    public function getList(array $data)
    {
        $this->curPage = isset($data['curPage']) && is_numeric($data['curPage']) ? $data['curPage'] : $this->curPage;
        
        $query = self::find()->select([])
                ->joinWith('role')
                ->orderBy('modifyTime desc');
        if($this->load($data) && !empty($this->search)){
            $query = $this->filterSearch($this->search,$query);
        }
        
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function filterSearch(array $search,ActiveQuery $query)
    {
        if(isset($search['fullName']) && !empty($search['fullName'])){
            $query = $query->andWhere(['like','fullName',$search['fullName']]);
        }
        if(isset($search['role']) && !empty($search['role'])){
            $query = $query->andWhere(['role'=>$search['role']]);
        }
        
        if(isset($search['startTime']) && !empty($search['startTime'])){
            $query = $query->andWhere(['>=','modifyTime',strtotime($search['startTime'])]);
        }
        
        if(isset($search['endTime']) && !empty($search['endTime'])){
            $query = $query->andWhere(['<=','modifyTime',strtotime($search['endTime'])]);
        }
        return $query;
    }
    
    
    public function getRole()
    {
        return $this->hasOne(Common::className(), ['code'=>'role']);
    }
}