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
        $cateid = Yii::$app->request->get('cateid',0);
        
        $parent = Common::find()->select(['id','codeDesc','code'])->where(['id'=>$pid])->one();
        //父级分类为  文化学院模块 
        if($parent->code == 'whxy'){
            $data = [
                'whjl' => NewsLogic::getWhjlList(),
                'whlt' => NewsLogic::getWhltList()
            ];
            return $this->render('whxy',['data'=>$data]);
        }
        
        $cateList = Category::find()->select(['id','text','parentId','type'])->where(['parentId'=>$pid,'isDelete'=>0])->orderBy('isBase desc,modifyTime DESC')->all();
        if(!empty($cateList) && $cateid == 0){
            $cateid = $cateList[0]->id;
        }
        
        $currentCate = Category::find()->select(['id','text','cateCode','parentId','type'])->where(['id'=>$cateid])->one();
        $data = Yii::$app->request->get();
        //先判断当前分类是否是特殊页面类型
        if ($currentCate->cateCode == CategoryType::FZLC || $currentCate->cateCode == CategoryType::SYFC ||
            $currentCate->cateCode == CategoryType::SZQK || $currentCate->cateCode == CategoryType::XYJJ ||
            $currentCate->cateCode == CategoryType::XYDZ || $currentCate->cateCode == CategoryType::ZZJG || $currentCate->cateCode == CategoryType::ZKZX){
                
                $info = SchooleInformation::findOne(['type'=>$currentCate->cateCode]);
                
                return $this->render('schoolinfo',['parent'=>$parent,'cateList'=>$cateList,'info'=>$info,'currentCate'=>$currentCate]);
                
        }
        //客座教授  | 现任领导
        if($currentCate->cateCode == CategoryType::KZJS || $currentCate->cateCode == CategoryType::XRLD){
            $personage = new Personage();
            $personage->pageSize = 5;
            $data['Personage']['search'] = [
                'role' => $currentCate->cateCode,
            ];
            $list = $personage->getList($data);
        }else {
            switch ($currentCate->type){
                case CategoryType::ARTICLE :
                    $article = new Article();
                    $data['Article']['search'] = [
                        'categoryId' => $cateid,
                        'isPublish'  => 1
                    ];
                    $article->pageSize = 15;
                    $list = $article->articles($data);
                break;
                case CategoryType::VIDEO:
                    $video = new Video();
                    $data['Video']['search'] = [
                        'categoryId' => $cateid,
                    ];
                    $video->pageSize = 15;
                    $list = $video->getPageList($data);
                    break;
                case CategoryType::IMAGE:
                    $photo = new Photo();
                    $data['Photo']['search'] = [
                        'categoryId' => $cateid,
                    ];
                    $photo->pageSize = 15;
                    $list = $photo->getPageList($data);
                    break;
                case CategoryType::FILE:
                    $download = new Download();
                    $data['Download']['search'] = [
                        'categoryId' => $cateid,
                    ];
                    $download->pageSize = 15;
                    $list = $download->getPageList($data);
                    break;
            }
        }
        //var_dump($list);exit();
        return $this->render('list',['parent'=>$parent,'cateList'=>$cateList,'list'=>$list,'currentCate'=>$currentCate]);
    }
    
    
}