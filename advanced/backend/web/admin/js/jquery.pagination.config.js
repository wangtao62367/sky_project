/**
 * 基于jquery.pagination.js 统一配置参数
 * @autor WT by 2017-11-21
 */
(function(root,factory,plug){
	return factory(root.jQuery,plug);
})(window,function($,plug){
	__FN__ = {
		changeURLArg: function (url,arg,arg_val){ 
		   var pattern=arg+'=([^&]*)'; 
		   var replaceText=arg+'='+arg_val; 
		   if(url.match(pattern)){ 
		       var tmp='/('+ arg+'=)([^&]*)/gi'; 
		       tmp=url.replace(eval(tmp),replaceText); 
		       return tmp; 
		   }
	       if(url.match('[\?]')){ 
	           return url+'&'+replaceText; 
	       }else{ 
	           return url+'?'+replaceText; 
	       } 
		    
		}
	};
	
	$.fn[plug] = function(options){
		this.pagination({
		    totalData : options.totalData,
		    showData  : options.showData,
		    current   : options.current,
		    jump:true,
		    coping:true,
		    isHide:true,
		    homePage:'首页',
		    endPage:'末页',
		    prevContent:'上页',
		    nextContent:'下页',
		    callback:function(api){
		        if(location.href.indexOf('curPage=') != -1){
		            location.href = __FN__.changeURLArg(location.href,'curPage',api.getCurrent());
		            return;
		        }
		        var search;
		        if(location.search){
		            search = location.search + '&curPage=' + api.getCurrent();
		        }else{
		            search = '?curPage=' + api.getCurrent();
		        }
		        location.href = location.origin + location.pathname + search;
		    }
		});
	}
	
},"paginationCfg");