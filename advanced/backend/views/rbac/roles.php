<?php
use yii\helpers\Url;
use common\publics\MyHelper;
use yii\helpers\Html;

?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">基础设置</a></li>
        <li><a href="<?php echo Url::to(['rbac/roles'])?>">权限管理</a></li>
        <li><a href="<?php echo Url::to(['rbac/roles'])?>">角色列表</a></li>
    </ul>
</div>

<div class="rightinfo">
	<div class="tools">
	<ul class="toolbar">
        <li><a href="<?php echo Url::to(['rbac/createrole'])?>"><span><img src="/admin/images/t01.png" /></span>添加</a></li>
    </ul>
    </div>
</div>

<table class="tablelist">
	<thead>
    	<tr>
            <th>角色名称</th>
            <th>角色标识</th>
            <th>规则</th>
            <th>数据</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
    </thead>
    
    <tbody>

    	<?php foreach ($roles as $role):?>
    	<tr>
            <td><?php echo $role->description;?></td>
            <td><?php echo $role->name;?></td>
            <td><?php echo $role->ruleName;?></td>
            <td><?php echo $role->data;?></td>
            <td><?php echo MyHelper::timestampToDate($role->createdAt);?></td>
            <td><?php echo MyHelper::timestampToDate($role->updatedAt);?></td>
            <td>
            <a href="<?php echo Url::to(['rbac/assiginitem','name'=>$role->name]);?>" class="tablelink">分配权限</a>
            <a href="<?php echo Url::to(['rbac/editrole','name'=>$role->name]);?>" class="tablelink">编辑</a>    
            <a href="<?php echo Url::to(['rbac/delrole','name'=>$role->name]);?>" class="tablelink"> 删除</a>
            </td>
        </tr> 
        <?php endforeach;?>
    </tbody>
</table>
