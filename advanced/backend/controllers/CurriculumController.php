<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Curriculum;
/**
 * @name 课程管理
 * @author wangtao
 *
 */
class CurriculumController extends CommonController
{
	/**
	 * @desc 课程列表
	 * @return string
	 */
	public function actionManage()
	{
		$curriculum = new Curriculum();
		$data = Yii::$app->request->get();
		//导出操作
		$export = Yii::$app->request->get('handle','');
		if(strtolower(trim($export)) == 'export'){
			$result = $curriculum->export($data);
			Yii::$app->end();exit();
		}
		$list = $curriculum->pageList($data);
		
		return $this->render('manage',['model'=>$curriculum,'list'=>$list]);
	}
	/**
	 * @desc 添加课程
	 * @return \yii\web\Response|string
	 */
	public function actionAdd()
	{
	    $curriculum = new Curriculum();
	    $curriculum->isRequired = 0;
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        $result = $curriculum->create($data);
	        if(!$result){
	            Yii::$app->session->setFlash('error',$curriculum->getErrorDesc());
	        }else{
	            return $this->showSuccess('curriculum/manage');
	        }
	    }
	    return $this->render('add',['model'=>$curriculum,'title'=>'添加课程']);
	}
	/**
	 * @desc 编辑课程
	 * @param int $id
	 * @return \yii\web\Response|string
	 */
	public function actionEdit(int $id)
	{
	    $curriculum = Curriculum::findOne($id);
	    if(empty($curriculum)){
	        return $this->showDataIsNull('curriculum/manage');
	    }
	    if(Yii::$app->request->isPost){
	        $data = Yii::$app->request->post();
	        if(Curriculum::edit($data, $curriculum)){
	            return $this->showSuccess('curriculum/manage');
	        }else{
	            Yii::$app->session->setFlash('error',$curriculum->getErrorDesc());
	        }
	    }
	    return $this->render('add',['model'=>$curriculum,'title'=>'编辑课程']);
	}
	/**
	 * @desc 删除课程
	 * @param int $id
	 * @return \yii\web\Response
	 */
	public function actionDel(int $id)
	{
	    $curriculum= Curriculum::findOne($id);
	    if(empty($curriculum)){
	        return $this->showDataIsNull('curriculum/manage');
	    }
	    if(Curriculum::del($id, $curriculum)){
	        return $this->redirect(['curriculum/manage']);
	    }
	}
	/**
	 * @desc 批量删除课程
	 * @return number
	 */
	public function actionBatchdel()
	{
	    $this->setResponseJson();
	    $ids = Yii::$app->request->post('ids');
	    $idsArr = explode(',',trim($ids,','));
	    return Curriculum::updateAll(['isDelete'=>Curriculum::CURRICULUM_DELETE],['in','id',$idsArr]);
	}
	/**
	 * @desc ajax获取课程列表
	 * @param string $keywords
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public function actionAjaxCurriculums(string $keywords)
	{
	    $keywords = trim($keywords);
	    $this->setResponseJson();
	    $result = Curriculum::find()->select(['id','text'=>'text'])->where(['and',['isDelete'=>0],['like','text',$keywords]])->asArray()->all();
	    return $result;
	}
	
	/**
	 * @desc 导出课程列表
	 */
	public function actionExport()
	{
	    $curriculum= new Curriculum();
	    $data = Yii::$app->request->get();
	    $curriculum->export($data);
	}
}