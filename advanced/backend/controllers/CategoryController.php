<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Category;

class CategoryController extends CommonController
{
    
    public function actionAdd()
    {
        $cate = new Category();
        $parentCates = $cate->getParentCate();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            
            $result = $cate -> create($post);
            if(!$result){
                Yii::$app->session->setFlash('error',$cate->getErrorDesc());
            }else{
                return $this->showSuccess('category/manage');
            }
        }
        return $this->render('add',['model'=>$cate,'parentCates'=>$parentCates,'title'=>'添加分类']);
    }
    
    public function actionEdit(int $id)
    {
        $cate= Category::find()->where('id=:id and isDelete = 0',[':id'=>$id])->one();
        if(empty($cate)){
            return $this->showDataIsNull('category/manage');
        }
        $parentCates = $cate->getParentCate();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if(Category::edit($data, $cate)){
                return $this->showSuccess('category/manage');
            }else{
                Yii::$app->session->setFlash('error',$cate->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$cate,'parentCates'=>$parentCates,'title'=>'编辑分类']);
    }
    
    public function actionEditByAjax(int $id,string $text)
    {
        Yii::$app->response->format = 'json';
        
        return (bool)Category::updateAll(['text'=>$text,'modifyTime'=>TIMESTAMP],'id = :id',[':id'=>$id]);
    }
    
    public function actionManage()
    {
        $cate= new Category();
        $get = Yii::$app->request->get();
        $search = Yii::$app->request->post();
        $data = $cate->categoris($get,$search);
        $parentCates = $cate->getParentCate();
        return $this->render('manage',['model'=>$cate,'list'=>$data,'parentCates'=>$parentCates]);
    }
    
    public function actionDel(int $id)
    {
        $cate = Category::findOne($id);
        if(empty($cate)){
            return $this->showDataIsNull('category/manage');
        }
        if(Category::del($cate)){
            return $this->redirect(['category/manage']);
        }
    }
    
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Category::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }
    
}