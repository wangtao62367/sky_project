
;(function(){
	//关闭弹出层
	$(document).on('click','.tiptop a,.cancel',function(){
		$(".tip").remove();
	});
	var dialog = {
		init : function(title,content,btn,sureCallBack,cancleCallBack){
			title = title || '提示信息';
			btn = btn || true;
			var tip = $("<div></div>").addClass('tip');
			console.log(title);
			var tiptop = $('<div></div>').addClass('tiptop').html('<span>'+title+'</span><a></a>');
			var tipinfo = $('<div></div>').addClass('tipinfo').html(content);
			tipbtn = '';
			if(btn){
				var tipbtn = $('<div></div>').addClass('tipbtn').append('<input name="" type="button"  class="sure" value="确定" />&nbsp;').append('<input name="" type="button"  class="cancel" value="取消" />');
			}
			
			tip.append(tiptop,tipinfo,tipbtn).show();
			
			$(document).find('body').append(tip);
			if(sureCallBack){
				$(".sure").click(function(){
					sureCallBack();
				})
			}else{
				$(".sure").click(function(){
					tip.remove();
				})
			}
			if(cancleCallBack){
				$(".cancel").click(function(){
					cancleCallBack();
				})
			}
		}
	};
	window.d = dialog;
})(window);
