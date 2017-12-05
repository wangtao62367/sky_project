<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Question;
use common\models\QuestCategory;
use common\models\QuestOptions;

class QuestionController extends CommonController
{
    
    public function actionAdd()
    {
        $model = new Question();
        $questCate = QuestCategory::getQuestCateText();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $model->add($post);
            if(!$result){
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }else {
                Yii::$app->session->setFlash('success','添加成功');
            }
        }
        $model->answerOpt =json_decode($model->answerOpt,true);
        return $this->render('add',['model'=>$model,'questCate'=>$questCate]);
    }
    
    public function actionIndex()
    {
        $model = new Question();
        $questCate = QuestCategory::getQuestCateText();
        $request= Yii::$app->request;
        $list = $model->questions($request->get(),$request->post());
        return $this->render('index',['model'=>$model,'questCate'=>$questCate,'list'=>$list]);
    }
    
    public function actionEdit(int $id)
    {
        $model = Question::getOptionById($id);
        $questCate = QuestCategory::getQuestCateText();
        $model->opts = QuestOptions::find()->select(['opt','optImg'])->where('questId = :questId',[':questId'=>$id])->asArray()->all();
        if(Yii::$app->request->isPost){
            $model->scenario = 'edit';
            $post = Yii::$app->request->post();
            if($model->load($post) && $model->validate() && 
                $model->save(false) && QuestOptions::batchAdd($model->opts, $model->id)){
                   Yii::$app->session->setFlash('success','编辑成功');;
            }else{
                Yii::$app->session->setFlash('error',array_values($model->getFirstErrors())[0]);
            }
        }
        return $this->render('add',['model'=>$model,'questCate'=>$questCate]);
    }
    
    public function actionAjaxDel(int $id)
    {
        $this->setResponseJson();
        return Question::ajaxDel($id);
    }
    
    public function actionAjaxPublish(int $id)
    {
        $this->setResponseJson();
        return Question::ajaxPublish($id);
    }
    
    public function actionAjaxUnpublish(int $id)
    {
        $this->setResponseJson();
        return Question::ajaxUnpublish($id);
    }
}