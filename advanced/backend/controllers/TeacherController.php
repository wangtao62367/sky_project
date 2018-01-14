<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Teacher;

/**
 * @name 教师管理
 * @author wt
 *
 */
class TeacherController extends CommonController
{
    /**
     * @desc 教师列表
     * @return string
     */
    public function actionManage()
    {
    	$teacher = new Teacher();
    	
    	$data = Yii::$app->request->get();
    	$list = $teacher->pageList($data);
    	return $this->render('manage',['model'=>$teacher,'list'=>$list]);
    }
    /**
     * @desc 添加教师
     * @return \yii\web\Response|string
     */
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
    /**
     * @desc 编辑教师
     * @param int $id
     * @return \yii\web\Response|string
     */
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
    /**
     * @desc 删除教师
     * @param int $id
     * @return \yii\web\Response
     */
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
    /**
     * @desc 批量删除教师
     * @return number
     */
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Teacher::updateAll(['isDelete'=>Teacher::TEACHER_DELETE],['in','id',$idsArr]);
    }
    /**
     * @desc ajax获取教师列表
     * @param string $keywords
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionAjaxTeachers(string $keywords)
    {
        $keywords = trim($keywords);
        $this->setResponseJson();
        $result = Teacher::find()->select(['id','text'=>'trueName'])->where(['and',['isDelete'=>0],['like','trueName',$keywords]])->asArray()->all();
        return $result;
    }
    
    private function actionTest()
    {
        return $this->render('demo');
    }
    
}