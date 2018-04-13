<?php
namespace common\models;


use Yii;
use yii\helpers\ArrayHelper;
use OSS\OssClient;
use common\publics\ImageUpload;

class Photo extends BaseModel
{
    public $oldFile;
    
	public static function tableName()
	{
		
		return '{{%Photo}}';
	}
	
	public function rules()
	{
		return [
		    ['categoryId','required','message'=>'请选择图片分类','on'=>['add','edit']],
		    ['title','required','message'=>'图片标题不能为空','on'=>['add','edit']],
		    ['title', 'string' ,'length'=>[0,25],'tooLong'=>'图片标题最多50个字', 'tooShort'=>'图片标题最多50个字','on'=>['add','edit']],
		    [['search','oldFile','link','provider','leader','remarks'],'safe']
		];
	}
	
	
	public function add(array $data)
	{
	    $this->scenario = 'add';
	    if($this->load($data) && $this->validate()){
	        //先上传图片 再写数据
	        if(!empty($_FILES) && !empty($_FILES['files']) && !empty($_FILES['files']['tmp_name'])){
	            $upload = new ImageUpload([
	                'imageMaxSize' => 1024*1024*500
	            ]);
	            $result = $upload->Upload('files');
	            $imageName = Yii::$app->params['oss']['host'].$result;
	            $this->photo = $imageName;
	        }else{
	            Yii::$app->session->setFlash('error','图片不能为空');
	            return false;
	        }
	        return $this->save(false);
	    }
	    
	    return false;
	}
	
	public static function edit(array $data,Photo $photo)
	{
	    $photo->scenario = 'edit';
	    if($photo->load($data) && $photo->validate()){
	        //先上传图片 再写数据
	        if(!empty($_FILES) && !empty($_FILES['files']) && !empty($_FILES['files']['tmp_name'])){
	            $upload = new ImageUpload([
	                'imageMaxSize' => 1024*1024*500
	            ]);
	            $result = $upload->Upload('files');
	            $imageName = Yii::$app->params['oss']['host'].$result;
	            if(!empty($photo->photo)){
	                $block = str_replace(Yii::$app->params['oss']['host'], '', $photo->photo);
	                $upload->deleteImage($block);
	            }
	            $photo->photo = $imageName;
	        }
	        return $photo->save(false);
	    }
	    return false;
	}
	
	public static function del(Photo $photo)
	{
	    $photo->isDelete = 1;
	    return $photo->save(false);
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
	
	public static function upload($file,$oldFile = '')
	{
		//验证类型
		$ext = ['image/jpeg','image/png','image/jpg'];
		if(!ArrayHelper::isIn($file['type'], $ext)){
			return ['success'=>false,'message'=>'所选图片格式只能是jpg、png或jpeg'];
		}
		//验证大小
		$maxSize = 500 * 1024;//500KB
		if($file['size'] > $maxSize){
			return ['success'=>false,'message'=>'所选图片大小不能超过500KB'];
		}
		
		//随机字符串
		$randNum = mt_rand(1, 1000000000) . mt_rand(1, 1000000000);
		$bucket = Yii::$app->params['oss']['bucket'];
		$block = '/upload/image/'.date('Y-m-d').'/'.$randNum.'.'.str_replace('image/', '', $file['type']);
		$ossClient = new OssClient(Yii::$app->params['oss']['akey'], Yii::$app->params['oss']['skey'], Yii::$app->params['oss']['endpoint'], false);
		//开始上传
		$ossClient->uploadFile($bucket, ltrim($block,'/') , $file['tmp_name']);
		//删除老图片
		if(!empty($oldFile)){
			$oldBlock = str_replace(Yii::$app->params['oss']['host'], '', $oldFile);
			$ossClient->deleteObject($bucket, ltrim($oldBlock,'/'));
		}
		return ['success'=>true,'fileFullName'=>Yii::$app->params['oss']['host'].$block,'fileName'=>$block];
	}
}