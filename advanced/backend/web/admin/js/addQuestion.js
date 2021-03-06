;var tipHtml = '<div class="modal"></div>\
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
		    			<p><input name="opts" type="text" class="dfinput" placeholder="选项1"/></p>\
			    		<p><input name="opts" type="text" class="dfinput" placeholder="选项2"/></p>\
		    		</div>\
		    		<p><a href="javascript:;" class="addOptions">+添加选项</a></p>\
		    	</div>\
		    </li>\
		    <li><label>试题类型:</label><label><input name="optionsType" type="radio" value="radio" checked="checked" />单选&nbsp;&nbsp;&nbsp;&nbsp;</label><label><input name="optionsType" type="radio" value="multi" />多选</label><label><input name="optionsType" type="radio" value="trueOrfalse" />判断</label></li>\
		    <li class="set-right-anwser"><label>正确答案:</label>\
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
$(document).on('click','.createNewQuestion',function(){
	$(document).find('body').append(tipHtml);
	if($(this).data("questiontype") == 'vote'){
		$(".set-right-anwser").hide();
	}
    $(".tip").show(100);
});
$(document).on('click','.tiptop a,.cancel',function(){
	$(".tip").remove();
	$(".modal").remove();
});


var optionsHtmlStart = '<p><input name="opts" type="text" class="dfinput" placeholder = "选项{0}" />';
var optionsHtmlEnd   = '</p>';
var optionsDeleteHtml = '<a href="javascript:;" class="del-questoption">x</a>';
var rightAnswerHtml = '<label class="rightAnswer--label"><input class="rightAnswer--radio" type="checkbox" value="{0}" name="rightAnswer--checkbox3"><font class="rightAnswer--checkbox rightAnswer--radioInput"></font>{1}</label>'
var rightAnswerHtml_tf = '<label class="rightAnswer--label"><input class="rightAnswer--radio" type="checkbox" value="{0}" name="rightAnswer--checkbox3"><font class="rightAnswer--checkbox rightAnswer--radioInput"></font>{1}</label>'

$(document).on('click','.addOptions',function(){
	var optionsObj = $('.options');
	var optionsLen = optionsObj.find("input[type=text]").length;
	var options = String.fromCharCode(64 + parseInt(optionsLen + 1));
	optionsDeleteHtml = optionsLen >= 2 ? optionsDeleteHtml : '';
	var optionHtml = optionsHtmlStart.format(parseInt(optionsLen + 1))  + optionsDeleteHtml + optionsHtmlEnd ;
	optionsObj.append(optionHtml);
	$('.right-anwswer').append(rightAnswerHtml.format(Math.pow(2,optionsLen),options));
});
$(document).on('click','.del-questoption',function(){
	$(this).parent('p').remove();
	initRightAnswerHtml('');
});
$(document).on('click','.rightAnswer--label',function(){
	var rightAnwswerObj = $('.right-anwswer');
	var optionsTypeVal = $('input[type=radio]:checked').val();
	var rightAnswerCheckedBoxObj = $('.right-anwswer').find('input[type=checkbox]:checked');
	if(optionsTypeVal == 'radio' || optionsTypeVal == 'trueOrfalse' ){
		$('.right-anwswer').find('input[type=checkbox]:checked').prop('checked',false);
		$(this).find('input[type=checkbox]').prop('checked',true);
	};
});

$(document).on('click','input[name="optionsType"]',function(){
	$(".addOptions").show();
	initRightAnswerHtml('');
	if($(this).val() == 'radio'){
		$('.right-anwswer').find('input[type=checkbox]:checked').prop('checked',false);
	}
	if($(this).val() == 'trueOrfalse'){
		initRightAnswerHtml('trueOrfalse');
		$(".addOptions").hide();
	}
})

function initRightAnswerHtml(type)
{
	$('.right-anwswer').empty();
	var optionsObj = $('.options');
	if(type != 'trueOrfalse'){
		var optionsLen = optionsObj.find("input[type=text]").length;
		for (var i = 0 ; i < optionsLen;i++) {
			var options = String.fromCharCode(64 + parseInt(i + 1));
			$(optionsObj.find("input[type=text]")[i]).attr('placeholder','选项'+(i+1));
			$('.right-anwswer').append(rightAnswerHtml.format(Math.pow(2,i),options));
		}
		return;
	}
	$('.options').empty();
	for (var i = 0 ; i < 2;i++) {
		var options = String.fromCharCode(64 + parseInt(i + 1));
		var optionHtml = optionsHtmlStart.format((i+1))  + optionsHtmlEnd ;
		optionsObj.append(optionHtml);
		
		$(optionsObj.find("input[type=text]")[i]).attr('placeholder','选项'+(i+1));
		if(i==0){
			$('.right-anwswer').append(rightAnswerHtml_tf.format(Math.pow(2,i),'正确'));
		}else{
			$('.right-anwswer').append(rightAnswerHtml_tf.format(Math.pow(2,i),'错误'));
		}
		
	}
}