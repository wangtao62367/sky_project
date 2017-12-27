<?php
namespace backend\controllers;



use common\controllers\CommonController;

/**
 * 教师管理
 * @author wt
 *
 */
class TeacherController extends CommonController
{
    
    public function actionTeachers()
    {
        
        return $this->render('teachers');
    }
    
}