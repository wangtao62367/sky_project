<?php
namespace common\publics;



use Yii;
use common\models\WebCfg;
use yii\caching\DbDependency;
use yii\base\Exception;
use OSS\OssClient;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;
/**
 * 图片上传类
 * @author wt
 *
 */

class ImageUpload
{
    const DS = '/';
    //图片大小限制（单位字节 如：1kb = 1024）
    private $imageMaxSize;
    //是否压缩
    private $isThumbnail = false;
    //压缩规格
    private $thumbnails = [];
    //是否加水印
    private $isWatermark = true;

    //path路径
    private $imagePath = '';
    
    private $OSSclient = null;
    private $bucket;
    
    public function __construct($config){
        $this->imageMaxSize= isset($config['imageMaxSize']) ? $config['imageMaxSize'] : 1024 * 1024 * 500;
        $this->isThumbnail = isset($config['isThumbnail']) ? $config['isThumbnail'] : false;
        $this->thumbnails   = isset($config['thumbnails']) ? $config['thumbnails'] : [];
        
        $this->isWatermark = isset($config['isWatermark'])  ? $config['isWatermark'] : true;
        $this->imagePath   = isset($config['imagePath']) ? '/upload/'.$config['imagePath'].self::DS : '/upload/image/'.date('Y').self::DS.date('m').self::DS.date('d').self::DS;
        
        $this->bucket = Yii::$app->params['oss']['bucket'];
        $this->OSSclient =  new OssClient(Yii::$app->params['oss']['akey'], Yii::$app->params['oss']['skey'], Yii::$app->params['oss']['endpoint'], false);
    }
    
