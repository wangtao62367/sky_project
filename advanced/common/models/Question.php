<?php
namespace common\models;


class Question extends BaseModel
{
    public $opts;

    public static function tableName()
    {
        return '{{%Question}}';
    }
    
    public function rules()
    {
        return [
            
        ];
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate()){
            
        }
        return false;
    }
    
}