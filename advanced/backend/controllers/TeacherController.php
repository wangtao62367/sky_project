<?php
namespace backend\controllers;



use common\controllers\CommonController;
use common\models\Teacher;

/**
 * 教师管理
 * @author wt
 *
 */
class TeacherController extends CommonController
{
    
    public function actionManage()
    {
    	$teacher = new Teacher();
    	
    	$data = ['Teacher' => [
    			'curPage' =>1,
    			'pageSize' => 10
    	]];
    	$list = $teacher->pageList($data);
    	return $this->render('manage',['model'=>$teacher,'list'=>$list]);
    }
    
}