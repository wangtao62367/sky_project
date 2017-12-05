<?php
use backend\assets\AppAsset;
use common\publics\MyHelper;

$this->title = '投票详情';
?>

<table width="100%" class="table">  
	<caption><h4><?php echo $data['subject'];?></h4></caption> 
    <tr class="theader">
    	<td class="spec">投票选项</td>
    	<td class="spec">投票数</td>
    	<td class="spec">百分比</td>
    </tr>
<?php $total = array_sum(array_column($data['options'], 'counts')) ; foreach ($data['options'] as $opt):?>
  <tr>
    <td><?php echo $opt['text'];?></td>
    <td><?php echo $opt['counts'];?></td>
    <td><?php echo MyHelper::toRate($opt['counts'],$total);?></td>
  </tr>
<?php endforeach;?> 
</table> 