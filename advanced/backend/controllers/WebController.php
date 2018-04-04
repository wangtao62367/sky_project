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
    
    /**
     * @desc 清空缓存文件
     * @return \yii\web\Response|string
     */
    public function actionClearCache()
    {
        $handle = Yii::$app->request->get('handle','');
        if(!empty($handle)){
            $cacheDir = dirname(Yii::$app->basePath).'/frontend/runtime/cache';
            $this->removeDir($cacheDir);
            return $this->showSuccess('web/clear-cache');
            /* echo $cacheDir;exit();
            $cache = new \yii\caching\FileCache();
            $cache->cachePath = $cacheDir;
            $cache->gc(true, false); 
            return $this->showSuccess('web/clear-cache');
            if($cache->gc(true, false)){  //$this->removeDir($cacheDir)
                return $this->showSuccess('web/clear-cache');
            } */
        }
        return $this->render('clear-cache');
    }
    
    private function removeDir($dirName)
    {
        if(! is_dir($dirName))
        {
            return false;
        }
        $handle = @opendir($dirName);
        while(($file = @readdir($handle)) !== false)
        {
            if($file != '.' && $file != '..')
            {
                $dir = $dirName . '/' . $file;
                is_dir($dir) ? $this->removeDir($dir) : @unlink($dir);
            }
        }
        closedir($handle);
        
        return rmdir($dirName) ;
    }   
}