    public function Upload($fileField)
    {
        try {
            $file = $_FILES[$fileField];
            if(!$this->checkImageSize($file)){
                throw new Exception('图片已超出限制大小');
            }
            //获取图片名称,含后缀
            $imageName = self::getImageName($file);
            //阿里云OSS服务block名称
            $ossBlock = $this->imagePath.$imageName;
            
            $origImage = $file['tmp_name'];
            $tempSaveImage = Yii::getAlias('@webroot/upload/').$imageName;
            //是否需要添加水印
            if($this->isWatermark){
                 $this->watermarkImage($origImage, $tempSaveImage);
                if($this->isThumbnail){
                    foreach ($this->thumbnails as $thumbnail){
                        $w = $thumbnail['w'];
                        $h = $thumbnail['h'];
                        $saveImage = Yii::getAlias('@webroot/upload/'.$w.'_'.$imageName);
                        $thumbnailImageBlock = $this->imagePath.$w.'_'.$imageName;
                        Image::thumbnail($tempSaveImage, $w, $h,ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($saveImage);
                        //保存至OSS服务器
                        $imageName = str_replace(Yii::getAlias('@webroot/upload/'), '', $saveImage);
                        $block = $this->imagePath.$imageName;
                        $this->OSSclient->uploadFile($this->bucket, ltrim($block,'/') , $saveImage);
                        if(is_file($saveImage)){
                            unlink($saveImage);
                        }
                    }
                }
                unlink($tempSaveImage);
            }else {
                //如果需要压缩
                if($this->isThumbnail){
                    foreach ($this->thumbnails as $thumbnail){
                        $w = $thumbnail['w'];
                        $h = $thumbnail['h'];
                        $saveImage = Yii::getAlias('@webroot/upload/'.$w.'_'.$imageName);
                        $thumbnailImageBlock = $this->imagePath.$w.'_'.$imageName;
                        Image::thumbnail($origImage, $w, $h,ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($saveImage);
                        //保存至OSS服务器
                        $imageName = str_replace(Yii::getAlias('@webroot/upload/'), '', $saveImage);
                        $block = $this->imagePath.$imageName;
                        $this->OSSclient->uploadFile($this->bucket, ltrim($block,'/') , $saveImage);
                        if(is_file($saveImage)){
                            unlink($saveImage);
                        }
                    }
                }
                
                $this->OSSclient->uploadFile($this->bucket, ltrim($ossBlock,'/') , $origImage);
            }
            return $ossBlock;
        }catch (\yii\base\Exception $e){
            throw new Exception($e->getMessage());
            return null;
        }
    }
    
    public function deleteImage($ossBlock)
    {
        
        $this->OSSclient->deleteObject($this->bucket, ltrim($ossBlock,'/'));
        return true;
    }
    
    public function deleteImages($ossBlocks)
    {
        $this->OSSclient->deleteObjects($this->bucket, $ossBlocks);
        return true;
    }
    
    
    public function watermarkImage($origImage,$saveImage)
    {
        //获取水印配置
        $waterMarkConfig = self::getWatermarkConfig();
        $watermarkContent  = $waterMarkConfig['watermarkContent'];
        $watermarkPosition = $waterMarkConfig['watermarkPosition'];
        $watermarkTextColor= $waterMarkConfig['watermarkTextColor'];
        $watermarkTextFont = $waterMarkConfig['watermarkTextFont'];
        //原图大小
        $imageWH = self::getImageWidthHeight($origImage);
        if($waterMarkConfig['watermarkCate'] == 'text'){
            //文字的宽高
            $watermarkW = self::getTextWidth($watermarkContent, $watermarkTextFont);
            $watermarkH = self::getTextHeight($watermarkContent, $watermarkTextFont);
            //获取水印位置
            $position = self::getWatermarkPosition($watermarkPosition, $imageWH, ['w'=>$watermarkW,'h'=>$watermarkH]);
            //加文字水印
            Image::text($origImage, $watermarkContent, Yii::getAlias('@webroot/admin/font/simhei.ttf'),$position,['color'=>$watermarkTextColor,'size'=>$watermarkTextFont])->save($saveImage, ['quality' => 40]); 
        }
        
        if($waterMarkConfig['watermarkCate'] == 'image'){
            $waterImageWH = self::getImageWidthHeight($watermarkContent);
            //获取水印位置
            $position = self::getWatermarkPosition($watermarkPosition, $imageWH, $waterImageWH);
            //获取字符串编码
            $encode = mb_detect_encoding($watermarkContent, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
            //将字符编码改为utf-8
            $watermarkContent = mb_convert_encoding($watermarkContent, 'UTF-8', $encode);
            //加图片水印
            Image::watermark($origImage, $watermarkContent, $position)->save($saveImage, ['quality' => 40]);
        }
        
        if(is_file($saveImage)){
        	//保存至OSS服务器
        	$imageName = str_replace(Yii::getAlias('@webroot/upload/'), '', $saveImage);
        	$block = $this->imagePath.$imageName;
        	$this->OSSclient->uploadFile($this->bucket, ltrim($block,'/') , $saveImage);
        	return $block;
        }
    }
    
    public static function getWatermarkPosition($positionType,$imageWH,$watermarkWH)
    {
        $imageW = $imageWH['w'];
        $imageH = $imageWH['h'];
        $watermarkW = $watermarkWH['w'];
        $watermarkH = $watermarkWH['h'];
        $defaultX = 5;
        $defaultY = 5;
        switch ($positionType){
            case 1 :
                return [$defaultX,$defaultY];
                break;
            case 2 :
                $x = ($imageW - $watermarkW) / 2;
                $y = $defaultY;
                return [$x,$y];
                break;
            case 3 :
                $x = ($imageW - $watermarkW) - $defaultX;
                $y = $defaultY;
                return [$x,$y];
                break;
            case 4 :
                $x = $defaultX;
                $y = ($imageH-$watermarkH) / 2;
                return [$x,$y];
                break;
            case 5 :
                $x = ($imageW - $watermarkW) / 2;
                $y = ($imageH - $watermarkH) / 2;
                return [$x,$y];
                break;
            case 6 :
                $x = ($imageW - $watermarkW) - $defaultX;
                $y = ($imageH - $watermarkH) / 2;
                return [$x,$y];
                break;
            case 7 :
                $x = $defaultX;
                $y = ($imageH - $watermarkH) - $defaultY;
                return [$x,$y];
                break;
            case 8:
                $x = ($imageW - $watermarkW) / 2;
                $y = ($imageH - $watermarkH) - $defaultY;
                return [$x,$y];
                break;
            default:
                $x = ($imageW - $watermarkW) - $defaultX;
                $y = ($imageH - $watermarkH) - $defaultY;
                return [$x,$y];
                break;
        };
        
    }
    
    public static function getImageWidthHeight($imageName)
    {
        list($width,$height,$type,$attr) = getimagesize($imageName);
        return [
            'w' => $width,
            'h' => $height
        ];
    }
    
    public static function getFontBox($text,$size){
        return imagettfbbox($size, 0, Yii::getAlias('@webroot/admin/font/ariali.ttf'), $text);
    }
    
    public static function getTextHeight ($text,$size) {
        $box = self::getFontBox($text,$size);
        $height = $box[3] - $box[5];
        return $height;
    }
    
    public static function getTextWidth ($text,$size) {
        $box = self::getFontBox($text,$size);
        $width = $box[4] - $box[6];
        return $width;
    }
    
    public static function getImageName($file)
    {
        $randNum = mt_rand(1, 1000000000) . mt_rand(1, 1000000000);
        return $randNum.'.'.str_replace('image/', '', $file['type']);
    }
    
    public function checkImageSize($file)
    {
        if($file['size'] > $this->imageMaxSize){
            return false;
        }
        return true;
    }
    
    public static function getWatermarkConfig()
    {
        $watermarkconfig = Yii::$app->cache->get('watermarkconfig');
        if(!empty($watermarkconfig)){
            return $watermarkconfig;
        }
        $webCfgs = WebCfg::find()->where(['or',
            ['name'=>'watermarkCate'],
            ['name'=>'watermarkContent'],
            ['name'=>'watermarkPosition'],
            ['name'=>'watermarkTextColor'],
            ['name'=>'watermarkTextFont'],
        ])->all();
        $result = [];
        if(!empty($webCfgs)){
            foreach ($webCfgs as $v){
                $result[$v->name] = $v->value;
            }
            Yii::$app->cache->set('watermarkconfig', $result,null,new DbDependency(['sql'=>'select value from sky_WebCfg where name = \'watermarkCate\' or name = \'watermarkContent\' or name = \'watermarkPosition\' or name = \'watermarkTextColor\' or name = \'watermarkTextFont\' ']));
        }
        return $result;
    }
    
}