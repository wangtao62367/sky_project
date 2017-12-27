<?php
namespace backend\controllers;



use common\controllers\CommonController;
use common\models\TeachPlace;

/**
 * 教学点管理
 * @author wt
 *
 */
class TeachplaceController extends CommonController
{
    
    public function actionPlaces()
    {
        $teachPlace = new TeachPlace();
        
        $data = ['TeachPlace' => [
            'curPage' =>1,
            'pageSize' => 10
        ]];
        
        $list = $teachPlace->pageList($data);
        if(empty($list)){
            
        }
        return $this->render('places',['model'=>$teachPlace,'list'=>$list]);
    }
    
}