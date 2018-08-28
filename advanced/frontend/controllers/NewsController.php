<?php
namespace frontend\controllers;




use Yii;
use frontend\logic\NewsLogic;
use common\models\Common;
use common\models\Category;
use common\models\Article;
use common\models\CategoryType;
use common\models\Video;
use common\models\Photo;
use common\models\Download;
use common\models\Personage;
use common\models\SchooleInformation;
use common\models\GradeClass;
use common\models\Naire;
use common\models\Schedule;
use common\models\FamousTeacher;
/**
 * 新闻
 * @author 
 *
 */
class NewsController extends CommonController
{
    
    
    public function actionDetail(int $id)
    {
        $currentNews = NewsLogic::getDetail($id);
        if(empty($currentNews)){
            exit('不存在该新闻');
        }
        $data = [
            'current' => $currentNews,
            'pre' => NewsLogic::getPreByCurrent($currentNews),
            'next'=> NewsLogic::getNextByCurrent($currentNews),
            'crumbs' => NewsLogic::getCrumbs($currentNews),
        ];
        return $this->render('detail',['data'=>$data]);
    }
    
    public function actionList()
    {
        $pid = Yii::$app->request->get('pid',0);
        $pcode = Yii::$app->request->get('pcode','');
        //信息化建设模块  临时处理
        if($pid == 12){
            return $this->redirect(Yii::$app->params['xbjs.link']);
        }
        $cateid = Yii::$app->request->get('cateid',0);
        
        $parent = Common::find()->select(['id','codeDesc','code'])->where(['or',['id'=>$pid],['code'=>$pcode]])->one();
        
        Yii::$app->view->params['pid'] = $parent->id;
        Yii::$app->view->params['pcode'] = $parent->code;
        //父级分类为  文化学院模块 
        if($parent->code == 'whxy' && $cateid == 0){
            $this->layout = 'whxy';
            $info = SchooleInformation::findOne(['type'=>CategoryType::WHXYJJ]);
            $data = [
                'info' => $info,
                'whjl' => NewsLogic::getWhjlList(),
                'whlt' => NewsLogic::getWhltList(),
                'tzgs' => NewsLogic::getTzgs(),
                'wxsh' => NewsLogic::getWxsh()
            ];
            return $this->render('whxy',['data'=>$data]);
        }
        
        $cateList = Category::find()->select(['id','text','parentId','type'])->where(['parentId'=>$parent->id,'isDelete'=>0])->orderBy('isBase desc,modifyTime ASC')->all();
       
        if($cateid == 0 && !empty($cateList)){
            
            $cateid = $cateList[0]->id;
        }
        
        $currentCate = Category::find()->select(['id','text','cateCode','parentId','type'])->where(['id'=>$cateid])->one();
        //var_dump($currentCate);exit();
        $data = Yii::$app->request->get();
        
        //先判断当前分类是否是特殊页面类型
        //发展历程 | 社院风采 | 学院简介 | 学院地址 | 组织机构 | 智库简介（智库中心）
        if ($currentCate->cateCode == CategoryType::FZLC || $currentCate->cateCode == CategoryType::SYFC ||
            $currentCate->cateCode == CategoryType::XYJJ || $currentCate->cateCode == CategoryType::XYDZ || 
            $currentCate->cateCode == CategoryType::ZZJG || $currentCate->cateCode == CategoryType::ZKZX || 
            $currentCate->cateCode == CategoryType::QQGH || $currentCate->cateCode == CategoryType::GWWYH){
                
                $info = SchooleInformation::findOne(['type'=>$currentCate->cateCode]);
                
                return $this->render('schoolinfo',['parent'=>$parent,'cateList'=>$cateList,'info'=>$info,'currentCate'=>$currentCate]);
                
        }else {
            $list = $this->getNewsList($currentCate, $data);
        }
        //var_dump($list);exit();
        return $this->render('list',['parent'=>$parent,'cateList'=>$cateList,'list'=>$list,'currentCate'=>$currentCate]);
    }
    
