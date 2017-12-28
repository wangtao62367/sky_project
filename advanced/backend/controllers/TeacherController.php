<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Teacher;

/**
 * 教师管理
 * @author wt
 *
 */
class TeacherController extends CommonController
{
    
    public function actionManage()
    {
    	$teacher = new Teacher();
    	
    	$data = ['Teacher' => [
    			'curPage' =>1,
    			'pageSize' => 10
    	]];
    	$list = $teacher->pageList($data);
    	return $this->render('manage',['model'=>$teacher,'list'=>$list]);
    }
    
    public function actionAdd()
    {
        $teacher = new Teacher();
        $teacher->sex = 1;
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = $teacher->create($data);
            if(!$result){
                Yii::$app->session->setFlash('error',$teacher->getErrorDesc());
            }else{
                return $this->showSuccess('teacher/manage');
            }
        }
        return $this->render('add',['model'=>$teacher,'title'=>'添加教师']);
    }
    
    public function actionEdit(int $id)
    {
        $teacher = Teacher::findOne($id);
        if(empty($teacher)){
            return $this->showDataIsNull('teacher/manage');
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if(Teacher::edit($data, $teacher)){
                return $this->showSuccess('teacher/manage');
            }else{
                Yii::$app->session->setFlash('error',$teacher->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$teacher,'title'=>'编辑教师']);
    }
    
    public function actionDel(int $id)
    {
        $teacher = Teacher::findOne($id);
        if(empty($teacher)){
            return $this->showDataIsNull('teacher/manage');
        }
        if(Teacher::del($id, $teacher)){
            return $this->redirect(['teacher/manage']);
        }
    }
    
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Teacher::updateAll(['isDelete'=>Teacher::TEACHER_DELETE],['in','id',$idsArr]);
    }
    
}