<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Adv;
use common\publics\ImageUpload;
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
            //先上传图片 再写数据
            if(isset($_FILES['files']) && !empty($_FILES['files']) && !empty($_FILES['files']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => true
                ]);

                $result = $upload->Upload('files');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $data['Adv']['imgs'] = $imageName;
            }
            
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
            //先上传图片 再写数据
            if(isset($_FILES['files']) && !empty($_FILES['files']) && !empty($_FILES['files']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => true
                ]);
                $result = $upload->Upload('files');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $data['Adv']['imgs'] = $imageName;
            }
            
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
            return $this->showSuccess('/adv/manage');
        }
    }
    /**
     * @desc 开启广告
     * @param int $id
     */
    public function actionOpen(int $id)
    {
        $adv = Adv::findOne($id);
        if(empty($adv)){
            return $this->showDataIsNull('adv/manage');
        }
        if(Adv::open($adv)){
            return $this->redirect(['adv/manage']);
        }
    }
    /**
     * @desc 关闭广告
     * @param int $id
     */
    public function actionClose(int $id)
    {
        $adv = Adv::findOne($id);
        if(empty($adv)){
            return $this->showDataIsNull('adv/manage');
        }
        if(Adv::close($adv)){
            return $this->redirect(['adv/manage']);
        }
    }
    
}