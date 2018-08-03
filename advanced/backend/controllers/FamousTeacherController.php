<?php
namespace backend\controllers;




use Yii;
use common\controllers\CommonController;
use common\models\FamousTeacher;

/**
 * @name 名师堂
 * @author wangt
 *
 */
class FamousTeacherController extends CommonController
{
    
    /**
     * @desc 文章富文本上传文件
     * {@inheritDoc}
     * @see \yii\base\Controller::actions()
     */
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'common\ijackwu\ueditor\alioss\UeditorAliossAction',//'kucha\ueditor\UEditorAction',//
                //'lang' => 'zh-cn',
                'config' => [
                    "fileUrlPrefix" => Yii::$app->params['oss']['host'],
                    "imageUrlPrefix"  => Yii::$app->params['oss']['host'],//图片访问路径前缀
                    "imagePathFormat" => "upload/famous-teacher/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => '',//Yii::getAlias("@frontend").'/web',
                    
                    "videoFieldName"=> "upfile",
                    "videoUrlPrefix"  => Yii::$app->params['oss']['host'],//图片访问路径前缀
                    "videoPathFormat" => "upload/famous-teacher/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "videoAllowFiles" => ['.mp4'],
                    "videoMaxSize"    => 1024*1024*1024
                    
                ],
            ]
        ];
    }
    
    /**
     * @desc 名师列表
     * @return string
     */
    public function actionList()
    {
        $model= new FamousTeacher();
        $get = Yii::$app->request->get();
        $list = $model->getPageList($get);

        return $this->render('list',['model'=>$model,'list'=>$list]);
    }
    
    /**
     * @desc 添加分类
     * @return \yii\web\Response|string
     */
    public function actionAdd()
    {
        $model = new FamousTeacher();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $model->create($post);
            if(!$result){
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }else{
                return $this->showSuccess('famous-teacher/list');
            }
        }
        return $this->render('add',['model'=>$model,'title'=>'添加名师']);
    }
    /**
     * @desc 编辑分类
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEdit(int $id)
    {
        $model= FamousTeacher::find()->where('id=:id',[':id'=>$id])->one();
        if(empty($model)){
            return $this->showDataIsNull('famous-teacher/list');
        }

        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if(FamousTeacher::edit($data, $model)){
                return $this->showSuccess('famous-teacher/list');
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('add',['model'=>$model,'title'=>'编辑名师']);
    }
    

    /**
     * @desc 删除分类
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDel(int $id)
    {
        $model= FamousTeacher::findOne($id);
        if(empty($model)){
            return $this->showDataIsNull('famous-teacher/list');
        }
        if(FamousTeacher::del($model)){
            return $this->redirect(['famous-teacher/list']);
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
        return FamousTeacher::deleteAll(['in','id',$idsArr]);
    }
}