<?php
namespace common\models;




use Yii;
use common\publics\ImageUpload;

class  Carousel extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%Carousel}}';
    }
    
    public function rules()
    {
        return [
            ['title','required','message'=>'轮播图标题不能为空','on'=>['add']],
            ['link','required','message'=>'轮播图链接地址不能为空','on'=>['add']],
            ['sorts','default','value'=>1],
            [['sorts','search','img'],'safe'],
        ];
    }
    
    
    
    public function getList()
    {
        $query = self::find()->select([
            'id',
            'img',
            'link',
            'title',
            'sorts',
            'createTime',
            'modifyTime'
        ])->orderBy('sorts desc,modifyTime desc');
        return $this->query($query);
    }
    
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        //先上传图片 再写数据
        if(isset($_FILES['file']) && !empty($_FILES['file']) && !empty($_FILES['file']['tmp_name']) ){
            
            $upload = new ImageUpload([
                'imageMaxSize' => 1024*1024*500,
                'imagePath'    => 'carousel',
                'isWatermark'  => false,
            ]);
            $result = $upload->Upload('file');
            $imageName = Yii::$app->params['oss']['host'].$result;
            $data['Carousel']['img']= $imageName;
        }
        
        if($this->load($data) && $this->validate()){
           
            return $this->save(false);
        }
        return  false;
    }
    
    public function del(Carousel $carousel)
    {
        $imgFile = $carousel->img;
        if($carousel->delete()){
            $upload = new ImageUpload([]);
            if(!empty($imgFile)){
                $block = str_replace(Yii::$app->params['oss']['host'], '', $imgFile);
                $upload->deleteImage($block);
            }
            return true;
        }
        return false;
    }
}