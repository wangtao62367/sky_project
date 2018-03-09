<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\TestPaper;
use common\models\GradeClass;
use common\models\TestPaperUserStatistics;
/**
 * @name 试卷管理
 * @author wangtao
 *
 */
class TestpaperController extends CommonController
{
    
    /**
     * @desc 试卷列表
     * @return string
     */
    public function actionManage()
    {
        $testPaper = new TestPaper();
        $request = Yii::$app->request;
        $result = $testPaper->getPageList($request->get(),$request->get());
        return $this->render('manage',['model'=>$testPaper,'list'=>$result]);
    }
    /**
     * @desc 添加试卷
     * @return number|string
     */
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
        return $this->render('add',['model'=>$testPaper,'className'=>'','title'=>'创建试卷']);
    }
	/**
	 * @desc 编辑试卷
	 * @param int $id
	 * @return \yii\web\Response|number|string
	 */
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
    	$gradeClass = GradeClass::find()->select('className')->where('id =:id',[':id'=>$testPaper->gradeClassId])->one();
    	//var_dump($gradeClass);
    	$className = $gradeClass ? $gradeClass->className : '';
    	return $this->render('add',['model'=>$testPaper,'className'=>$className,'title'=>'编辑试卷']);
    }
    
    /**
     * @desc 删除试卷
     * @param int $id
     * @return \yii\web\Response
     */
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
    /**
     * @desc 批量删除试卷
     * @return number
     */
    public function actionBatchdel()
    {
        $this->setResponseJson();
        $ids = Yii::$app->request->post('ids');
        $idsArr = explode(',',trim($ids,','));
        return TestPaper::updateAll(['isDelete'=>1],['in','id',$idsArr]);
    }
    
    public function actionStatistics(int $id)
    {
        $testPaper= TestPaper::findOne($id);
        if(empty($testPaper)){
            return $this->showDataIsNull('testpaper/manage');
        }
        $testPaperUserStatistics = new TestPaperUserStatistics();
        $data = Yii::$app->request->get();
        $data['TestPaperUserStatistics']['search']['paperId'] = $testPaper->id;
        $list = $testPaperUserStatistics->getList($data);
        return $this->render('statistics',['model'=>$testPaperUserStatistics,'list'=>$list,'paper'=>$testPaper]);
    }
    
}