<?php
namespace frontend\controllers;




use Yii;
use frontend\logic\NewsLogic;
use common\models\Common;
use common\models\Category;
use common\models\Article;
use common\models\CategoryType;
use common\models\Video;
use common\models\Photo;
use common\models\Download;
/**
 * 新闻
 * @author 
 *
 */
class NewsController extends CommonController
{
    
    
    public function actionDetail(int $id)
    {
        $currentNews = NewsLogic::getDetail($id);
        if(empty($currentNews)){
            exit('不存在该新闻');
        }
        $data = [
            'current' => $currentNews,
            'pre' => NewsLogic::getPreByCurrent($currentNews),
            'next'=> NewsLogic::getNextByCurrent($currentNews),
            'crumbs' => NewsLogic::getCrumbs($currentNews),
        ];
        return $this->render('detail',['data'=>$data]);
    }
    
    public function actionList()
    {
        $pid = Yii::$app->request->get('pid',0);
        $cateid = Yii::$app->request->get('cateid',0);
        
        $parent = Common::find()->select(['id','codeDesc'])->where(['id'=>$pid])->one();
        
        $cateList = Category::find()->select(['id','text','parentId','type'])->where(['parentId'=>$pid,'isDelete'=>0])->orderBy('isBase desc,modifyTime DESC')->all();
        if($cateid == 0){
            $cateid = $cateList[0]->id;
        }
        
        $currentCate = Category::find()->select(['id','text','parentId','type'])->where(['id'=>$cateid])->one();
        
        $data = Yii::$app->request->get();
        switch ($currentCate->type){
            case CategoryType::ARTICLE :
                $article = new Article();
                $data['Article']['search'] = [
                    'categoryId' => $cateid,
                    'isPublish'  => 1
                ];
                $article->pageSize = 15;
                $list = $article->articles($data);
            break;
            case CategoryType::VIDEO:
                $video = new Video();
                $data['Video']['search'] = [
                    'categoryId' => $cateid,
                ];
                $list = $video->getPageList($data);
                break;
            case CategoryType::IMAGE:
                $photo = new Photo();
                $data['Photo']['search'] = [
                    'categoryId' => $cateid,
                ];
                $list = $photo->getPageList($data);
                break;
            case CategoryType::FILE:
                $download = new Download();
                $data['Download']['search'] = [
                    'categoryId' => $cateid,
                ];
                $list = $download->getPageList($data);
                break;
        }
        //var_dump($list);exit();
        return $this->render('list',['parent'=>$parent,'cateList'=>$cateList,'list'=>$list,'currentCate'=>$currentCate]);
    }
    
    
}