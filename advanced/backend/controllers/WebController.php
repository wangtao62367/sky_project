<?php
namespace backend\controllers;



use Yii;
use common\controllers\CommonController;
use common\models\WebCfg;
/**
 * @name 基础设置
 * @author wangt
 *
 */
class WebController extends CommonController
{
    /**
     * @desc 网站设置
     * @return string
     */
    public function actionSetting()
    {
        $webCfg = WebCfg::getWebCfg();
        if(Yii::$app->request->isPost){
            $data= Yii::$app->request->post();
            
            $result = WebCfg::saveWebCfg($data, $webCfg);
            if($result){
                return $this->showSuccess('web/setting');
            }
        }

        return $this->render('web-set',['webCfg'=>$webCfg]);
    }
    
    private function actionImgSet()
    {
    	$webCfg = WebCfg::getWebCfg();
    	if(Yii::$app->request->isPost){
    		$data = Yii::$app->request->post();
    		$result = WebCfg::saveImgSet($data,$webCfg);
    		if($result){
    			return $this->showSuccess('web/img-set');
    		}
    	}
    	return $this->render('img-set',['webCfg'=>$webCfg]);
    }
    
    /**
     * @desc 水印设置
     * @return \yii\web\Response|string
     */
    public function actionWatermarkSet()
    {
    	$webCfg = WebCfg::getWebCfg();
    	if(Yii::$app->request->isPost){
    		$data= Yii::$app->request->post();
    		$result = WebCfg::saveWatermarkCfg($data, $webCfg);
    		if($result){
    			return $this->showSuccess('web/watermark-set');
    		}
    	}
    	
    	return $this->render('watermark-set',['webCfg'=>$webCfg]);
    }
}