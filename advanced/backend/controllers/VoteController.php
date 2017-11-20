<?php

namespace backend\controllers;


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
        
//         $result = $vote->add(['Vote'=>[
//             'subject' => '这次十九大给你最好的地方在哪里呢？',
//             'startDate' => '2017-11-17',
//             'endDate' => '2017-12-05',
//             'selectType' => 'single',
//             'voteoptions' => [
//                 '选项一','选项二','选项三'
//             ]
//         ]]);
//         if(!$result){
//             var_dump($vote->getErrors());
//         }
        $vote->selectType = 'single';
        return $this->render('add',['model'=>$vote]);
    }
}