<?php
namespace common\models;




use Yii;
use common\publics\ImageUpload;

class Video extends BaseModel
{
    public $oldVideoImg;
    
    public $oldVideo;
    
    public static function tableName()
    {
        return '{{%Video}}';
    }
    
    public function rules()
    {
        return [
            ['video','required','message'=>'视频不能为空','on'=>['add','edit']],
            ['categoryId','required','message'=>'视频分类不能为空','on'=>['add','edit']],
            ['descr','required','message'=>'视频名称不能为空','on'=>['add','edit']],
        	['videoImg','required','message'=>'视频背景图不能为空','on'=>['add','edit']],
        	[['search','oldVideoImg','provider','leader','remarks'],'safe']
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
    
    public static function edit(array $data,Video $video)
    {
        $video->scenario = 'edit';
        if($video->load($data) && $video->validate()){
            if(!$video->save(false)){
                return false;
            }
            if(!empty($video->oldVideo)){
                //删除旧的文件
                $block = str_replace(Yii::$app->params['oss']['host'], '', $video->oldVideo);
                $upload = new ImageUpload([]);
                $upload->deleteImage($block);
            }
        }
        return false;
    }
    
    public static function del(Video $video)
    {
        $video->isDelete = 1;
        return $video->save(false);
    }
    
    
    public function getPageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()->select([])->joinWith('categorys')->where([self::tableName().'.isDelete'=>0])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data)){
            if(!empty($this->search)){
                if(!empty($this->search['descr'])){
                    $query= $query->andWhere(['like','descr',$this->search['descr']]);
                }
                if(!empty($this->search['categoryId'])){
                    $query= $query->andWhere('categoryId = :categoryId',[':categoryId'=>$this->search['categoryId']]);
                }
                if(!empty($this->search['provider'])){
                    $query= $query->andWhere(['like','provider',$this->search['provider']]);
                }
                if(!empty($this->search['createTimeStart'])){
                    $query= $query->andWhere(self::tableName().'.modifyTime >= :starttime',[':starttime'=>strtotime($this->search['createTimeStart'])]);
                }
                if(!empty($this->search['createTimeEnd'])){
                    $query= $query->andWhere(self::tableName().'.modifyTime <= :endtime',[':endtime'=>strtotime($this->search['createTimeEnd'])]);
                }
            }
        }
        $result = $this->query($query, $this->curPage, $this->pageSize);
        return $result;
    }
    
    public function getCategorys()
    {
    	return $this->hasOne(Category::className(), ['id'=>'categoryId']);
    }
}