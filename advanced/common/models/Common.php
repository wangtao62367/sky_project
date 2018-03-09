<?php
namespace common\models;




use yii\db\ActiveQuery;

/**
 * 基础配置表
 * @author wangtao
 *
 */
class Common extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%Common}}';
    }
    
    public function rules()
    {
        return [
            ['codeDesc','required','message'=>'名称不能为空','on'=>['edit','add']],
            ['codeDesc', 'string' ,'length'=>[2,5],'tooLong'=>'名称长度为2-5个字', 'tooShort'=>'名称长度为2-5个字','on'=>['edit','add']],
            ['code','required','message'=>'分类标识不能为空','on'=>'add'],
            ['code','unique','message'=>'分类标识已存在，请重新输入','on'=>'add'],
            ['sorts','required','message'=>'排序值不能为空','on'=>['edit','add']],
            ['sorts','integer','message'=>'排序值只能是整数值','on'=>['edit','add']],
            ['sorts', 'compare', 'compareValue' => 1, 'operator' => '>=','message'=>'排序值大于等于1','on'=>['edit','add']],
            [['search'],'safe']
        ];
    }
    
   
    
    public function pageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && is_numeric($data['curPage']) ? $data['curPage'] : 1;
        $query = Common::find()->where(['type'=>'bottomLink','isDelete'=>0])->orderBy(self::tableName().'.sorts ASC,'.self::tableName().'.modifyTime DESC');
        if($this->load($data) && !empty($this->search)){
            $query = $this->filterSearch($this->search,$query);
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function filterSearch(array $search,ActiveQuery $query)
    {
        if(isset($search['keywords']) && !empty($search['keywords'])){
            $query = $query->andWhere(['like','codeDesc',$search['keywords']]);
        }
        
        return $query;
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate()){
            return $this->save(false);
        }
        return false;
    }
    
    
    public static function edit(array $data,Common $model)
    {
        $model->scenario = 'edit';
        if($model->load($data) && $model->validate()){
            return $model->save(false);
        }
        return true;
    }
    
    public static function del(Common $model)
    {
        $model->isDelete = 1;
        return $model->save(false);
    }
    
    
    public static function getCommonListByType($type)
    {
        return self::find()->select([
            'id',
            'code',
            'codeDesc',
            'type',
            'typeDesc'
        ])
        ->where('type = :type',[':type'=>$type])->andWhere(['isDelete'=>0])->orderBy(self::tableName().'.sorts ASC,'.self::tableName().'.modifyTime DESC')->asArray()->all();
    }
    
    public function getCategorys()
    {
    	return $this->hasMany(Category::className(), ['parentId'=>'id']);
    }
    
    public function getPageList()
    {
        $query = self::find()->select([self::tableName().'.id','codeDesc','sorts'])->joinWith('categorys')->where([self::tableName().'.type'=>'navigation'])->andWhere([self::tableName().'.isDelete'=>0])->andWhere(self::tableName().'.code != :code',[':code'=>'sylb'])->orderBy(self::tableName().'.sorts ASC,'.self::tableName().'.modifyTime DESC');
    	
    	return $query->asArray()->all();
    }
    
    public static function getInfo($code,$type)
    {
        return self::find()->select([
            'id',
            'code',
            'codeDesc',
            'type',
            'typeDesc'
        ])->where('code = :code and type = :type',[':code'=>$code,':type'=>$type])->one();
    }
    
    public function getNav()
    {
    	return self::find()->select([
    			self::tableName().'.id',
    			self::tableName().'.code',
    			self::tableName().'.codeDesc',
    			self::tableName().'.type',
    			self::tableName().'.typeDesc'
    	])
    	->joinWith('cates')
    	->where(self::tableName().'.type = :type',[':type'=>'navigation'])->andWhere([self::tableName().'.isDelete'=>0])->orderBy(self::tableName().'.sorts ASC,'.self::tableName().'.modifyTime DESC')->asArray()->all();
    }
    
    public function getCates()
    {
    	return $this->hasMany(Category::className(), ['parentId'=>'id']);
    }
}