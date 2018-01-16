<?php
namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Article;
use common\models\Category;
use common\models\ArticleTag;
use common\publics\MyHelper;
/**
 * @name 文章管理
 * @author wangt
 *
 */
class ArticleController extends CommonController
{

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
        $parentCates = Category::getArticleCates();
        $request = Yii::$app->request;

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
        $resutlt = Article::conllectContent($sourceLinke);
        return $resutlt;
    }
    
    private function actionTest()
    {
        $result = MyHelper::httpGet('http://www.zysy.org.cn/a1/a-XDGZ9E149B0016624493E2');
        
        //去除換行及空白字元（序列化內容才需使用）
        $text=str_replace(array("\r","\n","\t","\s"), '', $result);
        
        //取出div标签且id為PostContent的內容，並储存至阵列match
        preg_match('/<div[^>]*class="mod-content"[^>]*>(.*?) <\/div>/si',$text,$match);
        print_r($match);
        exit($text);
        //获取字符串编码
        $encode = mb_detect_encoding($match[0], array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        //将字符编码改为utf-8
        $str_encode = mb_convert_encoding($match[0], 'UTF-8', $encode);
        print_r($str_encode);

    }
}