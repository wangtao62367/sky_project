<?php
namespace common\publics;




/**
 * 图片上传类
 * @author wt
 *
 */

class ImageUpload
{
    const DS = '/';
    //图片大小限制（单位字节 如：1kb = 1024）
    private $fileMaxSize;
    //是否压缩
    private $isThumbnail;
    //压缩规格
    private $thumbnail = [];
    //是否加水印
    private $isWatermark = false;
    
    private $baseDir = 'upload';
    
    public function __construct($config){
        
    }
    
    public function Upload($fileField)
    {
        
    }
    
}