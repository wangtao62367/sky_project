<?php
namespace backend\models;





class PublishCate
{
    
    public static $publishTimeArr = [
        'now' => '立即发布',
        'min30' =>'30分钟后',
        'oneHours' => '1小时候',
        'oneDay' => '1天以后',
        'nopublish' => '暂不发布',
        'userDefined' => '自定义'
    ];
    
    public static function getPublishTime(string $publishCode,$obj)
    {
        switch ($publishCode){
            case 'now':
                $obj->isPublish  = 1;
                $obj->publishTime= TIMESTAMP;
                break;
            case 'min30':
                $obj->isPublish  = 0;
                $obj->publishTime= TIMESTAMP + 30 * 60;
                break;
            case 'oneHours':
                $obj->isPublish  = 0;
                $obj->publishTime= TIMESTAMP + 60 * 60;
                break;
            case 'oneDay':
                $obj->isPublish  = 0;
                $obj->publishTime= TIMESTAMP + 60 * 60 * 24;
                break;
            case 'userDefined':
                $obj->isPublish  = 0;
                $obj->publishTime = strtotime($obj->publishTime);
                break;
            default:
                $obj->isPublish  = 0;
                break;
        }
    }
    
}