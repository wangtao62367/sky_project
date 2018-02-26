<?php
namespace backend\controllers;




use Yii;
use common\controllers\CommonController;
use common\models\Carousel;
/**
 * @name 首页轮播管理
 * @author desc
 *
 */
class CarouselController extends CommonController
{
    
    
    public function actionManage()
    {
        $carousel = new Carousel();
        $result = $carousel->getList();
        return $this->render('manage',['list'=>$result]);
    }
    
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
    
}