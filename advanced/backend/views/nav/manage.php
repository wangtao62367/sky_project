<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['content/manage'])?>">内容管理</a></li>
        <li><a href="<?php echo Url::to(['nav/manage'])?>">首页导航</a></li>
    </ul>
</div>


<table class="tablelist">
	<thead>
    	<tr>
            <th>导航名称</th>
            <th>包含模块</th>
            <th>排序</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($list as $val):?>
    	<tr>
            <td><?php echo $val['codeDesc'];?></td>
            <td><?php echo implode(',', ArrayHelper::getColumn($val['categorys'], 'text')) ;?></td>
            <td>
           	<?php echo $val['sorts']?>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>

<?php 
$css = <<<CSS
.tablelist{
margin-top:20px
}
CSS;
// $curPage = $list['curPage'];
// $pageSize = $list['pageSize'];
// $count = $list['count'];
// $uri = Yii::$app->request->getUrl();
$js = <<<JS

JS;
$this->registerJs($js);
$this->registerCss($css);
?>