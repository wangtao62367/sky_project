<?php


use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>


<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">统计系统</a></li>
        <li><a href="<?php echo Url::to(['statistics/student'])?>">学员统计</a></li>
    </ul>
</div>

<div class="rightinfo">
	<div class="tools">
		<?php echo Html::beginForm();?>
    	<ul class="toolbar">
            <li><label>年份</label>
            	<div class="vocation">
            		<?php echo Html::activeDropDownList($model, 'year', ArrayHelper::map($yearMonth['years'],'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
            	</div>
            </li>
            <li><label>月份</label>
            	<div class="vocation">
            		<?php echo Html::activeDropDownList($model, 'month', ArrayHelper::map($yearMonth['months'],'id','text'),['prompt'=>'请选择','class'=>'sky-select'])?>
            	</div>
            </li>
            <li><label>&nbsp;</label><?php echo Html::submitInput('统计',['class'=>'scbtn'])?></li>
            <li><span><img src="/admin/images/t04.png" /></span>导出</li>
        </ul>
        <?php echo Html::endForm();?>
	</div>
	
	<div class="statistics-main">
		<div class="statistics-item" id="statistics-sex"></div>
		<div class="statistics-item" id="statistics-politicalStatus"></div>
		<div class="statistics-item" id="statistics-eduation"></div>
		<div class="statistics-item" id="statistics-city"></div>
	</div>

</div>

<?php 
AppAsset::addScript($this, '/admin/js/echarts.common.min.js');
$bySexData = json_encode( array_values($result['bySex']) );
$bypoliticalStatusDataX = json_encode( array_column($result['bypoliticalStatus'],'politicalStatus') );
$bypoliticalStatusDatas = json_encode( array_column($result['bypoliticalStatus'],'sum') );

$byEduationDataX = json_encode( array_column($result['byEduation'],'eduation') );
$byEduationDatas = json_encode( array_column($result['byEduation'],'sum') );

$byCityDataX = json_encode( array_column($result['byCity'],'city') );
$byCityDatas = json_encode( array_column($result['byCity'],'sum') );
$js = <<<JS
// 基于准备好的dom，初始化echarts实例
        var myChart1 = echarts.init(document.getElementById('statistics-sex'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '按性别统计'
            },
            tooltip: {},
            legend: {
                data:['人数']
            },
            xAxis: {
                data: ["男","女"]
            },
            yAxis: [ // Y轴
            {
            
            type : 'value',
            
            minInterval : 1,
            
            axisLabel : {
            
            formatter :  '{value}'
            
            },
            
            boundaryGap : [ 0, 0.1 ],
            
            } ],
            series: [{
                name: '人数',
                type: 'bar',
                data: JSON.parse('$bySexData')
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart1.setOption(option);
        
        var myChart2 = echarts.init(document.getElementById('statistics-politicalStatus'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '按政治面貌统计'
            },
            tooltip: {},
            legend: {
                data:['人数']
            },
            xAxis: {
                data: JSON.parse('$bypoliticalStatusDataX')
            },
            yAxis: [ // Y轴
            {
            
            type : 'value',
            
            minInterval : 1,
            
            axisLabel : {
            
            formatter :  '{value}'
            
            },
            
            boundaryGap : [ 0, 0.1 ],
            
            } ],
            series: [{
                name: '人数',
                type: 'bar',
                data: JSON.parse('$bypoliticalStatusDatas')
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart2.setOption(option);

        var myChart3 = echarts.init(document.getElementById('statistics-eduation'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '按学历统计'
            },
            tooltip: {},
            legend: {
                data:['人数']
            },
            xAxis: {
            data: JSON.parse('$byEduationDataX')//["小学","初中","高中","大专","本科","研究生","博士"]
            },
            yAxis: [ // Y轴
            {
            
            type : 'value',
            
            minInterval : 1,
            
            axisLabel : {
            
            formatter :  '{value}'
            
            },
            
            boundaryGap : [ 0, 0.1 ],
            
            } ],
            series: [{
                name: '人数',
                type: 'bar',
                data: JSON.parse('$byEduationDatas')
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart3.setOption(option);

        var myChart4 = echarts.init(document.getElementById('statistics-city'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '按区域统计'
            },
            tooltip: {},
            legend: {
                data:['人数']
            },
            xAxis: {
                data: JSON.parse('$byCityDataX')//["成都","绵阳","南充","乐山","遂宁","资阳","眉山"]
            },
            yAxis: [ // Y轴
            {
            
            type : 'value',
            
            minInterval : 1,
            
            axisLabel : {
            
            formatter :  '{value}'
            
            },
            
            boundaryGap : [ 0, 0.1 ],
            
            } ],
            series: [{
                name: '人数',
                type: 'bar',
                data: JSON.parse('$byCityDatas')
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart4.setOption(option);

JS;
$css = <<<CSS
.statistics-main{
    width:98%;
    margin:0 auto;
    margin-top:10px
}
.statistics-item{
    width:50%;
    height :400px;
    float:left;
}
.toolbar li {
    background: #FFF;
    line-height: 33px;
    height: 33px;
    border: 0PX;
    float: left;
    padding-right: 10px;
    margin-right: 5px;
    border-radius: 3px;
    /* behavior: url(js/pie.htc); */
    cursor: pointer;
}
.toolbar li label{
    float: left;
}
CSS;
$this->registerJs($js);
$this->registerCss($css);
?>