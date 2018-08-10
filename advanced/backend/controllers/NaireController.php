<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\Naire;
use common\models\VoteUser;

/**
 * @name 问卷调查管理
 * @author wt
 *
 */
class NaireController extends CommonController
{
    /**
     * @desc 问卷列表
     * @return string
     */
    public function actionManage()
    {
        $naire = new Naire();
        $request = Yii::$app->request;
        $result = $naire->getPageList($request->get(),$request->get());
        return $this->render('manage',['model'=>$naire,'list'=>$result]);
    }
    /**
     * @desc 添加问卷
     * @return number|string
     */
    public function actionAdd()
    {
        $naire = new Naire();
        if(Yii::$app->request->isAjax){
            $this->setResponseJson();
            $post = Yii::$app->request->post();
            $result = $naire->add(['Naire'=>$post]);
            if($result) return 1;
            return 0;
        }
        $naire->isPublish = 0;
        return $this->render('add',['model'=>$naire,'title'=>'创建问卷']);
    }
    /**
     * @desc 编辑问卷
     * @param int $id
     * @return \yii\web\Response|number|string
     */
    public function actionEdit(int $id)
    {
        $naire= Naire::getNaireById($id);
        if(empty($naire)){
            return $this->showDataIsNull('naire/manage');
        }
        if(Yii::$app->request->isAjax){
            $this->setResponseJson();
            $post = Yii::$app->request->post();
            $result = Naire::edit(['Naire'=>$post],$naire);
            if($result) return 1;
            return 0;
        }
        
        return $this->render('add',['model'=>$naire,'title'=>'编辑试卷']);
    }
    
    /**
     * @desc 删除问卷
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDel(int $id)
    {
        $naire= Naire::findOne($id);
        if(empty($naire)){
            return $this->showDataIsNull('naire/manage');
        }
        if(Naire::del($naire)){
            return $this->redirect(['naire/manage']);
        }
    }
    
    /**
     * @desc 批量删除问卷
     * @return number
     */
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return Naire::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }
    
    /**
     * @desc 统计问卷调查
     * @param int $id
     */
    public function actionStatistics(int $id)
    {
        $naire= Naire::getNaireById($id);
        if(empty($naire)){
            return $this->showDataIsNull('naire/manage');
        }
        //获取参与投票的总人数
        
        $count = VoteUser::find()->where(['naireId'=>$id])->groupBy('voteId,userId')->count('id');
        
        
        return $this->render('statistics',['info'=>$naire,'count'=>$count]);
    }
    
}