    public function actionListByCatecode()
    {
        $cateCode = Yii::$app->request->get('code','');
        if($cateCode == ''){
            return $this->render('/site/error');
        }
        $currentCate = Category::find()->select(['id','text','cateCode','parentId','type'])->where(['cateCode'=>$cateCode])->one();
        $parent = Common::find()->select(['id','codeDesc','code'])->where(['id'=>$currentCate->parentId])->one();
        $cateList = Category::find()->select(['id','text','parentId','type'])->where(['isDelete'=>0,'parentId'=>$currentCate->parentId])->orderBy('isBase desc,modifyTime ASC')->all();
        
        Yii::$app->view->params['pid'] = $parent->id;
        Yii::$app->view->params['pcode'] = $parent->code;
        $data = Yii::$app->request->get();
        //先判断当前分类是否是特殊页面类型
        //发展历程 | 社院风采 | 学院简介 | 学院地址 | 组织机构 | 智库简介（智库中心）
        if ($currentCate->cateCode == CategoryType::FZLC || $currentCate->cateCode == CategoryType::SYFC ||
            $currentCate->cateCode == CategoryType::XYJJ || $currentCate->cateCode == CategoryType::XYDZ ||
            $currentCate->cateCode == CategoryType::ZZJG || $currentCate->cateCode == CategoryType::ZKZX ||
            $currentCate->cateCode == CategoryType::QQGH || $currentCate->cateCode == CategoryType::GWWYH){
                
            $info = SchooleInformation::findOne(['type'=>$currentCate->cateCode]);
                
            return $this->render('schoolinfo',['parent'=>$parent,'cateList'=>$cateList,'info'=>$info,'currentCate'=>$currentCate]);
        }else {
        	
        	$list = $this->getNewsList($currentCate, $data);
        }

        return $this->render('list',['parent'=>$parent,'cateList'=>$cateList,'list'=>$list,'currentCate'=>$currentCate]);
        
    }
    
    public function getNewsList(Category $currentCate,array $data)
    {
        //客座教授  | 现任领导  | 师资情况 |学员风采
        if($currentCate->cateCode == CategoryType::ZKJS|| $currentCate->cateCode == CategoryType::XRLD || $currentCate->cateCode == CategoryType::SZQK || $currentCate->cateCode == CategoryType::XYFC){
            $personage = new Personage();
            $personage->pageSize = 3;
            $data['Personage']['search'] = [
                'role' => $currentCate->cateCode,
            ];
            $list = $personage->getList($data);
        }elseif ($currentCate->cateCode == CategoryType::WYBM){ //我要报名页面
            $gradeclass = new GradeClass();
            $gradeclass->pageSize = 10;
            $data['GradeClass']['search'] = [
                'validdate' => date('Y-m-d')
            ];
            $list = $gradeclass->pageList($data);
            
        }elseif ($currentCate->cateCode == CategoryType::TPDC){ //投票调查
            $naire = new Naire();
            $naire->pageSize = 15;
            $data['Naire']['search'] = [
                'isPublish' => 1
            ];
            $list = $naire->getPageList($data,$data);
            
        }elseif ($currentCate->cateCode == CategoryType::KBCX){ //课表查询
            $schedule = new Schedule();
            $schedule->pageSize = 15;
            $data['Schedule']['search'] = [
                'isPublish' => 1,
            	'isDelete' => 0,
            ];
            $list = $schedule->pageList($data);
        }elseif ($currentCate->cateCode == CategoryType::MMST){
            $famousTeacher = new FamousTeacher();
            
            $famousTeacher->pageSize = 15;
            $list = $famousTeacher->getPageList($data);
        }else {
            switch ($currentCate->type){
                case CategoryType::ARTICLE :
                    $article = new Article();
                    $search['Article']['search'] = [
                        'categoryId' => $currentCate->id,
                        'isPublish'  => 1
                    ];
                    $article->pageSize = 15;
                    $list = $article->articles($data,$search);
                    break;
                case CategoryType::VIDEO:
                    $video = new Video();
                    $data['Video']['search'] = [
                        'categoryId' => $currentCate->id,
                    ];
                    $video->pageSize = 15;
                    $list = $video->getPageList($data);
                    //var_dump($list);exit();
                    break;
                case CategoryType::IMAGE:
                    $photo = new Photo();
                    $data['Photo']['search'] = [
                        'categoryId' =>$currentCate->id,
                    ];
                    $photo->pageSize = 15;
                    $list = $photo->getPageList($data);
                    break;
                case CategoryType::FILE:
                    $download = new Download();
                    $data['Download']['search'] = [
                        'categoryId' => $currentCate->id,
                    ];
                    $download->pageSize = 15;
                    $list = $download->getPageList($data);
                    break;
            }
        }
        return $list;
    }    
}