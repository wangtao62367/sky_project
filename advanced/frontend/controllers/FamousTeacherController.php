<?php
namespace frontend\controllers;






use common\models\FamousTeacher;

class FamousTeacherController extends CommonController
{
    
    
    public function actionShowinfo(int $id)
    {
        $info = FamousTeacher::findOne($id);
        return $this->renderAjax('showinfo',['info'=>$info]);
    }
    
}