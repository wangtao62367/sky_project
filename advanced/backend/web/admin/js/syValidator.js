/**
* 基于jquery实现表单数据校验插件
* creaty by wangtao 
* date 2017-11-02
*/
(function(root,factory,plug){
	return factory(root.jQuery,plug);
})(window,function($,plug){
	//默认参数
	var __DEFS__ = {
		trigger : "change",
		plugName: "sy"
	};
	//规则引擎
	var __RULES__ = {
		required : function(){
			return this.val() !== "";
		},
		regex : function() {
			return new RegExp(this.data("sy-regex")).test(this.val());
		} ,
		email : function(){
			return /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/.test(this.val());
		},
		uri : function(){
			console.log("uri");
			return /^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/.test(this.val());
		},
	};
	//创建syValidator插件
	$.fn[plug] = function(options){
		$.extend(this,__DEFS__,options);
		var $fileds = $(this).find("input").not("[type=button],[type=reset],[type=submit]");
		$fileds.on(options.trigger,function(){
			var $field = $(this);
			var result = true;//验证结果默认通过
			$field.next("p").remove();
			$.each(__RULES__, function(rule,valider) {
				if($field.data(this.plugName + "-" + rule)){
					//验证rule规则
					//console.log($field.attr("name")+"需要验证的规则是："+rule);
                    result = valider.call($field);
                    if(!result){
                    	$field.after("<p>"+$field.data(this.plugName + "-"  + rule + "-message")+"</p>")
                    	//console.log(rule + "验证失败,提示信息"+$field.data("sy-"+rule+"-message"));
                    }
                    return result
				}
				
			});
		});
	}
},"syValidator");
