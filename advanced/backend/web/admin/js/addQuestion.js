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
$(document).on('click','.createNewQuestion',function(){
	$(document).find('body').append(tipHtml);
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

$(document).on('click','input[name="optionsType"]',function(){
	if($(this).val() == 'radio'){
		$('.right-anwswer').find('input[type=checkbox]:checked').prop('checked',false);
	}
})
