<?php

namespace backend\controllers;


use Yii;
use common\controllers\CommonController;
use common\models\Vote;
use common\models\VoteOptions;
/**
 * @name 投票题管理
 * @author wangt
 *
 */
class VoteController extends CommonController
{
    /**
     * @desc 投票题列表
     * @return string
     */
    public function actionVotes()
    {
        $vote = new Vote();
        $get = Yii::$app->request->get();
        $search = Yii::$app->request->post();
        $data = $vote->votes($get,$search);
        return $this->render('votes',['model'=>$vote,'list'=>$data]);
    }
    /**
     * @desc 添加投票题
     * @return \yii\web\Response|string
     */
    public function actionAdd()
    {
        $vote = new Vote();
        $vote->selectType = 'single';
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($vote->add($post)){
                return $this->redirect(['vote/votes']);
            }
            Yii::$app->session->setFlash('error',$vote->getErrorDesc());
        }
        return $this->render('add',['model'=>$vote]);
    }
	/**
	 * @desc 编辑投票题
	 * @param int $id
	 * @return string
	 */
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
            if($vote->load($post) && $vote->validate() &&
                $vote->save(false) && Vote::batchAddVoteOptions($vote->voteoptions,$vote->id)){
                    Yii::$app->session->setFlash('success','编辑成功');;
            }else{
                Yii::$app->session->setFlash('error',array_values($vote->getFirstErrors())[0]);
            }
        }
        return $this->render('add',['model'=>$vote]);
    }
    
    private function actionView(int $id)
    {
        $data  = Vote::getView($id);
        return $this->render('view',['data'=>$data]);
    }
    
    private function actionTest()
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
    
   
}