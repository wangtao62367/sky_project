<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Article;
use common\models\Category;
use common\models\ArticleTag;
use common\publics\ImageUpload;

/**
 * @name 文章管理
 * @author wangt
 *
 */
class ArticleController extends CommonController
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
                    "imagePathFormat" => "upload/article/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => '',//Yii::getAlias("@frontend").'/web',
                    
                	"videoFieldName"=> "upfile",
                    "videoUrlPrefix"  => Yii::$app->params['oss']['host'],//图片访问路径前缀
                    "videoPathFormat" => "upload/video/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "videoAllowFiles" => ['.mp4'],
                    "videoMaxSize"    => 1024*1024*1024
                    
                ],
            ]
        ];
    }
    /**
     * @desc 文章列表
     * @return string
     */
    public function actionArticles()
    {
        $article = new Article();
        $request = Yii::$app->request;
        $handle =Yii::$app->request->get('handle','');
        if(strtolower(trim($handle)) == 'export'){
        	
        	$data = $request->get();
        	$article->getArticlesByExport($data);
        	Yii::$app->end();
        	exit();
        }
        
        $parentCates = Category::getArticleCates();
        $result = $article->articles($request->get(),$request->get());
        return $this->render('articles',['model'=>$article,'parentCates'=>$parentCates,'list'=>$result]);
    }
    
    /**
     * @desc 创建文章
     * @return unknown
     */
    public function actionCreate()
    {
        $article = new Article();
        $parentCates = Category::getArticleCates();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            
            //先上传图片 再写数据
            if(isset($_FILES['image']) && !empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => false,
                    'imagePath'    => 'article'
                ]);
                $result = $upload->Upload('image');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $post['Article']['titleImg'] = $imageName;
            }
            
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
    /**
     * @desc 编辑文章
     * @param int $id
     * @return \yii\web\Response|string
     */
    public function actionEdit(int $id)
    {
        $article = Article::find()->where('id = :id',[':id'=>$id])->one();
        $tags = ArticleTag::find()->joinWith('tags')->where('articleId = :articleId',[':articleId'=>$id])->asArray()->all();
        $article->tags = array_column(array_column($tags, 'tags'), 'tagName');
        $parentCates = Category::getArticleCates();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            //先上传图片 再写数据
            if(isset($_FILES['image']) && !empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => false,
                    'imagePath'    => 'article'
                ]);
                $result = $upload->Upload('image');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $post['Article']['titleImg'] = $imageName;
                if(!empty($article->titleImg)){
                    //删除旧的文件
                    $block = str_replace(Yii::$app->params['oss']['host'], '', $article->titleImg);
                    $upload->deleteImage($block);
                }
            }

            $model = new Article();
            $result = $model->edit($post, $article);

            if($result){
                return $this->showSuccess('article/articles');
            }else {
                Yii::$app->session->setFlash('error',array_values($article->getFirstErrors())[0]);
            }
        }
        return $this->render('create',['model'=>$article,'parentCates'=>$parentCates,'title'=>'编辑文章']);
    }
    /**
     * @desc 删除文章
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDel(int $id)
    {
        $article = Article::findOne($id);
        if(empty($article)){
            return $this->showDataIsNull('article/articles');
        }
        if(Article::del($article)){
            return $this->redirect(['article/articles']);
        }
    }
    /**
     * @desc 批量删除文章
     * @return number
     */
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Article::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }
    /**
     * @desc 发布文章
     * @param int $id
     * @param string $type
     * @return boolean
     */
    public function actionPublish(int $id,string $type)
    {
        Yii::$app->response->format = 'json';
        $isPublish = 0;
        if($type == 'publish'){
            $isPublish = 1;
        }
        return (bool)Article::updateAll(['isPublish' => $isPublish],'id = :id',[':id'=>$id]);
    } 
    /**
     * @desc 远程采集文章
     * @param string $sourceLinke
     * @return boolean[]|string[]
     */
    public function actionConllectContent(string $sourceLinke)
    {
        $this->setResponseJson();
        $resutlt = Article::conllectDivContent($sourceLinke);
        return $resutlt;
    }
    
    /**
     * @desc 文章导出
     */
    public function actionExport()
    {
        $article = new Article();
        $data = Yii::$app->request->get();
        $result = $article->getArticlesByExport($data);
        //var_dump($result);
    }
    
}