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
        <li><a href="<?php echo Url::to(['testpaper/manage'])?>">试卷管理</a></li>
        <li><a href="<?php echo $url?>"><?php echo $title?></a></li>
    </ul>
</div>

<div class="formbody">

<div class="formtitle"><span><?php echo $title?></span></div>

<ul class="forminfo" id="app">
    <li><label>试卷主题<b>*</b></label>
    	<textarea class="textinput" style="height: 50px;" v-model="paper.title" placeholder="请填写试卷题干"></textarea>
    </li>
    <li><label>添加试题<b>*</b></label>
    	<div class="addPaperQuesetion">
    		<div class="selectedQuestions">
    			<table class="tablelist" v-if="paper.questions.length > 0">
    				<thead>
    					<tr>
    						<th>序号</th>
    						<th>试题题干</th>
    						<th>类型</th>
    						<th>分数设置</th>
    						<th>操作</th>
    					</tr>
    				</thead>
    				<tbody>
    				<tr v-for="(quest,i) in paper.questions">
    					<td>{{i+1}}</td>
    					<td>{{quest.title}}</td>
    					<td>{{quest.cateText}}</td>
    					<td><input type="text" class="questScore" v-model="quest.score"/></td>
    					<td><a href="javascript:;" class="delSeletedQuestion" @click="delThisSelectedQuestion(i)">删除</a></td>
    				</tr>
    				</tbody>
    			</table>
			</div>
    		<button class="scbtn createNewQuestion" data-questionType = "question">创建新试题</button>
    		<!-- <button class="scbtn" data-questionType = "question">从试题库选</button> -->
    	</div>
    </li>
    <li><label>是否发布<b>*</b></label>
    	<div class="vocation">
    		<select class="sky-select" v-model="paper.publishCode">
		    	<option v-for="(item,key) in publishList" :value="key">{{item}}</option>
		    </select>
    	</div>
    </li>
    <li><label>备注：</label><textarea v-model="paper.marks"  cols="" rows="" class="textinput" placeholder="请填写试卷备注信息（选填）"></textarea></li>
    <li><label>&nbsp;</label><input @click="createPaper()" type="button" class="btn" value="创建试卷"/></li>
</ul>

</div>
<?php 
$success = Url::to(['success/suc','back'=>'testpaper/manage']);
$publishArr = json_encode($model->publishTimeArr);
$title = $model->title;
$marks = $model->marks;
$publishCode = $model->publishCode ;
$questions = json_encode($model->questions);
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
	var answer = 0;
	var answerOpt = [];
	for (var i = 0 ;i<len;i++) {
		var optionsText = $(optionsObjs[i]).val();
		if(optionsText != ''){
			options.push({opt:optionsText})
		}
		if($(rightAnswerObjs[i]).prop('checked')){
			answer += parseInt($(rightAnswerObjs[i]).val());
			answerOpt.push(String.fromCharCode(64 + parseInt(i + 1)));
		}
	}
	if(options.length != len){
		alert('选项不能为空');return false;
	}
	if(answer == 0){
		alert('请设置正确答案');return false;
	}
	//记录到数据中
	vm.paper.questions.push({
					title : questTitle,
					cate  : optionsType,
					cateText  : optionsTypeText,
					score : 0,
					answer : answer,
					answerOpt : answerOpt,
					options : options,
			});
	$(".tip").remove();
	$(".modal").remove();
});
var vm = new Vue({
	el : "#app",
	data : {
        publishList : JSON.parse('$publishArr'), 
		paper : {
			title : '$title',
            marks : '$marks',
            publishCode  : '$publishCode',
			questions : JSON.parse('$questions')
		}
	},
	methods : {
		delThisSelectedQuestion : function (index){
			this.paper.questions.remove(index);
		},
		//组成试卷
		createPaper : function(){
            if(!this.checkData()) return;
			var _this = this;
            console.log(this.paper);
            $.post('$url',_this.paper,function(res){
            console.log(res);
                if(res){
					window.location.href = '$success';
				};
            })
		},
        checkData : function(){
            if(this.paper.title == ''){
                alert('试卷题干不能为空'); return false;
            } 
            if(this.paper.questions.length == 0){
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