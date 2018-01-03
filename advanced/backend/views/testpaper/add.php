<?php


use yii\helpers\Url;
use backend\assets\AppAsset;

$controller = Yii::$app->controller;
$param = isset($_GET['id']) ? $_GET['id'] : '';
$url =Url::to([
    $controller->id.'/'.$controller->action->id,
    'id' => $param
]);
?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="javascript:;">新闻系统</a></li>
        <li><a href="<?php echo Url::to(['testpaper/articles'])?>">文章管理</a></li>
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
    						<th>操作</th>
    					</tr>
    				</thead>
    				<tbody>
    				<tr v-for="(quest,i) in paper.questions">
    					<td>{{i+1}}、</td>
    					<td>{{quest.title}}</td>
    					<td>{{quest.cateText}}</td>
    					<td><a href="javascript:;" class="delSeletedQuestion" @click="delThisSelectedQuestion(i)">删除</a></td>
    				</tr>
    				</tbody>
    			</table>
			</div>
    		<button class="scbtn createNewQuestion">创建新试题</button>
    		<button class="scbtn">从试题库选</button>
    	</div>
    </li>
    <li><label>是否发布<b>*</b></label>
    	<div class="vocation">
    		<select class="sky-select" v-model="paper.publish">
		    	<option v-for="item in publishList" :value="item.code">{{item.value}}</option>
		    </select>
    	</div>
    </li>
    <li><label>备注：</label><textarea v-model="paper.marks"  cols="" rows="" class="textinput" placeholder="请填写试卷备注信息（选填）"></textarea></li>
    <li><label>&nbsp;</label><input @click="createPaper()" type="button" class="btn" value="确认保存"/></li>
</ul>

