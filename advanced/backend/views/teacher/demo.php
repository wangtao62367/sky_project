<?php


use yii\helpers\Html;
use backend\assets\AppAsset;

?>

<div>

<?php echo Html::fileInput('uploadFile','',['id'=>'file']);?>
<p><a href="javascript:;" id="demo">点击上传</a></p>


</div>

<?php 
AppAsset::addScript($this, 'http://gosspublic.alicdn.com/aliyun-oss-sdk-4.4.4.min.js');
$js = <<<JS

$(document).on('click','#demo',function(){
    alert(1);
    var file = $('#file')[0].files[0];
console.log(file);
var client = new OSS.Wrapper({
  region: 'oss-cn-hangzhou',
  accessKeyId: 'LTAI7mO1LDNAZqY9',
  accessKeySecret: 'CgYQ3zFtH9jh7spCidzUCXnWNFd02g',
  bucket: '18upload'
});

        console.log(client);

  client.multipartUpload('dsafdfsffdsf6543645.png', file,{
       progress: function* (p) {
          console.log('Progress: ' + p);
       }
  }).then(function (result) {
    console.log(result);
  }).catch(function (err) {
    console.log(err);
  });

})



JS;



$this->registerJs($js);
?>