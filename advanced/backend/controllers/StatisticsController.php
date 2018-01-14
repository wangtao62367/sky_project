<?php
namespace backend\controllers;





use Yii;
use common\controllers\CommonController;
use backend\models\Statistics;

/**
 * @name 统计管理
 * @author wt
 *
 */
class StatisticsController extends CommonController
{
    /**
     * @desc 学员统计
     * @return string
     */
    public function actionStudent()
    {
        $staisticsModel = new Statistics();
        $data = Yii::$app->request->post();
        $yearMonth = Statistics::makeYearAndMonth();
        $result = $staisticsModel->students($data);
        return $this->render('student',['model'=>$staisticsModel,'yearMonth'=>$yearMonth,'result'=>$result]);
    }
    
    /**
     * @desc 答题统计
     * @return string
     */
    public function actionAnswer()
    {
        
        return $this->render('answer');
    }
    
}