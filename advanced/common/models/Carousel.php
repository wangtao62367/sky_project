<?php
namespace common\models;





class  Carousel extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%Carousel}}';
    }
    
    public function rules()
    {
        return [
            
        ];
    }
    
    
    
    public function getList()
    {
        $query = self::find()->select([
            'id',
            'img',
            'link',
            'sorts',
            'createTime',
            'modifyTime'
        ])->orderBy('sorts desc,modifyTime desc');
        return $this->query($query);
    }
    
}