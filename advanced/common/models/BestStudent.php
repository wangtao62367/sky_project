<?php
namespace common\models;



class BestStudent extends BaseModel
{
    
    
    public static function tableName()
    {
        return '{{%BestStudent}}';
    }
    
    
    public function rules()
    {
        return [
            ['studentId','required','message'=>'学员ID不能为空','on'=>['add','edit']],
            ['stuIntroduce','required','message'=>'学员简介不能为空','on'=>['add','edit']],
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
    
    public static function edit(array $data,BestStudent $model)
    {
        $model->scenario = 'edit';
        if($model->load($data) && $model->validate()){
            return $model->save(false);
        }
        return false;
    }
}