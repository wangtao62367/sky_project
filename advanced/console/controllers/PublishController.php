<?php
namespace console\controllers;





use yii\console\Controller;
use common\models\Article;
use common\models\Schedule;
use common\models\TestPaper;

class PublishController extends Controller
{
    
    /**
     * 发布文章
     */
    public function actionArticle()
    {
        Article::updateAll([
            'isPublish' => 1,
            'modifyTime' => time(),
        ],'isPublish = 0 and isDelete = 0 and publishTime <= :time',[':time'=>time()]);
        echo "成功发布文章  \n";
    }
    /**
     * 发布课表
     */
    public function actionSchedule()
    {
        Schedule::updateAll([
            'isPublish' => 1,
            'modifyTime' => time(),
        ],'isPublish = 0 and isDelete = 0 and publishTime <= :time',[':time'=>time()]);
        echo "成功发布课表  \n";
    }
    /**
     * 删除课表
     */
    public function actionDelpaper()
    {
        Schedule::updateAll([
            'isDelete' => 1,
            'modifyTime' => time(),
        ],'isDelete = 0 and publishEndTime <= :time',[':time'=>time()]);
        echo "成功删除课表  \n";
    }
    /**
     * 发布试卷
     */
    public function actionPaper()
    {
        TestPaper::updateAll([
            'isPublish' => 1,
            'modifyTime' => time(),
        ],'isPublish = 0 and isDelete = 0 and publishTime <= :time',[':time'=>time()]);
        echo "成功发布试卷  \n";
    }
    
    
    
}