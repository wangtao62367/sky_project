/**
 * 基于jquery 实现的一些特效
 * create by wangtao 2017-11-01 15:46:00
 */
$(function(){
	$('.nav-memu-title').click(function(ev){
		if($(this).hasClass('is-opened')){
		    $(this).removeClass('is-opened').parent().find('i').removeClass('ico_up').addClass('ico_down');
		    $(this).parent().find('ul').hide(400);
		}else{
			$('.nav-memu-title').removeClass('is-opened').parent().find('ul').hide(400);
			$('.nav-memu-title').parent().find('i').removeClass('ico_up').addClass('ico_down');
			$(this).addClass('is-opened').parent().find('i').removeClass('ico_down').addClass('ico_up');
			$(this).parent().find('ul').show(400);
		}
	});
	
	$(document).on("click",".modal-close",function(){
		$(this).parent().parent(".dialog").remove();
	});
	
})

var showDialog = function (title,content,width,height,modal){
	var $body = $("body");
	title = title || '标题';
	content = content || '主要内容';
	width = width || 200;
	height = height || 100;
	var top = 2 * height/3;
	var left = width/2;
	modal = modal || false;
	var dialogDiv = [
		'<div class="dialog">',
			modal === true ? '<div class="modal"></div>' : '',
				'<div class="modal-body" style="width: '+width+'px;height: '+height+'px;margin-top:-'+top+'px ;margin-left: -'+left+'px;">',
					'<div class="modal-header">',
						title,
					'</div>',
					'<div class="modal-content">',
						content,
					'</div>',
					'<p class="modal-close">X</p>',
				'</div>',
			'</div>',
		'</div>'
	].join("");
	$body.append(dialogDiv)
};