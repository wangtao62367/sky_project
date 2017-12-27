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
    
    public function actionManage()
    {
        $teachPlace = new TeachPlace();
        
        $data = ['TeachPlace' => [
            'curPage' =>1,
            'pageSize' => 10
        ]];
        
        $list = $teachPlace->pageList($data);
        return $this->render('manage',['model'=>$teachPlace,'list'=>$list]);
    }
    
    public function actionEdit(int $id)
    {
    	$teachPlace = new TeachPlace();
    	
    	return $this->renderPartial('common/dialog');
    }
}