<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Article;
use common\models\Category;

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
        
        return $this->render('articles');
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
}