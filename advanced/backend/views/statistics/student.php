<?php


use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>


<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">用户系统</a></li>
        <li><a href="<?php echo Url::to(['student/manage'])?>">学员管理</a></li>
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
            <!-- <li><a href="javascript:;" class="excel-btn">导出</a></li> -->
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

$bySexDatasX = json_encode( array_column($result['bySex'],'sex') );
$bySexDatass = json_encode( array_column($result['bySex'],'sum') );

$bypoliticalStatusDataX = json_encode( array_column($result['bypoliticalStatus'],'political') );
$bypoliticalStatusDatas = json_encode( array_column($result['bypoliticalStatus'],'sum') );

$byEduationDataX = json_encode( array_column($result['byEduation'],'eduDegree') );
$byEduationDatas = json_encode( array_column($result['byEduation'],'sum') );

$byCityDataX = json_encode( array_column($result['byCity'],'citystate') );
$byCityDatas = json_encode( array_column($result['byCity'],'sum') );
$js = <<<JS
var barWidth = 40;
      
var colorList = ['rgb(164,205,238)','rgb(42,170,227)','rgb(25,46,94)','rgb(195,229,235)'];

initBarChart('statistics-sex','按性别统计',null,'$bySexDatasX',null,'$bySexDatass',null,'rgb(164,205,238)');

initBarChart('statistics-politicalStatus','按党派统计',null,'$bypoliticalStatusDataX',null,'$bypoliticalStatusDatas',null,'rgb(42,170,227)');

initBarChart('statistics-eduation','按文化程度统计',null,'$byEduationDataX',null,'$byEduationDatas',null,'rgb(25,46,94)');

initBarChart('statistics-city','按市州统计',null,'$byCityDataX',null,'$byCityDatas',null,'rgb(195,229,235)');

function initBarChart(id,title,legend,datax,yAxis,datas,tooltip,barColor){
    //基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById(id));
    var option = {
            title: {
                text: title
            },
            tooltip: {},
            legend: legend || {
                data: ['人数']
            },
            xAxis: {
                data: JSON.parse(datax)
            },
            yAxis: yAxis || [ // Y轴
            {
                type : 'value',
                minInterval : 1,
                axisLabel : {
                formatter :  '{value}'
            },
            boundaryGap : [ 0, 0.1 ],
            
            }],
            series: [{
                name: '人数',
                type: 'bar',
                data: JSON.parse(datas),
                barWidth : barWidth,
                //配置样式
                itemStyle: {   
                    //通常情况下：
                    normal:{  
    　　　　　　　　　　　　//每个柱子的颜色即为colorList数组里的每一项，如果柱子数目多于colorList的长度，则柱子颜色循环使用该数组
                        color: function (params){
                            return barColor;
                        }
                    },
                },
            }]
        };
    myChart.setOption(option);
}
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