<?php
namespace backend\controllers;





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
    
}