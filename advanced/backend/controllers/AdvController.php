<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Adv;
/**
 * 
 * 
 * @name 广告设置管理
 * @author wt
 *
 */
class AdvController extends CommonController
{
    /**
     * @desc 广告列表
     * @return string
     */
    public function actionManage()
    {
        $model = new Adv();
        $data = Yii::$app->request->get();
        $list = $model->pageList($data);
        
        return $this->render('manage',['model'=>$model,'list'=>$list]);
    }
    
    /**
     * @desc 添加广告
     */
    public function actionAdd()
    {
        $model = new Adv();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = $model->add($data);
            if($result){
                return $this->showSuccess('adv/manage');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$model,'title'=>'添加广告']);
    }
    /**
     * @desc 编辑广告
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEdit(int $id)
    {
        $adv = Adv::findOne($id);
        if(empty($adv)){
            return $this->showDataIsNull('adv/manage');
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $result = Adv::edit($data,$adv);
            if($result){
                return $this->showSuccess('adv/manage');
            }else{
                Yii::$app->session->setFlash('error',$adv->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$adv,'title'=>'编辑广告']);
    }
    /**
     * @desc 删除广告
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDel(int $id)
    {
        $adv = Adv::findOne($id);
        if(empty($adv)){
            return $this->showDataIsNull('adv/manage');
        }
        if (Adv::del($adv)){
            return $this->redirect(['adv/manage']);
        }
    }
    
}