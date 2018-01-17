<?php
namespace common\models;


use Yii;
use yii\helpers\ArrayHelper;
use OSS\OssClient;

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
			['photo','required','message'=>'图片不能为空','on'=>['add','edit']],
		    ['categoryId','required','message'=>'图片分类不能为空','on'=>['add','edit']],
		    ['descr','required','message'=>'图片描述不能为空','on'=>['add','edit']],
		    [['search','oldFile','link'],'safe']
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
	
	public static function edit(array $data,Photo $photo)
	{
	    $photo->scenario = 'edit';
	    if($photo->load($data) && $photo->validate()){
	        return $photo->save(false);
	    }
	    return true;
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