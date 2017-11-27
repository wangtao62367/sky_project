<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Category;

class CategoryController extends CommonController
{
    
    public function actionCreate()
    {
        $cate = new Category();
        $parentCates = $cate->getParentCate(0);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            
            $result = $cate -> create($post);
            if(!$result){
                Yii::$app->session->setFlash('error','创建失败');
            }
            Yii::$app->session->setFlash('success','创建成功');
        }
        return $this->render('create',['model'=>$cate,'parentCates'=>$parentCates]);
    }
    
}