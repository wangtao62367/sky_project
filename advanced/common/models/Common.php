<?php
namespace common\models;




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
    
    
    public static function getCommonListByType($type)
    {
        return self::find()->select([
            'id',
            'code',
            'codeDesc',
            'type',
            'typeDesc'
        ])
        ->where('type = :type',[':type'=>$type])->orderBy('sorts asc')->asArray()->all();
    }
    
    public function getCategorys()
    {
    	return $this->hasMany(Category::className(), ['parentId'=>'id']);
    }
    
    public function getPageList()
    {
    	$query = self::find()->select([self::tableName().'.id','codeDesc','sorts'])->joinWith('categorys')->where([self::tableName().'.type'=>'navigation'])->orderBy('sorts ASC');
    	return $this->query($query,$this->curPage,30);
    }
}