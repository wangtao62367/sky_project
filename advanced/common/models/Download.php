<?php
namespace common\models;



use Yii;
use common\publics\ImageUpload;

/**
 * 下载中心
 * @author wt
 *
 */
class Download extends BaseModel
{
    
    public $oldUri;
	
	public static function tableName()
	{
		return '{{%Download}}';
	}
	
	public function rules()
	{
		return [
				['descr','required','message'=>'文件名不能为空','on'=>['add','edit']],
				['categoryId','required','message'=>'视频分类不能为空','on'=>['add','edit']],
				['uri','required','message'=>'文件下载路径不能为空','on'=>['add','edit']],
				[['search','oldUri','remarks','provider','leader','remarks'],'safe']
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
	
	public static function edit(array $data,Download $download)
	{
		$download->scenario = 'edit';
		if($download->load($data) && $download->validate()){
			if($download->save(false)){
			    if(!empty($download->oldUri)){
			        //删除旧的文件
			        $block = str_replace(Yii::$app->params['oss']['host'], '', $download->oldUri);
			        $upload = new ImageUpload([]);
			        $upload->deleteImage($block);
			    }
			}
		}
		return true;
	}
	
	public static function del(Download $download)
	{
		return (bool)$download->delete();
	}
	
	
	public function getPageList(array $data)
	{
		$this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
		$query = self::find()->select([])->joinWith('categorys')->orderBy('createTime desc,modifyTime desc');
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