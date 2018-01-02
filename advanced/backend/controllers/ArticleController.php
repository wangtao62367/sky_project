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
                'class' => 'common\ijackwu\ueditor\alioss\UeditorAliossAction',//'kucha\ueditor\UEditorAction',//
                //'lang' => 'zh-cn',
                'config' => [
                    "fileUrlPrefix" => "http://seving-weixin.oss-cn-shenzhen.aliyuncs.com",
                    "imageUrlPrefix"  => "http://seving-weixin.oss-cn-shenzhen.aliyuncs.com",//图片访问路径前缀
                    "imagePathFormat" => "upload/article/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => '',//Yii::getAlias("@frontend").'/web',
                ],
            ]
        ];
    }
    
    public function actionArticles()
    {
        $article = new Article();
        $parentCates = Category::getArticleCates();
        $request = Yii::$app->request;

        $result = $article->articles($request->get(),$request->post());
        return $this->render('articles',['model'=>$article,'parentCates'=>$parentCates,'list'=>$result]);
    }
    
    
    public function actionCreate()
    {
        $article = new Article();
        $parentCates = Category::getArticleCates();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $article->create($post);
            if($result){
                return $this->showSuccess('article/articles');
            }else{
                Yii::$app->session->setFlash('error',$article->getErrorDesc());
            }
        }
        $article->isPublish = 0;
        return $this->render('create',['model'=>$article,'parentCates'=>$parentCates,'title'=>'添加文章']);
    }
    
    public function actionEdit(int $id)
    {
        $article = Article::find()->where('id = :id',[':id'=>$id])->one();
        $tags = ArticleTag::find()->joinWith('tags')->where('articleId = :articleId',[':articleId'=>$id])->asArray()->all();
        $article->tags = array_column(array_column($tags, 'tags'), 'tagName');
        $parentCates = Category::getArticleCates();
        if(Yii::$app->request->isPost){
            $article->scenario = 'edit';
            $post = Yii::$app->request->post();
            if(!$article->load($post) || !$article->validate()){
                Yii::$app->session->setFlash('error',array_values($article->getFirstErrors())[0]);
            }else{
                $article->modifyTime = TIMESTAMP;
                if($article->save(false) ){  //&& Article::batchAddArticleTags($article->tags,$article->id)
                    return $this->showSuccess('article/articles');
                }
            }
        }
        return $this->render('create',['model'=>$article,'parentCates'=>$parentCates,'title'=>'编辑文章']);
    }
    
    public function actionDel(int $id)
    {
        $article = Article::findOne($id);
        if(empty($article)){
            return $this->showDataIsNull('article/articles');
        }
        if(Article::del($id, $article)){
            return $this->redirect(['article/articles']);
        }
    }
    
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Article::updateAll(['isDelete'=>1],['in','id',$idsArr]);
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