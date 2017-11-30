<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Admin;

class AdminController extends CommonController
{
    
    public function actionIndex()
    {
        $admin = new Admin();
        $request = Yii::$app->request;
        $data = $admin->admins($request->get(),$request->post());
        return $this->render('index',['model'=>$admin,'list'=>$data]);
    }
    
    public function actionAdd()
    {
        $admin = new Admin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $admin->add($post);
            if($result){
                $admin->adminPwd = $admin->repass;
                Yii::$app->session->setFlash('success','添加成功');
            }else {
                Yii::$app->session->setFlash('error',array_values($admin->getFirstErrors())[0]);
            }
        }
        
        return $this->render('add',['model'=>$admin]);
    }
}