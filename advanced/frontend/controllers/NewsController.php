<?php
namespace frontend\controllers;




use Yii;
use frontend\logic\NewsLogic;
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
        
        
    }
    
    
}