<?php
namespace common\models;


use Yii;

class ArticleTag extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%ArticleTag}}';
    }
    
    public function getTags()
    {
        return  $this->hasOne(Tag::className(), ['id'=>'tagId']);
    }
    
    /**
     * 批量添加
     * @param array $data 如：  [['tagId'=>2,'articleId'=>4],['tagId'=>3,'articleId'=>4]]
     * @return number
     */
    public static function batchAdd(array $data)
    {
        return Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['tagId','articleId'], $data)->execute();
    }
    
}