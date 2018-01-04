<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\TestPaper;
/**
 * 试卷管理
 * @author wangtao
 *
 */
class TestpaperController extends CommonController
{
    
    
    public function actionManage()
    {
        $testPaper = new TestPaper();
        $request = Yii::$app->request;
        $result = $testPaper->getPageList($request->get(),$request->post());
        return $this->render('manage',['model'=>$testPaper,'list'=>$result]);
    }
    
    public function actionAdd()
    {
        $testPaper = new TestPaper();
        if(Yii::$app->request->isAjax){
            $this->setResponseJson();
            $post = Yii::$app->request->post();
            $result = $testPaper->add(['TestPaper'=>$post]);
            if($result) return 1;
            return 0;
        }
        $testPaper->publishCode = 'now';
        return $this->render('add',['model'=>$testPaper,'title'=>'创建试卷']);
    }

    public function actionEdit(int $id)
    {
    	$testPaper = TestPaper::getPaperById($id);
    	if(empty($testPaper)){
    		return $this->showDataIsNull('testpaper/manage');
    	}
    	if(Yii::$app->request->isAjax){
    	    $this->setResponseJson();
    	    $post = Yii::$app->request->post();
    	    $result = $testPaper::edit(['TestPaper'=>$post],$testPaper);
    	    if($result) return 1;
    	    return 0;
    	}
    	
    	return $this->render('add',['model'=>$testPaper,'title'=>'编辑试卷']);
    }
    
    
    public function actionDel(int $id)
    {
        $testPaper= TestPaper::findOne($id);
        if(empty($testPaper)){
            return $this->showDataIsNull('testpaper/manage');
        }
        if(TestPaper::del($testPaper)){
            return $this->redirect(['testpaper/manage']);
        }
    }
    
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return TestPaper::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }
}