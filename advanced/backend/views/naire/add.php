<?php


use yii\helpers\Url;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$id = Yii::$app->request->get('id','');
$url =Url::to([$controller->id.'/'.$controller->action->id, 'id' => $id]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['naire/manage'])?>">问卷管理</a></li>
        <li><a href="<?php echo $url?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>

<ul class="forminfo" id="app">
    <li><label>问卷主题<b>*</b></label>
    	<textarea class="textinput" style="height: 50px;" v-model="naire.title" placeholder="请填写问卷题干"></textarea>
    </li>
    <li><label>添加试题<b>*</b></label>
    	<div class="addPaperQuesetion">
    		<div class="selectedQuestions">
    			<table class="tablelist" v-if="naire.votes.length > 0">
    				<thead>
    					<tr>
    						<th>序号</th>
    						<th>试题题干</th>
    						<th>类型</th>
    						<th>操作</th>
    					</tr>
    				</thead>
    				<tbody>
    				<tr v-for="(vote,i) in naire.votes">
    					<td>{{i+1}}</td>
    					<td>{{vote.subject}}</td>
    					<td>{{vote.selectTypeText}}</td>
    					<td><a href="javascript:;" class="delSeletedQuestion" @click="delThisSelectedQuestion(i)">删除</a></td>
    				</tr>
    				</tbody>
    			</table>
			</div>
    		<button class="scbtn createNewQuestion" data-questionType = "vote">创建新试题</button>
    		<button class="scbtn" data-questionType = "vote">从试题库选</button>
    	</div>
    </li>
    <li><label>是否发布<b>*</b></label>
    	<div class="vocation">
    		<select class="sky-select" v-model="naire.isPublish">
		    	<option v-for="(item,key) in publishList" :value="key">{{item}}</option>
		    </select>
    	</div>
    </li>
    <li><label>备注：</label><textarea v-model="naire.marks"  cols="" rows="" class="textinput" placeholder="请填写问卷备注信息（选填）"></textarea></li>
    <li><label>&nbsp;</label><input @click="create()" type="button" class="btn" value="创建问卷"/></li>
</ul>

</div>
<?php 
$success = Url::to(['success/suc','back'=>'naire/manage']);
$publishArr = json_encode($model->publishArr);
$title = $model->title;
$marks = $model->marks;
$isPublish = $model->isPublish;
$votes = json_encode($model->votes);
$js = <<<JS
$(document).on('click','.sure',function(){
	var questTitle = $('.questTitle').val();
	if(questTitle == ''){
		alert('试题题干不能为空');return false;
	}
	var optionsType = $('input[type=radio]:checked').val();
	var optionsTypeText = optionsType == 'radio' ? '单选题' : '多选题';
	
	var optionsObjs = $('input[name=opts]');
	var rightAnswerObjs = $("input[type=checkbox]");
	var len = optionsObjs.length;
	var options = [];
	for (var i = 0 ;i<len;i++) {
		var optionsText = $(optionsObjs[i]).val();
		if(optionsText != ''){
			options.push({opt:optionsText})
		}
	}
	if(options.length != len){
		alert('选项不能为空');return false;
	}
	//记录到数据中
	vm.naire.votes.push({
					subject : questTitle,
					selectType  : optionsType,
					selectTypeText  : optionsTypeText,
					voteoptions : options,
			});
	$(".tip").remove();
	$(".modal").remove();
});
var vm = new Vue({
	el : "#app",
	data : {
        publishList : JSON.parse('$publishArr'), 
		naire : {
			title : '$title',
            marks : '$marks',
            isPublish  : '$isPublish',
            votes : JSON.parse('$votes')
		}
	},
	methods : {
		delThisSelectedQuestion : function (index){
			this.naire.questions.remove(index);
		},
		//组成试卷
		create : function(){
            if(!this.checkData()) return;
			var _this = this;
            console.log(this.naire);
            $.post('$url',_this.naire,function(res){
            console.log(res);
                if(res){
					window.location.href = '$success';
				};
            })
		},
        checkData : function(){
            if(this.naire.title == ''){
                alert('问卷题干不能为空'); return false;
            } 
            if(this.naire.votes.length == 0){
                alert('请创建/选择试题'); return false;
            }
            return true;
        }
	},
	
})

JS;
$this->registerJs($js);
AppAsset::addCss($this, '/admin/css/addQuestion.css');
AppAsset::addScript($this, '/admin/js/vue.min.js');
AppAsset::addScript($this, '/admin/js/addQuestion.js');
?>