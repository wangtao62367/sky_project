<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Personage;
use common\models\Common;
use common\publics\ImageUpload;
/**
 * @name 社院人物管理
 * @author wt
 *
 */
class PersonageController extends CommonController
{
    /**
     * @desc 社院人物列表
     * @return string
     */
    public function actionManage()
    {
        $model = new Personage();
        $data = Yii::$app->request->get();
        $list = $model->getList($data);
        return $this->render('manage',['model'=>$model,'list'=>$list]);
    }
    
    /**
     * @desc 添加社院人物
     * @return \yii\web\Response|string
     */
    public function actionAdd()
    {
        $model = new Personage();
        $search = Yii::$app->request->get('Personage');
        $role = isset($search['search']['role']) ? $search['search']['role'] : 'zkjs';
        $model->role = $role;
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            //上传图片
            if(empty($_FILES) || !isset($_FILES['files']) || !isset($_FILES['files']['name'])){
                Yii::$app->session->set('error', '人物头像不能为空');
            }
            $upload = new ImageUpload([
                'imageMaxSize' => 1024*1024*500,
                'imagePath'    => 'personage',
                'isWatermark'  => false
            ]);
            $result = $upload->Upload('files');
            $imageName = Yii::$app->params['oss']['host'].$result;
            $data['Personage']['photo'] = $imageName;
            if($model->add($data)){
                return $this->showSuccess('personage/manage?Personage[search][role]='.$role);
            }else{
                Yii::$app->session->set('error', $model->getErrorDesc());
            }
        }
        $roles = Common::getCommonListByType('personage');
        return $this->render('add',['model'=>$model,'roles'=>$roles,'title'=>'添加社院人物']);
    }
    /**
     * @desc 编辑社院人物
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEdit(int $id)
    {
        $personage = Personage::findOne($id);
        $role= Yii::$app->request->get('role','zkjs');
        if(empty($personage)){
            return $this->showDataIsNull('personage/manage?Personage[search][role]='.$role);
        }
        $personage->role = $role;
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            
            //上传图片
            if(!empty($_FILES) && isset($_FILES['files']) && isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])){
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'imagePath'    => 'personage',
                    'isWatermark'  => false
                ]);
                $result = $upload->Upload('files');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $data['Personage']['photo'] = $imageName;
                //并且删除老的头像
                $block = str_replace(Yii::$app->params['oss']['host'], '', $personage->photo);
                $upload->deleteImage($block);
            }
            if(Personage::edit($data, $personage)){
                return $this->showSuccess('personage/manage?Personage[search][role]='.$role);
            }else{
                Yii::$app->session->set('error', $personage->getErrorDesc());
            }
        }
        
        $roles= Common::getCommonListByType('personage');
        return $this->render('add',['model'=>$personage,'roles'=>$roles,'title'=>'编辑社院人物']);
    }
    /**
     * @desc 删除社院人物
     * @param int $id
     * @return unknown
     */
    public function actionDel(int $id)
    {
        $personage = Personage::findOne($id);
        if(empty($personage)){
            return $this->showDataIsNull('personage/manage');
        }
        if(Personage::del($personage)){
            $upload = new ImageUpload([
                'imageMaxSize' => 1024*1024*500,
                'imagePath'    => 'personage',
                'isWatermark'  => false
            ]);
            //并且删除老的头像
            $block = str_replace(Yii::$app->params['oss']['host'], '', $personage->photo);
            $upload->deleteImage($block);
            return $this->redirect(['personage/manage']);
        }
    }
    /**
     * @desc 批量删除社院人物
     * 
     */
    public function actionBatchDel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        $personages = Personage::find()->select('photo')->where(['in',id,$idsArr])->asArray()->all();
        if(Personage::deleteAll(['in','id',$idsArr])){
            //删除头像
            $upload = new ImageUpload([
                'isWatermark'  => false
            ]);
            $blocks = array_filter(array_column($personages, 'photo'));
            $blocks = str_replace(Yii::$app->params['oss']['host'], '', $blocks);
            $upload->deleteImages($blocks);
        }
        
    }
}