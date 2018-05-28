<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\TestPaper;
use common\models\GradeClass;
use common\models\TestPaperUserStatistics;
use common\models\TestPaperQuestionRecord;
use common\models\BmRecord;
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
    /**
     * @desc 试卷统计
     * @param int $id
     * @return \yii\web\Response|string
     */
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
    
    /**
     * @desc 查看答题详情
     * @param int $paperid
     * @param int $userid
     * @param string $mark
     * @return string
     */
    public function actionAnswerInfo(int $paperid,int $userid,string $mark)
    {
        $testPaper= TestPaper::findOne($paperid);
        if(empty($testPaper)){
            return $this->showDataIsNull('testpaper/manage');
        }
        //获取答题人姓名
        $BmRecord = BmRecord::find()->select(['trueName'])->where(['userId'=>$userid,'gradeClassId'=>$testPaper->gradeClassId])->one();
        if(empty($BmRecord)){
            return $this->showDataIsNull('testpaper/manage');
        }
        $trueNanme = $BmRecord->trueName;
        //获取用户答题统计信息
        $paperstatics = TestPaperUserStatistics::find()->where(['paperId'=>$paperid,'userId'=>$userid,'anwserMark'=>$mark])->one();
        //获取试卷答题记录信息
        $paperQuestRecord = new TestPaperQuestionRecord();
        $answers = $paperQuestRecord->getAnwserInfo($paperid, $userid, $mark);
        //var_dump($answerInfo[0]->question);exit();
        //导出excel
        $handle = Yii::$app->request->get('handle','');
        if(!empty($handle) && $handle == 'excel'){
            TestPaper::exportAnswer($testPaper,$trueNanme,$paperstatics,$answers);exit();
        }
        return $this->render('answerinfo',['testPaper'=>$testPaper,'trueName'=>$trueNanme,'paperstatics'=>$paperstatics,'answers'=>$answers]);
    }
    
}