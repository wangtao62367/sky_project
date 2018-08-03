<?php
namespace common\models;


use Yii;
use common\publics\ImageUpload;

class FamousTeacher extends BaseModel
{
    
    
    public static function tableName()
    {
        return '{{%FamousTeacher}}';
    }
    
    public function rules()
    {
        return [
            ['name','required','message'=>'姓名不能为空','on'=>['create','edit']],
            ['teach','required','message'=>'授课内容不能为空','on'=>['create','edit']],
            ['intro','required','message'=>'个人介绍不能为空','on'=>['create','edit']],
            [['sorts'],'safe'],
        ];
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if( $this->load($data) && $this->validate() ){
            
            //先上传图片 再写数据
            if(isset($_FILES['avater']) && !empty($_FILES['avater']) && !empty($_FILES['avater']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => false
                ]);
                $result = $upload->Upload('avater');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $this->avater= $imageName;
            }else{
                Yii::$app->session->setFlash('error','名师头像不能为空');
                return false;
            }
            return $this->save(false);
            
        }
        return false;
    }
    
    public static function edit(array $data,FamousTeacher $model)
    {
        $model->scenario = 'edit';
        
        if( $model->load($data) && $model->validate() ){
            
            //先上传图片 再写数据
            if(isset($_FILES['avater']) && !empty($_FILES['avater']) && !empty($_FILES['avater']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => false
                ]);
                $result = $upload->Upload('avater');
                $imageName = Yii::$app->params['oss']['host'].$result;
                if(!empty($model->avater)){
                    //删除旧的文件
                    $block = str_replace(Yii::$app->params['oss']['host'], '', $model->avater);
                    $upload = new ImageUpload([]);
                    $upload->deleteImage($block);
                }
                $model->avater= $imageName;
            }
            
            return $model->save(false);
            
        }
        return false;
        
    }
    
    public static function del(FamousTeacher $model)
    {
        return $model->delete();
    }
    
    public function getPageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()->select('id,name,teach,avater,sorts,createTime,modifyTime')->where([self::tableName().'.isDelete'=>0])->orderBy('sorts asc,modifyTime desc,createTime desc');
        if($this->load($data)){
            if(!empty($this->search)){
                if(!empty($this->search['name'])){
                    $query= $query->andWhere(['like','name',$this->search['name']]);
                }

                if(!empty($this->search['teach'])){
                    $query= $query->andWhere(['like','teach',$this->search['teach']]);
                }
            }
        }
        $result = $this->query($query, $this->curPage, $this->pageSize);
        return $result;
    }
    
}