<?php
namespace common\models;



class Role extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%Role}}';
    }
    
    
    public static function getRoles()
    {
        return self::find()->select(['id','roleName'])->asArray()->all();
    }
    
}