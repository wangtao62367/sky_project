<?php
use backend\assets\AppAsset;
use common\publics\MyHelper;

$this->title = '投票详情';
?>

<table width="100%" class="table">  
	<caption><h4><?php echo $data['subject'];?></h4></caption> 
    <tr class="theader">
    	<td class="spec">序号</td>
    	<td class="spec">投票选项</td>
    	<td class="spec">投票数</td>
    	<td class="spec">百分比</td>
    </tr>
<?php $total = array_sum(array_column($data['options'], 'counts')) ; foreach ($data['options'] as $opt):?>
  <tr>
  	<td>选项 <?php echo $opt['sorts'] + 1 ;?></td>
    <td><?php echo $opt['text'];?></td>
    <td><?php echo $opt['counts'];?></td>
    <td><?php echo MyHelper::toRate($opt['counts'],$total);?></td>
  </tr>
<?php endforeach;?> 
</table> 

<div id="main" class="echart-content" style="" ></div>
<?php 

AppAsset::addScript($this, '/admin/js/echarts.common.min.js');
$subject = $data['subject'];
$legendData = array_column($data['options'], 'text');
$legendData = json_encode($legendData);
$seriesData = array_map(function ($v){
    return [
        'name' => $v['text'],
        'value' => $v['counts']
    ];
}, $data['options']);
$seriesData = json_encode($seriesData);
$js = <<<JS
var myChart = echarts.init(document.getElementById('main'));
option = {
    title : {
        text: '$subject',
        subtext: '投票统计表',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} :  {b} <br/> 票数 : {c} 票 <br/> 百分比  : {d}%"
    },
    legend: {
        type: 'scroll',
        orient: 'vertical',
        right: 10,
        //align: 'right',
        top: 20,
        bottom: 20,
        width : '200px',
        data: $legendData ,//data.legendData
        formatter: function (text) {
            return text.length < 20 
                            ? text 
                            : text.slice(0,20) + '...';
        }
    },
    series : [
        {
            name: '选项',
            type: 'pie',
            radius : '55%',
            center: ['40%', '50%'],
            data: $seriesData,//data.seriesData,
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            },
            label:{
                normal:{
                    formatter(v) {
                        let text = v.name
                        return text.length < 10 
                            ? text 
                            : text.slice(0,10) + '...';
                    }
                } 
            } 
        }
    ]
};
myChart.setOption(option);
JS;
$css = <<<CSS
.echart-content{margin:0 auto;margin-top:50px;width:100%;height:500px;}
CSS;
$this->registerCss($css);
$this->registerJs($js);

?>