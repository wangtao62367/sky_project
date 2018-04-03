<?php
namespace backend\controllers;




use Yii;
use common\controllers\CommonController;
use common\models\SchooleInformation;
/**
* @name 学院基本信息管理
* @date: 2018年2月8日 上午9:29:08
* @author: wangtao
*/
class SchooleController extends CommonController
{
    
    /**
     * @desc 文章富文本上传文件
     * {@inheritDoc}
     * @see \yii\base\Controller::actions()
     */
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'common\ijackwu\ueditor\alioss\UeditorAliossAction',//'kucha\ueditor\UEditorAction',//
                //'lang' => 'zh-cn',
                'config' => [
                    "fileUrlPrefix" => Yii::$app->params['oss']['host'],
                    "imageUrlPrefix"  => Yii::$app->params['oss']['host'],//图片访问路径前缀
                    "imagePathFormat" => "upload/schoole/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => '',//Yii::getAlias("@frontend").'/web',
                    
                    "videoFieldName"=> "upfile",
                    "videoUrlPrefix"  => Yii::$app->params['oss']['host'],//图片访问路径前缀
                    "videoPathFormat" => "upload/video/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "videoAllowFiles" => ['.mp4'],
                    "videoMaxSize"    => 1024*1024*1024
                    
                ],
            ]
        ];
    }
    
    /**
    * @desc 编辑信息
    * @date: 2018年2月8日 上午9:36:56
    * @author: wangtao
    * @param: type 类型
    * @return:
    */
    public function actionEdit(string $type)
    {
        $model = SchooleInformation::findOne($type);
        if(empty($model)){
            return $this->showDataIsNull('content/schoole');
        }
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if(SchooleInformation::edit($post, $model)){
                return $this->showSuccess('content/schoole');
            }else {
               Yii::$app->session->setFlash('error',array_values($model->getErrors())[0]); 
            }
        }
        return $this->render('edit',['model'=>$model,'title'=>'编辑'.SchooleInformation::$typeDesc[$type]]);
    }
    
}