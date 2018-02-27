<?php
namespace backend\controllers;




use Yii;
use common\controllers\CommonController;
use common\models\Carousel;
use common\publics\ImageUpload;
/**
 * @name 首页轮播管理
 * @author desc
 *
 */
class CarouselController extends CommonController
{
    
    /**
     * @desc 首页轮播管理
     * @return string
     */
    public function actionManage()
    {
        $carousel = new Carousel();
        $result = $carousel->getList();
        return $this->render('manage',['list'=>$result]);
    }
    /**
     * @desc 添加轮播图
     * @return \yii\web\Response|string
     */
    public function actionAdd()
    {
        $carousel = new Carousel();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $carousel->add($post);
            if($result){
                return $this->showSuccess('carousel/manage');
            }else{
                Yii::$app->session->setFlash('error',$carousel->getErrorDesc());
            }
        }
        
        return $this->render('add',['model'=>$carousel,'title'=>'添加轮播图']);
    }
    /**
     * 编辑轮播图
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEdit(int $id)
    {
        $carousel = Carousel::findOne($id);
        if(empty($carousel)){
            return $this->showDataIsNull('carousel/manage');
        }
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if(Carousel::edit($post, $carousel)){
                return $this->showSuccess('carousel/manage');
            }else{
                Yii::$app->session->setFlash('error',$carousel->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$carousel,'title'=>'编辑轮播图']);
    }
    
    /**
     * @desc 删除轮播
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDel(int $id)
    {
        $carousel = Carousel::findOne($id);
        if(empty($carousel)){
            return $this->showDataIsNull('carousel/manage');
        }
        if(Carousel::del($carousel)){
            return $this->showSuccess('carousel/manage');
        }
        return $this->redirect(['carousel/manage']);
    }
    
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        $carousels = Carousel::find()->where(['in','id',$idsArr])->all();
        if(!empty($carousels)){
            $upload = new ImageUpload([
                'imageMaxSize' => 1024*1024*500,
                'imagePath'    => 'carousel',
                'isWatermark'  => false,
            ]);
            foreach ($carousels as $carousel){
                $img = $carousel->img;
                if(Carousel::del($carousel)){
                    if(!empty($img)){
                        //删除旧的文件
                        $block = str_replace(Yii::$app->params['oss']['host'], '',$img);
                        $upload->deleteImage($block);
                    }
                }
            }
        }
        return true;
    }
}