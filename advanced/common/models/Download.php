<?php
namespace common\models;




/**
 * 下载中心
 * @author wt
 *
 */
class Download extends BaseModel
{
	
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
				[['search','remarks'],'safe']
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
			return $download->save(false);
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
		$query = self::find()->select([])->orderBy('createTime desc,modifyTime desc');
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
	
	
}