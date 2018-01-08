<?php
namespace common\models;



class Photo extends BaseModel
{
    public $oldFile;
    
	public static function tableName()
	{
		
		return '{{%photo}}';
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
}