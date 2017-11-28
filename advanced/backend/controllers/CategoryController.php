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
        $cate->positions = 'normal';
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
    
    public function actionEdit(int $id)
    {
        $cate= Category::find()->where('id=:id and isDelete = 0',[':id'=>$id])->one();
        if(empty($cate)){
            exit();
        }
        $parentCates = $cate->getParentCate(0);
        if(Yii::$app->request->isPost){
            $cate->scenario = 'edit';
            $post = Yii::$app->request->post();
            if(!$cate->load($post) || !$cate->validate()){
                Yii::$app->session->setFlash('error',array_values($cate->getFirstErrors())[0]);
            }else{
                $cate->modifyTime = TIMESTAMP;
                if($cate->save(false)){
                    Yii::$app->session->setFlash('success','保存成功');
                }
            }
        }
        return $this->render('create',['model'=>$cate,'parentCates'=>$parentCates]);
    }
    
    public function actionEditByAjax(int $id,string $text)
    {
        Yii::$app->response->format = 'json';
        
        return (bool)Category::updateAll(['text'=>$text,'modifyTime'=>TIMESTAMP],'id = :id',[':id'=>$id]);
    }
    
    public function actionCategoris()
    {
        $cate= new Category();
        $get = Yii::$app->request->get();
        $search = Yii::$app->request->post();
        $data = $cate->categoris($get,$search);
        return $this->render('categoris',['model'=>$cate,'list'=>$data]);
    }
    
    public function actionDel(int $id)
    {
        $cate= new Category();
        $result = $cate->del($id);
        if($result){
            return $this->redirect(['category/categoris']);
        }
    }
    
}