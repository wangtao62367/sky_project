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
        $result = $staisticsModel->students($data);
        $export = Yii::$app->request->get('handle','');
        if(strtolower(trim($export)) == 'export'){
            $staisticsModel->exportStudent($result);
            Yii::$app->end();exit();
        }
        $yearMonth = Statistics::makeYearAndMonth();
        return $this->render('student',['model'=>$staisticsModel,'yearMonth'=>$yearMonth,'result'=>$result]);
    }
    
    
}