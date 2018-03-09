<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Common;
/**
 * @name 底部链接分类管理
 * @author wt  (后期新增的 ；之前一直认为是定好的，现在需要对其进行管理)
 *
 */
class BottomcateController extends CommonController
{
    
    /**
     * @desc 底部链接分类列表
     */
    public function actionManage()
    {
        $model = new Common();
        $data = Yii::$app->request->get();
        $list = $model->pageList($data);
        return $this->render('manage',['model'=>$model,'list'=>$list]);
    }
    
    
    /**
     * @desc 添加底部链接分类
     * @return \yii\web\Response|string
     */
    public function actionAdd()
    {
        $model= new Common();
        $model->type = 'bottomLink';
        $model->typeDesc = '底部链接';
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = $model->add($data);
            if(!$result){
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }else{
                return $this->showSuccess('bottomcate/manage');
            }
        }
        return $this->render('add',['model'=>$model,'title'=>'添加底部链接分类','oprate'=>'add']);
    }
    /**
     * @desc 编辑底部链接分类
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEdit(int $id)
    {
        $model = Common::findOne($id);
        if(empty($model)){
            return $this->showDataIsNull('bottomcate/manage');
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if(Common::edit($data, $model)){
                return $this->showSuccess('bottomcate/manage');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$model,'title'=>'编辑底部链接分类','oprate'=>'edit']);
    }
    /**
     * @desc 删除底部链接分类
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDel(int $id)
    {
        $model= Common::findOne($id);
        if(empty($model)){
            return $this->showDataIsNull('bottomcate/manage');
        }
        if(Common::del($model)){
            return $this->redirect(['bottomcate/manage']);
        }
    }
    /**
     * @desc 批量删除底部链接分类
     * @return number
     */
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Common::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }
    
}