</div>
<?php 
$css = <<<CSS
select{opacity: 1;}
.sky-select{height: 32px;width: 100px;border: solid 1px #ced9df;margin: 5px 0px;}
.modal{display: block;position: absolute;left: 0;top: 0;right: 0;bottom: 0;background: #000000;opacity: 0.2;}
.right-anwswer,.question-title,.addPaperQuesetion{margin-left: 86px;}
.tipinfo{margin-left: 0px;height: 290px;    overflow: hidden;overflow-y: scroll;padding-top: 15px;}
.tipinfo textarea{width: 325px;height: 50px;float: left;display: inline-block;margin-bottom: 5px;}
.tip{width: 540px;height: 400px;}
.tipbtn {margin-top: 0px;margin-left: 155px;}
.rightAnswer--label{/*margin:20px 20px 0 0;*/display:inline-block}
.rightAnswer--radio{display:none}
.rightAnswer--radioInput{background-color:#fff;border:1px solid rgba(0,0,0,0.15);border-radius:100%;display:inline-block;height:16px;margin-right:10px;margin-top:-1px;vertical-align:middle;width:16px;line-height:1}
.rightAnswer--radio:checked + .rightAnswer--radioInput:after{background-color:#57ad68;border-radius:100%;content:"";display:inline-block;height:12px;margin:2px;width:12px}
.rightAnswer--checkbox.rightAnswer--radioInput,.rightAnswer--radio:checked + .rightAnswer--checkbox.rightAnswer--radioInput:after{border-radius:0}

.question-option{float: left;}
.question-option p {margin-bottom: 5px;}
.del-questoption{width: 34px;height: 34px;text-align: center;line-height: 34px;display: inline-block;font-size: 20px;margin-left: 5px;}
.addTitleImg{width: 70px;height: 70px;text-align: center;line-height: 72px;font-size: 16px;border: 1px solid #ecdfdf;display: inline-block;margin-left: 5px;color: #969292}

.selectedQuestions{margin-bottom: 8px;width: 526px;/*border: 1px solid #ced9df*/;max-height: 500px;overflow: hidden;overflow-y: scroll;}
.selectedQuestions p {padding: 8px;}
.tablelist thead th,.tablelist tbody td{min-width: 60px;}
CSS;
$js = <<<JS
var tipHtml = '<div class="modal"></div>\
	<div class="tip ">\
	<div class="tiptop"><span>创建新试题</span><a></a></div>\
  	<div class="tipinfo">\
        <ul class="forminfo">\
		    <li><label>试题题干:</label>\
		    	<div class="question-title">\
		    		<textarea class="textinput questTitle"></textarea>\
		    		<!--<div class="addTitleImg">添加图片<input type="file" id="titleImg" name="titleImg" style="display: none;"></div></p>-->\
		    	</div>\
		    </li>\
		    <li><label>试题选项:</label>\
		    	<div class="question-option">\
		    		<div class="options">\
		    			<p><input name="opts" type="text" class="dfinput" placeholder="选项A"/></p>\
			    		<p><input name="opts" type="text" class="dfinput" placeholder="选项B"/></p>\
		    		</div>\
		    		<p><a href="javascript:;" class="addOptions">+添加选项</a></p>\
		    	</div>\
		    </li>\
		    <li><label>试题类型:</label><cite><input name="optionsType" type="radio" value="radio" checked="checked" />单选&nbsp;&nbsp;&nbsp;&nbsp;<input name="optionsType" type="radio" value="multi" />多选</cite></li>\
		    <li><label>正确答案:</label>\
		    	<div class="right-anwswer" >\
		    		<label class="rightAnswer--label">\
				        <input class="rightAnswer--radio" value="1" type="checkbox" name="rightAnswer-checkbox2">\
				        <font class="rightAnswer--checkbox rightAnswer--radioInput"></font>A\
				    </label>\
				    <label class="rightAnswer--label">\
				        <input class="rightAnswer--radio" value="2" type="checkbox" name="rightAnswer-checkbox3">\
				        <font class="rightAnswer--checkbox rightAnswer--radioInput"></font>B\
				    </label>\
		    	</div>\
		    </li>\
	    </ul>\
  	</div>\
    <div class="tipbtn">\
        <input name="" type="button"  class="sure" value="确定" />&nbsp;\
        <input name="" type="button"  class="cancel" value="取消" />\
    </div>\
</div>';
$(".select1").uedSelect({
	width : 100	  
});
$(document).on('click','.createNewQuestion',function(){
	$(document).find('body').append(tipHtml);
    $(".tip").show(100);
});
$(document).on('click','.tiptop a,.cancel',function(){
	$(".tip").remove();
	$(".modal").remove();
});
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
					answer : answer,
					answerOpt : answerOpt,
					options : options,
			});
	$(".tip").remove();
	$(".modal").remove();
});

var optionsHtmlStart = '<p><input name="opts" type="text" class="dfinput" placeholder = "选项{0}" />';
var optionsHtmlEnd   = '</p>';
var optionsDeleteHtml = '<a href="javascript:;" class="del-questoption">x</a>';
var rightAnswerHtml = '<label class="rightAnswer--label"><input class="rightAnswer--radio" type="checkbox" value="{0}" name="rightAnswer--checkbox3"><font class="rightAnswer--checkbox rightAnswer--radioInput"></font>{1}</label>'
$(document).on('click','.addOptions',function(){
	var optionsObj = $('.options');
	var optionsLen = optionsObj.find("input[type=text]").length;
	var options = String.fromCharCode(64 + parseInt(optionsLen + 1));
	optionsDeleteHtml = optionsLen >= 2 ? optionsDeleteHtml : '';
	var optionHtml = optionsHtmlStart.format(options)  + optionsDeleteHtml + optionsHtmlEnd ;
	optionsObj.append(optionHtml);
	$('.right-anwswer').append(rightAnswerHtml.format(Math.pow(2,optionsLen),options));
});
$(document).on('click','.del-questoption',function(){
	$(this).parent('p').remove();
	$('.right-anwswer').empty();
	var optionsObj = $('.options');
	var optionsLen = optionsObj.find("input[type=text]").length;
	for (var i = 0 ; i < optionsLen;i++) {
		var options = String.fromCharCode(64 + parseInt(i + 1));
		$(optionsObj.find("input[type=text]")[i]).attr('placeholder','选项'+options);
		$('.right-anwswer').append(rightAnswerHtml.format(Math.pow(2,i),options));
	}
});
$(document).on('click','.rightAnswer--label',function(){
	var rightAnwswerObj = $('.right-anwswer');
	var optionsTypeVal = $('input[type=radio]:checked').val();
	var rightAnswerCheckedBoxObj = $('.right-anwswer').find('input[type=checkbox]:checked');
	if(optionsTypeVal == 'radio' ){
		$('.right-anwswer').find('input[type=checkbox]:checked').prop('checked',false);
		$(this).find('input[type=checkbox]').prop('checked',true);
	};
});

var vm = new Vue({
	el : "#app",
	data : {
        publishList :[
						{code : 'now',value   : "立即发布"},
						{code : 'min30',value : "30分钟后发布"},
						{code : 'oneHours' ,value : "1小时候发布"},
						{code : 'oneDay',value : "1天以后发布"},
                        {code : 'nopublish',value : "暂时不发布"}
					], 
		paper : {
			title : '',
            marks : '',
			publish : 'nopublish',
			questions : []
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
console.log(12);
            $.post('$url',_this.paper,function(res){
                console.log(res);
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
$this->registerCss($css);
AppAsset::addScript($this, '/admin/js/vue.min.js');
?>