<?php
namespace common\models;


use yii\base\Model;

class FormModel extends Model
{
    //分页数
    public $curPage = 1;
    //分页大小
    public $pageSize = 10;
    //查询参数
    public $search = [];
    
}