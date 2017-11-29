<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Article;
use common\models\Category;
use common\models\ArticleTag;

class ArticleController extends CommonController
{

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://test.sky.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/article/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@frontend").'/web',
                ],
            ]
        ];
    }
    
    public function actionArticles()
    {
        $article = new Article();
        $parentCates = (new Category())->getParentCate(0);
        $request = Yii::$app->request;
        $result = $article->articles($request->get(),$request->post());
        return $this->render('articles',['model'=>$article,'parentCates'=>$parentCates,'list'=>$result]);
    }
    
    
    public function actionCreate()
    {
        $article = new Article();
        $parentCates = (new Category())->getParentCate(0);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $article->create($post);
            if($result){
                Yii::$app->session->setFlash('succuss','创建成功');
            }else{
                Yii::$app->session->setFlash('error',array_values($article->getFirstErrors())[0]);
            }
        }
        return $this->render('create',['model'=>$article,'parentCates'=>$parentCates]);
    }
    
    public function actionEdit(int $id)
    {
        $article = Article::find()->where('id = :id',[':id'=>$id])->one();
        $tags = ArticleTag::find()->joinWith('tags')->where('articleId = :articleId',[':articleId'=>$id])->asArray()->all();
        $article->tags = array_column(array_column($tags, 'tags'), 'tagName');
        $parentCates = (new Category())->getParentCate(0);
        if(Yii::$app->request->isPost){
            $article->scenario = 'edit';
            $post = Yii::$app->request->post();
            if(!$article->load($post) || !$article->validate()){
                Yii::$app->session->setFlash('error',array_values($article->getFirstErrors())[0]);
            }else{
                $article->modifyTime = TIMESTAMP;
                if($article->save(false) && Article::batchAddArticleTags($article->tags,$article->id)){
                    Yii::$app->session->setFlash('success','保存成功');
                }
            }
        }
        return $this->render('create',['model'=>$article,'parentCates'=>$parentCates]);
    }
    
    public function actionDel(int $id)
    {
        if(Article::deleteAll('id = :id',[':id'=>$id]) && ArticleTag::deleteAll('articleId = :articleId',[':articleId'=>$id])){
            return $this->redirect(['article/articles']);
        }
    }
    
    public function actionPublish(int $id,string $type)
    {
        Yii::$app->response->format = 'json';
        $isPublish = 0;
        if($type == 'publish'){
            $isPublish = 1;
        }
        return (bool)Article::updateAll(['isPublish' => $isPublish],'id = :id',[':id'=>$id]);
    }
}