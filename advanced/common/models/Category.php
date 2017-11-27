<?php
namespace common\models;

/**
 * 文章分类
 * @author WT by 2017-11-27
 *
 */
class Category extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%Category}}';
    }
    
    public function rules()
    {
        return [
            
        ];
    }
}