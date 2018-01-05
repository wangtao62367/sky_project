<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\TeachPlace;

/**
 * 教学点管理
 * @author wt
 *
 */
class TeachplaceController extends CommonController
{
    
    public function actionManage()
    {
        $teachPlace = new TeachPlace();
        $data = Yii::$app->request->get();
        $list = $teachPlace->pageList($data);
        return $this->render('manage',['model'=>$teachPlace,'list'=>$list]);
    }
    
    public function actionAdd()
    {
        $teachPlace = new TeachPlace();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = $teachPlace->create($data);
            if(!$result){
                Yii::$app->session->setFlash('error',$teachPlace->getErrorDesc());
            }else{
                return $this->showSuccess('teachplace/manage');
            }
        }
        return $this->render('add',['model'=>$teachPlace,'title'=>'添加教学点']);
    }
    
    public function actionEdit(int $id)
    {
        $teachPlace = TeachPlace::findOne($id);
        if(empty($teachPlace)){
            return $this->showDataIsNull('teachplace/manage');
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if(TeachPlace::edit($data, $teachPlace)){
                return $this->showSuccess('teachplace/manage');
            }else{
                Yii::$app->session->setFlash('error',$teachPlace->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$teachPlace,'title'=>'编辑教学点']);
    }
    
    public function actionDel(int $id)
    {
        $teachPlaceInfo= TeachPlace::findOne($id);
        if(empty($teachPlaceInfo)){
            return $this->showDataIsNull('teachplace/manage');
        }
        if(TeachPlace::del($id, $teachPlaceInfo)){
            return $this->redirect(['teachplace/manage']);
        }
    }
    
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return TeachPlace::updateAll(['isDelete'=>TeachPlace::TEACHPLACE_DELETE],['in','id',$idsArr]);
    }
    
    public function actionAjaxPlaces(string $keywords)
    {
        $keywords = trim($keywords);
        $this->setResponseJson();
        $result = TeachPlace::find()->select(['id','text'=>'text'])->where(['and',['isDelete'=>0],['like','text',$keywords]])->asArray()->all();
        return $result;
    }
}