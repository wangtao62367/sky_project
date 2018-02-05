<?php
namespace frontend\controllers;




use Yii;
use frontend\logic\NewsLogic;
use common\models\Common;
use common\models\Category;
use common\models\Article;
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
        $articleList = Article::find()->select(['id','title','publishTime'])->where(['categoryId'=>$cateid,'isDelete'=>0,'isPublish'=>1])->orderBy('isHot desc,publishTime desc')->all();
        
        return $this->render('list',['parent'=>$parent,'cateList'=>$cateList,'articleList'=>$articleList,'cateid'=>$cateid]);
    }
    
    
}