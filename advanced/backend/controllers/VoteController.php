<?php

namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Vote;
use common\models\VoteOptions;

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

    public function actionEdit(int $id)
    {
        $vote = Vote::find()->where('id=:id and isDelete = 0',[':id'=>$id])->one();
        if(empty($vote)){
            exit();
        }
        $voteoptions = VoteOptions::find()->select('text')->where('voteId = :voteId',[':voteId'=>$vote->id])->asArray()->all();
        $vote->voteoptions = array_column($voteoptions, 'text');
        if(Yii::$app->request->isPost){
            $vote->scenario = 'edit';
            $post = Yii::$app->request->post();
            if(!$vote->load($post) || !$vote->validate()){
                Yii::$app->session->setFlash('error',array_values($vote->getFirstErrors())[0]);
            }else{
                $vote->modifyTime = TIMESTAMP;
                if($vote->save(false) && Vote::batchAddVoteOptions($vote->voteoptions,$vote->id)){
                    Yii::$app->session->setFlash('success','保存成功');
                }
            }
        }
        return $this->render('add',['model'=>$vote]);
    }
    
    public function actionTest()
    {
        $phpExcel = new \PHPExcel();
        
        $objSheet = $phpExcel->getActiveSheet();
        $objSheet->setTitle('demo');
        $objSheet->setCellValue('A1','姓名')->setCellValue('B1','分数');
        $objSheet->setCellValue('A2','张三')->setCellValue('B2','89');
        
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        
        $this->exportBrowser('Excel2007', 'demo.xlsx');
        $objWriter->save('php://output');

        
    }
    
    public function exportBrowser(string $type,string $fileName)
    {
        if($type == 'Excel5'){
            header('Content-Type: application/vnd.ms-excel');
        }else {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        
    }
}