<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Category;
/**
 * @name 分类管理
 * @author wangt
 *
 */
class CategoryController extends CommonController
{
    /**
     * @desc 添加分类
     * @return \yii\web\Response|string
     */
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
    /**
     * @desc 编辑分类
     * @param int $id
     * @return \yii\web\Response|string
     */
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
    
    private function actionEditByAjax(int $id,string $text)
    {
        Yii::$app->response->format = 'json';
        
        return (bool)Category::updateAll(['text'=>$text,'modifyTime'=>TIMESTAMP],'id = :id',[':id'=>$id]);
    }
    /**
     * @desc 分类列表
     * @return string
     */
    public function actionManage()
    {
        $cate= new Category();
        $get = Yii::$app->request->get();
        $list = $cate->categoris($get);
        $parentCates = $cate->getParentCate();
        return $this->render('manage',['model'=>$cate,'list'=>$list,'parentCates'=>$parentCates]);
    }
    /**
     * @desc 删除分类
     * @param int $id
     * @return \yii\web\Response
     */
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
    /**
     * @desc 批量删除分类
     * @return number
     */
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Category::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }

    
}