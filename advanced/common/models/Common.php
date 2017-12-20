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
        ->where('type = :type',[':type'=>$type])->asArray()->all();
    }
}