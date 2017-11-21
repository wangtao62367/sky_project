<?php

namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Vote;

class VoteController extends CommonController
{
    
    public function actionVotes()
    {
        $vote = new Vote();
        $get = Yii::$app->request->get();
        $search = Yii::$app->request->post();
        $data = $vote->votes($get,$search);
        return $this->render('votes',['model'=>$vote,'list'=>$data]);
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