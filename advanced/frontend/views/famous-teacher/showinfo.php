<?php
use frontend\assets\AppAsset;
?>
<div class="modal fade in" id="myModal"  role="dialog" style="display: block;z-index:15001">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                
            </div>
            <div class="modal-body">
            
            	<div class="info-box">
            		<h3><?php echo $info->name;?>  <span>授课内容：<?php echo $info->teach;?></span></h3>
            		<div class="info-content">
            			<?php echo $info->intro; ?>
            		</div>
            	</div>
            	<div class="avater-box">
            		<img alt="" src="<?php echo $info->avater;?>" width="160px" height="219px" style="margin-top: 20px;margin-left:20px;"/>
            	</div>
				
            </div>
            
        </div>
    </div>
</div>

<div class="zoomify-shadow zoomed" style="transition: all 200ms linear;"></div>

<?php 
$js = <<<JS
$(document).on('click','.modal-footer .close-btn,.close',function(){
    $('.modal').hide(400);
    $('.zoomed').hide();
});
JS;
$css = <<<CSS
.modal-header{padding:0px;border-bottom:0px;}
.modal-header .close {
    margin-top: -1px;
    margin-right: 2px;
}
.modal-dialog{
    width:700px;
    height:800px;
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -350px;
    margin-top: -400px;
}
.modal-body{height:780px;padding-top:0px;}
.info-box{width:480px;height:780px;float:left;overflow: hidden;overflow-y: scroll;}
.info-content{border-top:1px solid #ccc;padding:6px;}
.avater-box{width:180px;height:400px;float:left;}
CSS;
AppAsset::addCss($this, '/front/js/zoomify/zoomify.min.css');
$this->registerJs($js);
$this->registerCss($css);
?>