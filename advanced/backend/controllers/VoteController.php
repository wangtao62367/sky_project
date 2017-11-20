<?php

namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Vote;

class VoteController extends CommonController
{
    
    public function actionVotes()
    {
        
        return $this->render('votes');
    }
    
    public function actionAdd()
    {
        $vote = new Vote();
        $vote->selectType = 'single';
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($vote->add($post)){
                return $this->redirect(['vote/votes']);
            }
            Yii::$app->session->setFlash('error',array_values($vote->getFirstErrors())[0]);
        }
        return $this->render('add',['model'=>$vote]);
    }
}