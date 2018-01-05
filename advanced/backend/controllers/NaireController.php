<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Naire;

/**
 * 问卷调查管理
 * @author wt
 *
 */
class NaireController extends CommonController
{
    
    public function actionManage()
    {
        $naire = new Naire();
        $request = Yii::$app->request;
        $result = $naire->getPageList($request->get(),$request->get());
        return $this->render('manage',['model'=>$naire,'list'=>$result]);
    }
    
    public function actionAdd()
    {
        $naire = new Naire();
        if(Yii::$app->request->isAjax){
            $this->setResponseJson();
            $post = Yii::$app->request->post();
            $result = $naire->add(['Naire'=>$post]);
            if($result) return 1;
            return 0;
        }
        $naire->isPublish = 0;
        return $this->render('add',['model'=>$naire,'title'=>'创建问卷']);
    }
    
    public function actionEdit(int $id)
    {
        $naire= Naire::getNaireById($id);
        if(empty($naire)){
            return $this->showDataIsNull('naire/manage');
        }
        if(Yii::$app->request->isAjax){
            $this->setResponseJson();
            $post = Yii::$app->request->post();
            $result = Naire::edit(['Naire'=>$post],$naire);
            if($result) return 1;
            return 0;
        }
        
        return $this->render('add',['model'=>$naire,'title'=>'编辑试卷']);
    }
    
    
    public function actionDel(int $id)
    {
        $naire= Naire::findOne($id);
        if(empty($naire)){
            return $this->showDataIsNull('naire/manage');
        }
        if(Naire::del($naire)){
            return $this->redirect(['naire/manage']);
        }
    }
    
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Naire::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }
    
}