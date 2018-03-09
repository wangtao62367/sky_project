<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\EducationBase;
use common\publics\ImageUpload;
/**
 * @name 教育基地管理
 * @author wt
 *
 */
class EducationbaseController extends CommonController
{
    /**
     * @desc 教育基地列表
     * @return string
     */
    public function actionManage()
    {
        $EducationBase = new EducationBase();
        $data = Yii::$app->request->get();
        $list = $EducationBase->pageList($data);
        return $this->render('manage',['model'=>$EducationBase,'list'=>$list]);
    }
    /**
     * @desc 添加教育基地
     * @return \yii\web\Response|string
     */
    public function actionAdd()
    {
        $EducationBase = new EducationBase();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            
            //先上传图片 再写数据
            if(isset($_FILES['image']) && !empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => false,
                    'imagePath'    => 'education'
                ]);
                $result = $upload->Upload('image');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $data['EducationBase']['baseImg'] = $imageName;
            }
            
            $result = $EducationBase->create($data);
            if(!$result){
                Yii::$app->session->setFlash('error',$EducationBase->getErrorDesc());
            }else{
                return $this->showSuccess('educationbase/manage');
            }
        }
        return $this->render('add',['model'=>$EducationBase,'title'=>'添加教学点']);
    }
    /**
     * @desc 编辑教育基地
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEdit(int $id)
    {
        $EducationBase = EducationBase::findOne($id);
        if(empty($EducationBase)){
            return $this->showDataIsNull('educationbase/manage');
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            //先上传图片 再写数据
            if(isset($_FILES['image']) && !empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => false,
                    'imagePath'    => 'education'
                ]);
                $result = $upload->Upload('image');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $data['EducationBase']['baseImg'] = $imageName;
                if(!empty($EducationBase->baseImg)){
                    //删除旧的文件
                    $block = str_replace(Yii::$app->params['oss']['host'], '', $EducationBase->baseImg);
                    $upload->deleteImage($block);
                }
            }
            if(EducationBase::edit($data, $EducationBase)){
                return $this->showSuccess('educationbase/manage');
            }else{
                Yii::$app->session->setFlash('error',$EducationBase->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$EducationBase,'title'=>'编辑教学点']);
    }
    /**
     * @desc 删除教育基地
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDel(int $id)
    {
        $EducationBaseInfo= EducationBase::findOne($id);
        if(empty($EducationBaseInfo)){
            return $this->showDataIsNull('educationbase/manage');
        }
        if(EducationBase::del($EducationBaseInfo)){
            return $this->showSuccess(['educationbase/manage']);
        }
    }
    /**
     * @desc 批量删除教育基地
     * @return number
     */
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return EducationBase::updateAll(['isDelete'=>EducationBase::EducationBase_DELETE],['in','id',$idsArr]);
    }
}